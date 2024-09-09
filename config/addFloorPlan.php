<?php
include "connectDB.php";
$buildID = $_POST['BuildingID'];
// $floorPlanImage = $_FILES["formFile"]["name"];


$insertQuery = "INSERT INTO `floorplan` (`BuildingBlockID`) VALUES ('$buildID')";
$getFloorIDQuery = "SELECT `FloorPlanID` FROM `floorplan` ORDER BY `FloorPlanID` DESC LIMIT 1";
mysqli_query($conn,$insertQuery);
$getFloorIDResult = mysqli_query($conn,$getFloorIDQuery);
$floorPlanID = "";
if($getFloorIDResult){
    
    $row = mysqli_fetch_assoc($getFloorIDResult);
    $floorPlanID = $row['FloorPlanID'];

    $originalFileExtension = pathinfo(basename($_FILES["formFile"]["name"]),PATHINFO_EXTENSION);
    $targetDir = "../image/floorplan/";
    $fileNameToBe = $floorPlanID."Image".".".$originalFileExtension;
    $targetFilePath = $targetDir.$fileNameToBe;

    
    $updateFileImageQuery = "UPDATE `floorplan` SET `FloorDiagram` = '$fileNameToBe' WHERE `FloorPlanID` = $floorPlanID" ;
    move_uploaded_file($_FILES["formFile"]["tmp_name"],$targetFilePath);
    mysqli_query($conn,$updateFileImageQuery);
}




mysqli_close($conn);

?>