<?php
session_start();
include 'connectDB.php';
$roomAppID = $_GET['roomAppID'];
$remQuery = "DELETE FROM `rooms_applience` WHERE `Rooms_ApplienceID` =  '$roomAppID'";
mysqli_query($conn,$remQuery);
mysqli_close($conn);

?>      