<?php
include("connectDB.php");
$query = "SELECT * FROM `Employee`";
$result = mysqli_query($conn,$query);
$Room = mysqli_num_rows($result);
$numEmployee = mysqli_num_rows($result);
mysqli_close($conn);
?>