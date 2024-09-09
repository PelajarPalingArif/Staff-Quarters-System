<?php
include "connectDB.php";

$TypeTask = $_GET['type'];

$getTaskQuery = "SELECT * FROM `task` WHERE `TaskTypeID` = '$TypeTask'";
$getTaskResult = mysqli_query($conn, $getTaskQuery);


if (mysqli_num_rows($getTaskResult) > 0) {
    $tasks = array();
    while ($row = mysqli_fetch_assoc($getTaskResult)) {
        $tasks[] = $row;
    }
    echo json_encode($tasks);
} else {
    
    echo json_encode(array());
}

mysqli_close($conn);
?>
