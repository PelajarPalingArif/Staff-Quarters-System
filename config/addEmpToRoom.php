<?php
session_start();
$empID = $_POST['empID'];
$roomID = $_POST['roomID'];
include "connectDB.php";
$insertAddEmpToRoomQuery = "UPDATE `rooms` SET `EmployeeID` = '$empID',`Status` = 0 WHERE `RoomID` = '$roomID';";
mysqli_query($conn,$insertAddEmpToRoomQuery);
mysqli_close($conn);
?>