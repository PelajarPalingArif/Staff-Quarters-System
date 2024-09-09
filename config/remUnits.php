<?php
include 'connectDB.php';
$UnitIDRem = $_GET['unitID'];
$remUnitQuery = "DELETE FROM `unit` WHERE `UnitID` = '$UnitIDRem'";
mysqli_query($conn,$remUnitQuery);
mysqli_close($conn);


?>