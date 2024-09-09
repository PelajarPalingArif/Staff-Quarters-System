<?php
session_start();

$AppName = $_POST['inputAppName'];
$AppDesc = $_POST['inputAppDesc'];
include "connectDB.php";
$insertBuildQuery = "INSERT INTO `applience` (`ApplienceName`,`Description`) VALUES ('$AppName','$AppDesc')";
mysqli_query($conn,$insertBuildQuery);
mysqli_close($conn);
?>