import { useQueryClient } from "@tanstack/react-query";
import React from "react";
import { GrFormClose } from "react-icons/gr";
import { MdDelete } from "react-icons/md";
import { apiVersion } from "../../../../helpers/functions-general";
import { queryData } from "../../../../helpers/queryData";
import ButtonSpinner from "../../../../partials/spinners/ButtonSpinner";
import { setError, setMessage, setSuccess } from "../../../../store/StoreAction";
import { StoreContext } from "../../../../store/StoreContext";

const ModalDeleteMultiple = ({
  recipientList,
  setIsDeleteMultiple,
  setRecipientList,
  setIsCheck,
  setIsCheckAll,
  queryKey,
}) => {
  const { dispatch } = React.useContext(StoreContext);
  const [isDeleting, setIsDeleting] = React.useState(false);
  const [deletedCount, setDeletedCount] = React.useState(0);
  const cancelRef = React.useRef(false);
  const queryClient = useQueryClient();

  const handleClose = () => {
    if (isDeleting) {
      cancelRef.current = true;
      return;
    }
    setIsDeleteMultiple(false);
  };

  const handleYes = async () => {
    setIsDeleting(true);
    setDeletedCount(0);
    cancelRef.current = false;

    let hasError = false;
    let processed = 0;
    for (let i = 0; i < recipientList.length; i++) {
      if (cancelRef.current) break;

      const item = recipientList[i];
      const response = await queryData(
        `${apiVersion}/mailer-log/delete-mailer/${item.sending_email_log_aid}`,
        "delete",
        { item: item.sending_email_log_subject }
      );
      if (!response?.success) hasError = true;
      processed = i + 1;
      setDeletedCount(processed);
    }

    const wasCancelled = cancelRef.current;
    cancelRef.current = false;

    queryClient.invalidateQueries({ queryKey: [queryKey] });
    setIsDeleting(false);
    setIsDeleteMultiple(false);
    setIsCheck(false);
    setIsCheckAll(false);
    setRecipientList([]);

    if (wasCancelled) {
      dispatch(setSuccess(true));
      dispatch(
        setMessage(`Cancelled. ${processed} of ${recipientList.length} deleted.`)
      );
    } else if (hasError) {
      dispatch(setError(true));
      dispatch(setMessage("Some records could not be deleted."));
    } else {
      dispatch(setSuccess(true));
      dispatch(setMessage("Successfully Deleted!"));
    }
  };

  return (
    <div className="fixed top-0 left-0 h-screen w-full flex justify-center items-center z-[9999999]">
      <div
        className="backdrop bg-dark/50 h-full w-full absolute top-0 left-0 z-[-1]"
        onClick={handleClose}
      ></div>
      <div className="max-w-[450px] w-full bg-[white] rounded-md">
        <div className="flex justify-between p-4 pb-2 ">
          <div></div>
          <h2 className="translate-y-2 translate-x-2 items-center">
            <MdDelete className="mx-auto text-warning w-12 h-12" />
          </h2>
          <button
            onClick={handleClose}
            className="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-6 h-8"
          >
            <GrFormClose className="text-[25px]" />
          </button>
        </div>
        <div className="p-5 text-center">
          {isDeleting ? (
            <>
              <h3 className="text-sm pb-3 text-[black] flex items-center justify-center gap-2">
                <ButtonSpinner color="text-gray-400" />
                Deleting {deletedCount} of {recipientList?.length}...
              </h3>
              <div className="w-full bg-gray-200 rounded-full h-2">
                <div
                  className="bg-primary h-2 rounded-full transition-all duration-200"
                  style={{
                    width: `${(deletedCount / recipientList?.length) * 100}%`,
                  }}
                ></div>
              </div>
            </>
          ) : (
            <h3 className="text-sm pb-2 text-[black]">
              Are you sure you want to delete {recipientList?.length} selected{" "}
              {recipientList?.length === 1 ? "email" : "emails"}?
            </h3>
          )}
          <div className="flex justify-center mt-5 gap-2">
            <button
              className="text-sm btn-modal-submit"
              onClick={handleYes}
              disabled={isDeleting}
            >
              {isDeleting ? <ButtonSpinner /> : "Delete"}
            </button>
            <button className="text-sm btn-modal-cancel" onClick={handleClose}>
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ModalDeleteMultiple;
