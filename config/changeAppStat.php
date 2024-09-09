<?php
session_start();
include 'connectDB.php';
$r_appID = $_GET['room_appID'];
$stat = $_GET['val'];
$changeAppStatQuery = "UPDATE `rooms_applience` SET `Status` = '$stat' WHERE `Rooms_ApplienceID` = '$r_appID'";
mysqli_query($conn,$changeAppStatQuery);
mysqli_close($conn);
?>