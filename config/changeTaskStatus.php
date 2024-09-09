<?php
include 'connectDB.php';
$taskID = $_POST['taskID'];
$status = ($_POST['status'] == "true") ? 0:1;
$updateStatusQuery = "UPDATE `task` SET `Status` = $status WHERE `TaskID` = '$taskID'";
mysqli_query($conn,$updateStatusQuery);
mysqli_close($conn);
