<?php
session_start();
include 'connectDB.php';
$appID = $_GET['appID'];
$remAppQuery = "DELETE FROM `applience` WHERE `ApplienceID` = '$appID'";
mysqli_query($conn,$remAppQuery);
mysqli_close($conn);


?>