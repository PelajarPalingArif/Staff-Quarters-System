<?php 

/*
1 means that employee ID already exist
0 means otherwise
2 means the field is blank
*/
include("connectDB.php");
$checkID = $_POST['empID'];
if($checkID == ""){
    echo '2';
    exit();
}
$checkQuery = "SELECT * FROM `employee` WHERE `EmployeeID` = '$checkID'";
$checkResult = mysqli_query($conn, $checkQuery);
if(mysqli_num_rows($checkResult) > 0){
    echo "1";
} 
else echo "0";

mysqli_close($conn);





?>