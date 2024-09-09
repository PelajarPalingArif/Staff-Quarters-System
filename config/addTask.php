<?php
include "connectDB.php";
$description = isset($_POST["Description"]) ? $_POST["Description"] : "";
$taskType = isset($_POST["TaskType"]) ? $_POST["TaskType"] : "";
if($taskType != ""){
    $addTaskQuery = "INSERT INTO 
    `task` (`Description`,`TaskTypeID`,`Status`)
    VALUES('$description','$taskType',1)";
    mysqli_query($conn,$addTaskQuery);
}
mysqli_close($conn);


