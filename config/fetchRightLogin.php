<?php
session_start();

include 'connectDB.php';
$name = $_POST['loginName'];
$pass = $_POST['loginPass'];
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

$passEncrypt = openssl_encrypt($pass,$encMethod,$encKey,0,$iniVector);
$fetchQuery = "SELECT * FROM `employee` WHERE `EmployeeID` = '$name' AND `Password` = '$passEncrypt'";
$fetchQueryResult = mysqli_query($conn, $fetchQuery);
if(mysqli_num_rows($fetchQueryResult) >0) {
    echo "0";
}
else {
    echo "1";
}







?>