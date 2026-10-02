import { useMutation, useQueryClient } from "@tanstack/react-query";
import React from "react";
import { GrFormClose } from "react-icons/gr";
import { MdDelete } from "react-icons/md";
import { apiVersion } from "../../../../helpers/functions-general";
import { queryData } from "../../../../helpers/queryData";
import ButtonSpinner from "../../../../partials/spinners/ButtonSpinner";
import { setError, setMessage, setSuccess } from "../../../../store/StoreAction";
import { StoreContext } from "../../../../store/StoreContext";

const ModalDeleteBySubject = ({
  subject,
  setIsDeleteBySubject,
  setSelectedSubject,
  queryKey,
}) => {
  const { dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

  const handleClose = () => {
    setIsDeleteBySubject(false);
  };

  const mutation = useMutation({
    mutationFn: () =>
      queryData(`${apiVersion}/mailer-log/delete-by-subject`, "delete", {
        sending_email_log_subject: subject,
      }),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: [queryKey] });
      setIsDeleteBySubject(false);

      if (!data?.success) {
        dispatch(setError(true));
        dispatch(setMessage(data?.error));
      } else {
        setSelectedSubject("");
        dispatch(setSuccess(true));
        dispatch(setMessage("Successfully Deleted!"));
      }
    },
  });

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
          <h3 className="text-sm pb-2 text-[black]">
            Are you sure you want to delete all emails with the subject "
            {subject}"?
          </h3>
          <div className="flex justify-center mt-5 gap-2">
            <button
              className="text-sm btn-modal-submit"
              onClick={() => mutation.mutate()}
              disabled={mutation.isPending}
            >
              {mutation.isPending ? <ButtonSpinner /> : "Delete"}
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

export default ModalDeleteBySubject;
