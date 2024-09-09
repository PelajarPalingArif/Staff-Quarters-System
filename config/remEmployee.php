<?php
include 'connectDB.php';
$empID = $_GET['empID'];

$empPicQuery = "SELECT `ImageLink` FROM `employee` WHERE `EmployeeID` = '$empID'";
$empPicResult = mysqli_query($conn,$empPicQuery);
$row = mysqli_fetch_assoc($empPicResult);
$ImageFileName = $row['ImageLink'];
if($ImageFileName != "noImage.png"){
unlink("../image/employee/".$ImageFileName);
}

$setRoomStatusToVacQuery = "UPDATE `rooms` SET `Status` = 1 WHERE `EmployeeID` = '$empID'";
mysqli_query($conn,$setRoomStatusToVacQuery);
$remEmployeeQuery = "DELETE FROM `employee` WHERE `EmployeeID` = '$empID'";
mysqli_query($conn,$remEmployeeQuery);

mysqli_close($conn);
?>