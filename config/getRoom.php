<?php
include("connectDB.php");
$vacquery = "SELECT * FROM `Rooms` WHERE `Status` = '1'";
$occquery = "SELECT * FROM `Rooms` WHERE `Status` = '0'";
$vacresult = mysqli_query($conn,$vacquery);
$occresult = mysqli_query($conn,$occquery);
$vacantRoom = mysqli_num_rows($vacresult);
$occupiedRoom = mysqli_num_rows($occresult);

mysqli_close($conn);
?>