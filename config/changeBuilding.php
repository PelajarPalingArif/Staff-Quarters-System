<?php
session_start();
include 'connectDB.php';
$buildID = $_GET['buildID'];
$buildName = $_GET['buildName'];
$changeBuildQuery = "UPDATE `buildingblock` SET `BuildingName` = '$buildName' WHERE `BuildingBlockID` = '$buildID'";
mysqli_query($conn,$changeBuildQuery);
mysqli_close($conn);
?>