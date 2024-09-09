<?php
include 'connectDB.php';
$roomIDRem = $_GET['roomID'];
$remRoomQuery = "DELETE FROM `rooms` WHERE `RoomID` = '$roomIDRem'";
mysqli_query($conn,$remRoomQuery);
mysqli_close($conn);
?>