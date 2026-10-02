import React from "react";
import useQueryData from "../../../../custom-hooks/useQueryData";
import { apiVersion } from "../../../../helpers/functions-general";
import Dashboard from "../../../../partials/dashboard/Dashboard";
import Navigation from "../../../../partials/dashboard/Navigation";
import MailerLogTable from "./MailerLogTable";
import { setIsSubsOpen } from "../../../../store/StoreAction";
import { StoreContext } from "../../../../store/StoreContext";
import ModalError from "../../../../partials/modals/ModalError";
import ModalSuccess from "../../../../partials/modals/ModalSuccess";
import { FaFileExport } from "react-icons/fa";
import { handleExportMailerLog } from "./function-mailerlog";

const MailerLog = () => {
  const { store, dispatch } = React.useContext(StoreContext);

  const {
    isLoading: isLoading,
    isFetching: isFetching,
    error: error,
    data: audienceData,
  } = useQueryData(
    `${apiVersion}/audience`, // endpoint
    "get", // method
    "audience" // key
  );

  const { data: subscribeData } = useQueryData(
    `${apiVersion}/subscribe`, // endpoint
    "get", // method
    "subscribe" // key
  );

  const { data: mailerLogData } = useQueryData(
    `${apiVersion}/mailer-log`, // endpoint
    "get", // method
    "mailer-log" // key
  );

  React.useEffect(() => {
    dispatch(setIsSubsOpen(false));
  }, []);

  return (
    <>
      <section id="mailer-log" className="bg-[#f5f5f3]">
        <Navigation menu="subscribers" submenu="mailer-log" />
        <Dashboard>
          <div className="mx-5 pt-2">
            <div className="py-5 flex justify-between ">
              <div className="text-sm text-[black] font-semibold">
                <h2>Mailer Log</h2>
              </div>
              <div className="flex items-center gap-6 print:invisible">
                <button
                  type="button"
                  className="flex items-center text-primary gap-2 text-sm"
                  onClick={() => handleExportMailerLog(mailerLogData?.data)}
                >
                  <FaFileExport />
                  <span className="hover:underline ">Export</span>
                </button>
              </div>
            </div>
            <div className="pb-4">
              <MailerLogTable
                audienceData={audienceData}
                subscribeData={subscribeData}
                mailerLogData={mailerLogData}
              />
            </div>
          </div>
        </Dashboard>
      </section>

      {store.success && <ModalSuccess />}
      {store.error && <ModalError />}
    </>
  );
};

export default MailerLog;
