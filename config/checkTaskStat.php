<?php

//UPDATE TASK LAST CHECKED
include 'connectDB.php';
$todayDate = new DateTime();
$todayDateString = $todayDate->format("d/m/Y");

$getLastDateCheckQuery = "SELECT `LastChecked` FROM `tasktype`";
$result = mysqli_query($conn, $getLastDateCheckQuery);
$row = mysqli_fetch_assoc($result);
$databaseDate = $row['LastChecked'];
$lastCheckedDate = new DateTime($databaseDate);
$lastCheckedDateString = $lastCheckedDate->format('d/m/Y');
// echo "Today Date : $todayDateString<br>Last Check : $lastCheckedDateString<br>";

if($lastCheckedDate->diff($todayDate)->days != 0) {
    updateTask(1);
    $isoWeekTodayDate = $todayDate->format('W');
    $isoWeekLastCheckedDate = $lastCheckedDate->format('W');
    if($isoWeekLastCheckedDate != $isoWeekTodayDate){
        updateTask(2);
    }
    else {
        // echo "<br> Same Week <br>";
    }

    $todayDateMonth = $todayDate-> format("m");
    $lastCheckedDateMonth = $lastCheckedDate-> format("m");
    $todayDateYear = $todayDate-> format("Y");
    $lastCheckedDateYear = $lastCheckedDate-> format("Y");
    
    if($todayDateMonth != $lastCheckedDateMonth || $todayDateYear != $lastCheckedDateYear){
        updateTask(3);
    }
    else {
        // echo "<br> Same Month, Same Year <br>";
    }
    $dateUpdate = $todayDate->format("Y-m-d");
    $updateDateQuery = "UPDATE `tasktype` SET `LastChecked` = '$dateUpdate'";
    mysqli_query($conn,$updateDateQuery);
    mysqli_close($conn);

    


}
/*
Daily = 1;
Weekly = 2;
Monthly = 3
*/

function updateTask($taskType) {
    include 'connectDB.php';
    // echo "<br>Updated Task : $taskType<br>";
    $updateTaskQuery = "UPDATE `task` SET `Status` = '1' WHERE `TaskTypeID` = '$taskType'";
    mysqli_query($conn,$updateTaskQuery);
    mysqli_close($conn);
}

