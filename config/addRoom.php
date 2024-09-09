<?php
session_start();
include "connectDB.php";
$unitID1 = $_GET['unitID'];
$insertBuildQuery = "INSERT INTO `rooms` (`Status`,`EmployeeID`,`UnitID`) VALUES (1,NULL,'$unitID1')";
mysqli_query($conn,$insertBuildQuery);
mysqli_close($conn);
?>