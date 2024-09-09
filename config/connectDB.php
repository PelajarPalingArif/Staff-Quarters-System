<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$db = "staffquarterssystem"; 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
 die(); // terminate conn & display the error message
}
// echo "Connected Successfully";




