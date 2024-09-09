<?php 
include("connectDB.php");
$query = "SELECT * FROM `Unit`";
$result = mysqli_query($conn,$query);
$numOfUnit = mysqli_num_rows($result);
mysqli_close($conn);

?>