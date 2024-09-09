<?php
session_start();
include 'connectDB.php';
$roomID = $_GET['room'];
$appID = $_GET['appID'];
$insertAppRoomQuery = "INSERT INTO `rooms_applience`(`RoomID`,`ApplienceID`,`Status`) VALUES ('$roomID','$appID',0)";   
mysqli_query($conn,$insertAppRoomQuery);
mysqli_close($conn);

?>