<?php
include 'connectDB.php';
$floorId = $_GET['floorID'];

$getImageFileQuery = "SELECT * FROM `floorplan` WHERE `FloorPlanID` = '$floorId'";
$getImageFileResult = mysqli_query($conn,$getImageFileQuery);
$row = mysqli_fetch_assoc($getImageFileResult);
$ImageFileName = $row['FloorDiagram'];
if(file_exists("../image/floorplan/".$ImageFileName)){
    unlink("../image/floorplan/".$ImageFileName);
}

$delQuery = "DELETE FROM `floorplan` WHERE `FloorPlanID` = '$floorId'";
mysqli_query($conn,$delQuery);
mysqli_close($conn);



