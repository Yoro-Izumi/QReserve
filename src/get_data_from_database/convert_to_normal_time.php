<?php
function convertToNormalTime($militaryTime) {
    $dateTime = DateTime::createFromFormat('H:i:s', $militaryTime);
    return $dateTime->format('h:i A');
}

function convertToNormalDate($date) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    if ($dateTime === false) {
        return "Invalid date format";
    }
    return $dateTime->format('F j, Y');
}
?>