<?php
include("connectDB.php");

$eID = $_POST['idinput'];
$eName = $_POST['nameinput'];
$Pass = $_POST['passinput'];
$ePosi = $_POST['posiinput'];
$eLocation = $_POST['locainput'];
$eGrade = $_POST['namegrade'];
$eImage = $_FILES["imageinput"]["name"];
$ePhone = $_POST['phoneinput'];
$eLocker = $_POST['lockerinput'];

if($eImage == ""){
    $eImage = "noImage.png";
}
else{
// SAVING IMAGE TO image/employee/
$target_dir = "../image/employee/";
$target_file = $target_dir . basename($_FILES["imageinput"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["imageinput"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }


// Check if file already exists
if (file_exists($target_file)) {
  if(unlink($target_file)){

  }
  else {
  $uploadOk = 0;
  }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $eImage = "noImage.png";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["imageinput"]["tmp_name"], $target_file)) {
    //Renaming Image File to [EmployeeNumber] + image
    rename($target_file,"../image/employee/".$eID."image.".$imageFileType);
    $eImage = $eID."image.".$imageFileType;
  } else {
    $eImage = "noImage.png";
  }
}
}
// END SAVING IMAGE TO image/employee/

$ePriv = 2;
switch ($eGrade) {
    case "AA":
        $ePriv = 0;
        break;
    case "BB":
    case "BB1":
    case "BB2":
    case "CC":
    case "CC1":
        $ePriv = 1;
        break;
    case "CC2":
    case "DD":
    case "RF":
        $ePriv = 2;
        break;
    default:
        $ePriv = 2;
        break;
}

$fetchEnc = "SELECT * FROM `encryption` WHERE `EncryptID` = 1";
$fetchEncResult = mysqli_query($conn, $fetchEnc);
$row = mysqli_fetch_array($fetchEncResult);

$encMethod = $row["1"];
$iniVector = $row["2"];
$encKey = $row["3"];

$passEncrypt = openssl_encrypt($Pass, $encMethod, $encKey, 0, $iniVector);

$insertQuery = "INSERT INTO `employee` VALUES ('$eID','$passEncrypt','$ePriv','$ePosi','$eLocation','$eName','$eGrade','$eImage','$ePhone','$eLocker')";
mysqli_query($conn, $insertQuery);
mysqli_close($conn);
