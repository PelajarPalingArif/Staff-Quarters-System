<?php
include 'connectDB.php';
$employeeID = $_GET['empID'];

$getEmpDataQuery = "SELECT * FROM `employee` WHERE `EmployeeID` = $employeeID";
$getEmpDataQueryResult = mysqli_query($conn,$getEmpDataQuery);
$row = mysqli_fetch_assoc($getEmpDataQueryResult);

$encryptedPass = $row['Password'];
$fetchEnc = "SELECT * FROM `encryption` WHERE `EncryptID` = 1";
$fetchEncResult = mysqli_query($conn, $fetchEnc);
$rowEncryption = mysqli_fetch_array($fetchEncResult);

$encMethod = $rowEncryption["1"];
$iniVector = $rowEncryption["2"];
$encKey = $rowEncryption["3"];

$locker = $row['Locker'];

if(is_null($row['Locker']) || empty($row['Locker'])){
    $locker = "None";
}
$empDataArray = array('Name' => $row['Name'],'Password' =>openssl_decrypt($encryptedPass,$encMethod,$encKey,0,$iniVector),
                    'Position' =>$row['Position'],'Location' =>$row['Location'],
                    'Grade' =>$row['Grade'],'ContactNumber' =>$row['PhoneNumber'], 'Locker' => $locker);
echo json_encode($empDataArray);
mysqli_close($conn);






