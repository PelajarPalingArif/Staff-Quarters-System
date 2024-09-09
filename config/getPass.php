<?php
include 'connectDB.php';
$employeeID = $_GET['empID'];
$getPassQuery = "SELECT `password` FROM `employee` WHERE `EmployeeID` = '$employeeID'";
$result = mysqli_query($conn,$getPassQuery);
$row = mysqli_fetch_assoc($result);
$encryptedPass = $row['password'];
// echo $encryptedPass;
$fetchEnc = "SELECT * FROM `encryption` WHERE `EncryptID` = 1";
$fetchEncResult = mysqli_query($conn, $fetchEnc);
$rowEncryption = mysqli_fetch_array($fetchEncResult);

$encMethod = $rowEncryption["1"];
$iniVector = $rowEncryption["2"];
$encKey = $rowEncryption["3"];

$decryptPass = openssl_decrypt($encryptedPass,$encMethod,$encKey,0,$iniVector);
echo $decryptPass;


?>