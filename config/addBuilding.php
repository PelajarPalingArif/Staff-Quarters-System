<?php
session_start();

$BuildName = $_POST['inputBuildName'];
include "connectDB.php";
$insertBuildQuery = "INSERT INTO `buildingblock` (`BuildingName`) VALUES ('$BuildName')";
mysqli_query($conn,$insertBuildQuery);
mysqli_close($conn);
?>