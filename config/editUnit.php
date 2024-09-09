<?php
session_start();
include 'connectDB.php';
echo $_POST["unitIDPlaceHolder"].$_POST['inputEditRoom'];
$unitID = $_POST["unitIDPlaceHolder"];
$unitName = $_POST['inputEditRoom'];
$editUnitQuery = "UPDATE `unit` SET `UnitCode` = '$unitName' WHERE `UnitID` = '$unitID'";
mysqli_query($conn,$editUnitQuery);
mysqli_close($conn);
?>