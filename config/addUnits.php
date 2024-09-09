<?php
session_start();

$buildID = $_POST['buildname'];
$unitcode = $_POST['inputUnitCode'];
include "connectDB.php";
$insertUnitQuery = "INSERT INTO `unit` (`BuildingBlockID`,`UnitCode`) VALUES ('$buildID','$unitcode')";
mysqli_query($conn,$insertUnitQuery);
mysqli_close($conn);
?>