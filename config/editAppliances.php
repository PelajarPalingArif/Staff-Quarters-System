<?php
session_start();
include 'connectDB.php';
$appID = $_POST['appIdPlaceholder'];
$appName = $_POST['inputEditAppName'];
$appDesc = $_POST['inputEditAppDesc'];
$editAppQuery = "UPDATE `applience` SET `ApplienceName` = '$appName',`Description` = '$appDesc' WHERE `ApplienceID` = '$appID'";
mysqli_query($conn,$editAppQuery);
mysqli_close($conn);
?>