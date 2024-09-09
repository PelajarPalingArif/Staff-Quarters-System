<?php
session_start();
include("connectDB.php");
$id = $_POST['UserName'];
$pass = $_POST['Password'];

$fetchEncQuery = "SELECT * FROM `encryption` WHERE `EncryptID` = 1";
$fetchEncResult = mysqli_query($conn, $fetchEncQuery);

$row = mysqli_fetch_array($fetchEncResult);
/* 

ENCRYPTION SHOULD BE : 

Cipher Method = aes-256-cbc-hmac-sha256
Initialize Vector = a1av87h1jd83ja74
Encryption Key = BERJAYAHILLS@ARIFRAIHAN

*/

$encMethod = $row["1"];
$iniVector = $row["2"];
$encKey = $row["3"];

$passEncrypt = openssl_encrypt($pass, $encMethod, $encKey, 0, $iniVector);
$fetchQuery = "SELECT * FROM `employee` WHERE `EmployeeID` = '$id' AND `Password` = '$passEncrypt'";
$fetchQueryResult = mysqli_query($conn, $fetchQuery);
$row = mysqli_fetch_array($fetchQueryResult, MYSQLI_ASSOC);
if (mysqli_num_rows($fetchQueryResult) > 0) {

    $_SESSION["empID"] =  $row["EmployeeID"];
    $_SESSION["empFirstName"] = strtolower(strtok($row["Name"], " "));
    $_SESSION["empImageURL"] = $row["ImageLink"];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
</body>

</html>