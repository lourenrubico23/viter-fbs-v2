<?php

class MailerLog
{
    public $sending_email_log_aid;
    public $sending_email_log_is_active;
    public $sending_email_log_audience_id;
    public $sending_email_log_email;
    public $sending_email_log_subject;
    public $sending_email_log_content;
    public $sending_email_log_is_success;
    public $sending_email_log_firstname_resend;
    public $sending_email_log_role_resend;
    public $sending_email_log_created;
    public $sending_email_log_datetime;

    public $connection;
    public $lastInsertedId;

    public $sending_email_log_start;
    public $sending_email_log_total;
    public $sending_email_log_search;
    public $month;
    public $year;

    public $tblSendingEmailLog;
    public $tblNotification;

    public function __construct($db)
    {
        $this->connection = $db;
        $this->tblSendingEmailLog = "fbsv2_sending_email_log";
        $this->tblNotification = "fbsv2_notification";
    }

    public function readAll()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "order by sending_email_log_created desc ";
            $query = $this->connection->query($sql);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function readLimit()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "order by sending_email_log_created desc ";
            $sql .= "limit :start, ";
            $sql .= ":total ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "start" => $this->sending_email_log_start - 1,
                "total" => $this->sending_email_log_total,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function search()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblSendingEmailLog} ";
            $sql .= "where (";
            $sql .= "sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject) ";
            $sql .= "order by sending_email_log_created desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",

            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function updateMailerLog()
    {
        try {
            $sql = "update {$this->tblSendingEmailLog} set ";
            $sql .= "sending_email_log_email = :sending_email_log_email, ";
            $sql .= "sending_email_log_datetime = :sending_email_log_datetime ";
            $sql .= "where sending_email_log_aid = :sending_email_log_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_email" => $this->sending_email_log_email,
                "sending_email_log_datetime" => $this->sending_email_log_datetime,
                "sending_email_log_aid" => $this->sending_email_log_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function updateMailerSubjectAndContent()
    {
        try {
            $sql = "update {$this->tblSendingEmailLog} set ";
            $sql .= "sending_email_log_subject = :sending_email_log_subject, ";
            $sql .= "sending_email_log_content = :sending_email_log_content ";
            $sql .= "where sending_email_log_aid = :sending_email_log_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_subject" => $this->sending_email_log_subject,
                "sending_email_log_content" => $this->sending_email_log_content,
                "sending_email_log_aid" => $this->sending_email_log_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    //update resend date and resend by
    public function updateResendDate()
    {
        try {
            $sql = "update {$this->tblSendingEmailLog} set ";
            $sql .= "sending_email_log_datetime = :sending_email_log_datetime, ";
            $sql .= "sending_email_log_firstname_resend = :sending_email_log_firstname_resend, ";
            $sql .= "sending_email_log_role_resend = :sending_email_log_role_resend ";
            $sql .= "where sending_email_log_aid = :sending_email_log_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_datetime" => $this->sending_email_log_datetime,
                "sending_email_log_firstname_resend" => $this->sending_email_log_firstname_resend,
                "sending_email_log_role_resend" => $this->sending_email_log_role_resend,
                "sending_email_log_aid" => $this->sending_email_log_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function deleteMailerLog()
    {
        try {
            $sql = "delete from {$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_aid = :sending_email_log_aid ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_aid" => $this->sending_email_log_aid,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function deleteBySubject()
    {
        try {
            $sql = "delete from {$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_subject = :sending_email_log_subject ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_subject" => $this->sending_email_log_subject,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function filterByStatus()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblSendingEmailLog} ";
            $sql .= "where ";
            $sql .= "sending_email_log_is_success = :sending_email_log_is_success ";
            $sql .= "order by sending_email_log_created desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_is_success" => $this->sending_email_log_is_success,

            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    public function filterByAudience()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblSendingEmailLog} ";
            $sql .= "where ";
            $sql .= "sending_email_log_audience_id = :sending_email_log_audience_id ";
            $sql .= "order by sending_email_log_created desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_audience_id" => $this->sending_email_log_audience_id,

            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by status and search 
    public function filterByStatusSentOrFailedAndSearch()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblSendingEmailLog} ";
            $sql .= "where ";
            $sql .= "sending_email_log_is_success = :sending_email_log_is_success ";
            $sql .= "and (sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject ";
            $sql .= "or DATE_FORMAT(sending_email_log_created, '%M %e, %Y') LIKE :sending_email_log_created) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_is_success" => $this->sending_email_log_is_success,
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",
                "sending_email_log_created" => "%{$this->sending_email_log_search}%",
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by audience and search 
    public function filterByAudienceAndSearch()
    {
        try {
            $sql = "select ";
            $sql .= "* ";
            $sql .= "from {$this->tblSendingEmailLog} ";
            $sql .= "where ";
            $sql .= "sending_email_log_audience_id = :sending_email_log_audience_id ";
            $sql .= "and (sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject ";
            $sql .= "or DATE_FORMAT(sending_email_log_created, '%M %e, %Y') LIKE :sending_email_log_created) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email desc ";
            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_audience_id" => $this->sending_email_log_audience_id,
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",
                "sending_email_log_created" => "%{$this->sending_email_log_search}%",

            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by audience and date
    public function filterByAudienceAndDate()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_audience_id = :sending_email_log_audience_id ";
            $sql .= "and MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc, ";
            $sql .= "sending_email_log_created asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "year" => $year,
                "month" => $month,
                "sending_email_log_audience_id" => $this->sending_email_log_audience_id,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by search, status, and date
    public function filterBySearchStatusAndDate()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_is_success = :sending_email_log_is_success ";
            $sql .= "and MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year ";
            $sql .= "and (sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject ";
            $sql .= "or DATE_FORMAT(sending_email_log_created, '%M %e, %Y') LIKE :sending_email_log_created) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc, ";
            $sql .= "sending_email_log_created asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",
                "sending_email_log_created" => "%{$this->sending_email_log_search}%",
                "year" => $year,
                "month" => $month,
                "sending_email_log_is_success" => $this->sending_email_log_is_success,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by search, audience, and date
    public function filterBySearchAudienceAndDate()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_audience_id = :sending_email_log_audience_id ";
            $sql .= "and MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year ";
            $sql .= "and (sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject ";
            $sql .= "or DATE_FORMAT(sending_email_log_created, '%M %e, %Y') LIKE :sending_email_log_created) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc, ";
            $sql .= "sending_email_log_created asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",
                "sending_email_log_created" => "%{$this->sending_email_log_search}%",
                "year" => $year,
                "month" => $month,
                "sending_email_log_audience_id" => $this->sending_email_log_audience_id,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by status and date
    public function filterByStatusAndDate()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_is_success = :sending_email_log_is_success ";
            $sql .= "and (MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "year" => $year,
                "month" => $month,
                "sending_email_log_is_success" => $this->sending_email_log_is_success,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter by audience and date to
    public function filterByAudienceAndDateTo()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where sending_email_log_audience_id = :sending_email_log_audience_id ";
            $sql .= "and (MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "year" => $year,
                "month" => $month,
                "sending_email_log_audience_id" => $this->sending_email_log_audience_id,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter date
    public function filterByDate()
    {
        try {
            $sql = "select * ";
            $sql .= "from {$this->tblSendingEmailLog} ";
            $sql .= "where (MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "year" => $year,
                "month" => $month,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter search and date 
    public function searchAndDate()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where MONTH(sending_email_log_created) = :month ";
            $sql .= "and YEAR(sending_email_log_created) = :year ";
            $sql .= "and (sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject ";
            $sql .= "or DATE_FORMAT(sending_email_log_created, '%M %e, %Y') LIKE :sending_email_log_created) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc, ";
            $sql .= "sending_email_log_is_active asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",
                "sending_email_log_created" => "%{$this->sending_email_log_search}%",
                "year" => $year,
                "month" => $month,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }

    // filter search and date from 
    public function searchAndDateFrom()
    {
        try {
            $sql = "select * ";
            $sql .= "from ";
            $sql .= "{$this->tblSendingEmailLog} ";
            $sql .= "where MONTH(sending_email_log_created) = :month ";
            $sql .= "and (YEAR(sending_email_log_created) = :year ";
            $sql .= "or sending_email_log_email like :sending_email_log_email ";
            $sql .= "or sending_email_log_subject like :sending_email_log_subject ";
            $sql .= "or DATE_FORMAT(sending_email_log_created, '%M %e, %Y') LIKE :sending_email_log_created) ";
            $sql .= "order by sending_email_log_created desc, ";
            $sql .= "sending_email_log_email asc, ";
            $sql .= "sending_email_log_is_active asc ";

            // Extract year and month from "YYYY-MM"
            $year = substr($this->sending_email_log_created, 0, 4);  // e.g., "2025"
            $month = substr($this->sending_email_log_created, 5, 2); // e.g., "05"

            $query = $this->connection->prepare($sql);
            $query->execute([
                "sending_email_log_email" => "%{$this->sending_email_log_search}%",
                "sending_email_log_subject" => "%{$this->sending_email_log_search}%",
                "sending_email_log_created" => "%{$this->sending_email_log_search}%",
                "year" => $year,
                "month" => $month,
            ]);
        } catch (PDOException $ex) {
            $query = false;
        }
        return $query;
    }
}
