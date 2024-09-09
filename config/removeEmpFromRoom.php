<?php
session_start();
$roomID = $_POST['roomID'];
include "connectDB.php";
$remEmpFromRoomQuery = "UPDATE `rooms` SET `EmployeeID` = null,`Status` = 1 WHERE `RoomID` = '$roomID';";
mysqli_query($conn,$remEmpFromRoomQuery);
mysqli_close($conn);
?>