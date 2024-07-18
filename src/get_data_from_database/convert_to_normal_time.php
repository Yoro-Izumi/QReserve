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
    return $dateTime->format('F d, Y'); // Changed 'j' to 'd' to add leading zero
}

function dateDifference($firstDate,$secondDate){

    // Create DateTime objects for the two dates
    //$date1 = new DateTime("2023-01-01");
    //$date2 = new DateTime("2023-07-09");
    $date1 = new DateTime($firstDate);
    $date2 = new DateTime($secondDate);

    // Calculate the difference between the two dates
    $interval = $date1->diff($date2);

    // Get the difference in days
    $days = $interval->days;

    return $days;
}
?>