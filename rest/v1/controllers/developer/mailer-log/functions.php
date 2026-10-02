<?php

// filter by audience
function checkFilterByAudience($object)
{
    $query = $object->filterByAudience();
    checkQuery($query, "Empty records. (filter by audience)");
    return $query;
}

// filter by status and search 
function checkFilterByStatusSentOrFailedAndSearch($object)
{
    $query = $object->filterByStatusSentOrFailedAndSearch();
    checkQuery($query, "Empty records. (filter by status and search)");
    return $query;
}

// filter by audience and search 
function checkFilterByAudienceAndSearch($object)
{
    $query = $object->filterByAudienceAndSearch();
    checkQuery($query, "Empty records. (filter by audience and search)");
    return $query;
}

// update mailer log 
function checkUpdateMailerLog($object)
{
    $query = $object->updateMailerLog();
    checkQuery($query, "There's a problem processing your request. (update mailer log)");
    return $query;
}

// update mailer log subject and content
function checkUpdateMailerSubjectAndContent($object)
{
    $query = $object->updateMailerSubjectAndContent();
    checkQuery($query, "There's a problem processing your request. (update subject and content)");
    return $query;
}

// update resend newsletter
function checkUpdateResendDate($object)
{
    $query = $object->updateResendDate();
    checkQuery($query, "There's a problem processing your request. (update resend newsletter)");
    return $query;
}

// delete mailer log
function checkDeleteMailerLog($object)
{
    $query = $object->deleteMailerLog();
    checkQuery($query, "There's a problem processing your request. (delete mailer log)");
    return $query;
}

// delete mailer log by subject
function checkDeleteBySubject($object)
{
    $query = $object->deleteBySubject();
    checkQuery($query, "There's a problem processing your request. (delete by subject)");
    return $query;
}


// Filter by date
function checkFilterByDate($object)
{
    $query = $object->filterByDate();
    checkQuery($query, "Empty records. (filter by date)");
    return $query;
}


// Filter by audience and date
function checkFilterByAudienceAndDate($object)
{
    $query = $object->filterByAudienceAndDate();
    checkQuery($query, "Empty records. (filter by audience and all date)");
    return $query;
}

// Filter by search, status and date
function checkFilterBySearchStatusAndDate($object)
{
    $query = $object->filterBySearchStatusAndDate();
    checkQuery($query, "Empty records. (filter by search, status and date)");
    return $query;
}

// Filter by search, audience and date
function checkFilterBySearchAudienceAndDate($object)
{
    $query = $object->filterBySearchAudienceAndDate();
    checkQuery($query, "Empty records. (filter by search, audience and date)");
    return $query;
}

// filter search and date
function checkFilterBySearchAndDate($object)
{
    $query = $object->searchAndDate();
    checkQuery($query, "Empty records. (filter by search and date)");
    return $query;
}


// filter by status and date
function checkFilterByStatusAndDate($object)
{
    $query = $object->filterByStatusAndDate();
    checkQuery($query, "Empty records. (filter by date and status)");
    return $query;
}

// filter by audience and date
function checkFilterByAudienceAndDateTo($object)
{
    $query = $object->filterByAudienceAndDateTo();
    checkQuery($query, "Empty records. (filter by date to, and audience)");
    return $query;
}

// filter search and date from 
function checkFilterSearchAndDateFrom($object)
{
    $query = $object->searchAndDateFrom();
    checkQuery($query, "Empty records. (filter by search and date from)");
    return $query;
}
