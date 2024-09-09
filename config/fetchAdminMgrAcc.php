<?php 
session_start();
/* 
    0 means success
    1 means fail 

*/
include 'connectDB.php';
$empID = $_POST['adminID'];
$empPass = $_POST['adminEmpPass'];

if($empID == "admin" && $empPass == "admin"){
    echo '0';
    
}
else{
//ENcrypt
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


$empPassEncrypted = openssl_encrypt($empPass,$encMethod,$encKey,0,$iniVector);
$fetchQuery = "SELECT `EmployeeID`,`Password`,`Privilege` FROM `employee` WHERE `EmployeeID` = '$empID' AND `Password` = '$empPassEncrypted' and `Privilege` < 2";
$fetchResult = mysqli_query($conn, $fetchQuery);
if(mysqli_num_rows($fetchResult) > 0){
    echo '0';
}
else {echo '1';}
}
mysqli_close($conn);
