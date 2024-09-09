<?php
session_start();
include 'connectDB.php';
$appID = $_GET['appID'];
$getAppInfoQuery = "SELECT * FROM `applience` WHERE `ApplienceID` = '$appID'";
$getAppInfoResult = mysqli_query($conn,$getAppInfoQuery);
$rowGetAppInfoResult = mysqli_fetch_assoc($getAppInfoResult);
$AppliencesInfo = array(
    'name' => $rowGetAppInfoResult['ApplienceName'],
    'desc' => $rowGetAppInfoResult['Description']
); 
header('Content-type: application/json');
echo json_encode($AppliencesInfo);
mysqli_close($conn);

?>