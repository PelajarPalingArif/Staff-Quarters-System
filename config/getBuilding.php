<?php
include("connectDB.php");
$query = "SELECT * FROM `BuildingBlock`";
$result = mysqli_query($conn,$query);
$numOfBuilding = mysqli_num_rows($result);
mysqli_close($conn);



?>