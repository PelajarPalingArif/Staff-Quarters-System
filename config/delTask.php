<?php
include 'connectDB.php';
$taskID = $_GET['taskID'];
$delTaskQuery = "DELETE FROM `task` WHERE `TaskID` = $taskID";
mysqli_query($conn,$delTaskQuery);
mysqli_close($conn);
