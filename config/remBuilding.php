<?php
session_start();
include 'connectDB.php';
$buildID = $_GET['buildingID'];
$remBuildQuery = "DELETE FROM `buildingblock` WHERE `BuildingBlockID` = '$buildID'";
mysqli_query($conn,$remBuildQuery);
mysqli_close($conn);
?>