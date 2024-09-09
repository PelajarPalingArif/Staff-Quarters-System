<?php
include 'connectDB.php';
$empID = $_POST['changeIDEmpPlaceHolder'];
$empName = $_POST['changeNameInput'];
$empPass = $_POST['changePassInput'];
$empPhoneNumber = $_POST['changePhoneNumber'];
$empPositionInput = $_POST['changePositionInput'];
$empLocationInput = $_POST['changeLocationInput'];
$empLocker = $_POST['changeLocker'];
$empGrade = $_POST['changeGrade'];

$fetchEnc = "SELECT * FROM `encryption` WHERE `EncryptID` = 1";
$fetchEncResult = mysqli_query($conn, $fetchEnc);
$row = mysqli_fetch_array($fetchEncResult);

$encMethod = $row["1"];
$iniVector = $row["2"];
$encKey = $row["3"];

$passEncrypt = openssl_encrypt($empPass, $encMethod, $encKey, 0, $iniVector);

$empPriv = 2;
switch ($empGrade) {
    case "AA":
        $empPriv = 0;
        break;
    case "BB":
    case "BB1":
    case "BB2":
    case "CC":
    case "CC1":
        $empPriv = 1;
        break;
    case "CC2":
    case "DD":
    case "RF":
        $empPriv = 2;
        break;
    default:
        $empPriv = 2;
        break;
}
$updateEmpQuery = "UPDATE `employee`
SET
`Name` = '$empName',
`Password` = '$passEncrypt',
`Position` = '$empPositionInput',
`Location` = '$empLocationInput',
`Locker` = '$empLocker',
`PhoneNumber` = '$empPhoneNumber',
`Grade` = '$empGrade',
`Privilege` = '$empPriv'
WHERE `EmployeeID` = '$empID'";

mysqli_query($conn,$updateEmpQuery);
mysqli_close($conn);
