<?php
session_start();
include 'connectDB.php';
$appID = $_GET['appID'];
$selectAppQuery = "SELECT * FROM `applience` WHERE `ApplienceID` = '$appID'";
$selectAppResult = mysqli_query($conn,$selectAppQuery);
mysqli_close($conn);
$res = mysqli_fetch_assoc($selectAppResult);
echo $res['Description'];
?>