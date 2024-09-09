<?php
session_start();
if (!isset($_SESSION["empID"])) {
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <link rel="icon" href="Staff_Icon.png" type="image/x-icon">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/customArif.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/sidebars.css" rel="stylesheet">


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jQuery/jQuery.js"></script>

    <style>
        /* Set a fixed height for the cards */
        .card {
            max-height: 650px;
            outline: 2px solid black;
        }

        .card-body {
            height: 400px;
            overflow-y: auto;
        }

        .card-header {
            font-weight: bold;
            font-size: 30px;
            color: black;
            font-family: 'Courier New', Courier, monospace;
        }

        .delete-button {
            border-radius: 5px;
            background-color: red;
            border: none;
        }

        .delete-button:hover {
            background-color: darkred;
            outline: 0.5px solid black;
        }

        .msg {
            font-size: 12px;
            font-weight: 300;
        }

        .good {
            color: lightgreen;
        }

        .error {
            color: red;
        }

        .good-input,
        .good-input-focus {
            color: black;
            /* Dark text color */
            background-color: white;
            /* Light background color */
            border-color: #28a745 !important;
            /* Green border color */
            outline: 1px solid #28a745 !important;
            /* Green outline */
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25) !important;
            /* Green box shadow */
        }

        .error-input,
        .error-input-focus {
            color: black;
            /* Dark red text color */
            background-color: white;
            /* Light red background color */
            border-color: #f5c6cb !important;
            /* Red border color */
            outline: 1px solid red !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
            /* Red box shadow */
        }
    </style>
    <?php
    include 'config/checkTaskStat.php';
    ?>
    <script>
        function isValid(inputID, inputValue){
            let errSec = document.getElementById(inputID + "Error");

            if(inputValue.trim().length == 0){
                document.getElementById(inputID).classList.remove("good-input");
                document.getElementById(inputID).classList.add("error-input");
                errSec.classList.remove("good");
                errSec.classList.add("error");
                errSec.innerHTML = "Invalid Input";
            }
            else {
                document.getElementById(inputID).classList.remove("error-input");
                document.getElementById(inputID).classList.add("good-input");
                errSec.classList.remove("error");
                errSec.classList.add("good");
                errSec.innerHTML = "Looks Good";
            }

        }
        function changeStatus(taskID, status) {
            // console.log(taskID + "," + status);
            let changeStatusReq = new XMLHttpRequest();
            let postData = new FormData();
            postData.append("taskID",taskID);
            postData.append("status",status);
            changeStatusReq.open("POST","config/changeTaskStatus.php",true);
            changeStatusReq.onreadystatechange = () => {
                console.log(changeStatusReq.response.trim());
            }
            changeStatusReq.send(postData);

        }

        function delTask(taskID, taskType) {
            console.log(taskID + "," + taskType)
            let delTaskReq = new XMLHttpRequest();
            delTaskReq.open("GET","config/delTask.php?taskID=" + taskID,true);
            delTaskReq.onreadystatechange = () => {
                if(delTaskReq.status == 200 && delTaskReq.readyState == 4){
                    setTimeout(getTask(taskType),400);
                }
            } 
            delTaskReq.send();

        }

        function getTask(TaskType) {
            let getTaskReq = new XMLHttpRequest();
            getTaskReq.open("GET", "config/getTask.php?type=" + TaskType, true);
            let typeBody = "";
            if (TaskType == 1) {
                typeBody = document.getElementById("daily-body");
            } else if (TaskType == 2) {
                typeBody = document.getElementById("weekly-body");
            } else {
                typeBody = document.getElementById("monthly-body");
            }
            typeBody.innerHTML = "";
            getTaskReq.onreadystatechange = () => {

                if (getTaskReq.readyState == 4 && getTaskReq.status == 200) {
                    let taskArray = JSON.parse(getTaskReq.responseText);

                    let i = 0;
                    for (; i < taskArray.length; i++) {
                        let task = taskArray[i];
                        let addContent = "";
                        if (task.Status == 0) {
                            // console.log(task.Status);
                            addContent = `
                            <div class="form-check container">

                                <div class="row">
                                    <div class="col-10">
                                        <input onchange="changeStatus('` + task.TaskID + `',this.checked)"class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                                        <label class="form-check-label" for="flexCheckDefault" >
                                            ` + task.Description + `
                                        </label>
                                    </div>
                                    <div class="col-2"><button onclick="delTask('` + task.TaskID + `',` + TaskType + `)"class="delete-button"><img src="icon/trash.svg"></button> </div>    

                                </div>
                            </div>`;
                        } else {
                            // console.log(task.Status);
                            addContent = `
                            <div class="form-check container">

                                <div class="row">
                                    <div class="col-10">
                                        <input onchange="changeStatus('` + task.TaskID + `',this.checked)"class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            ` + task.Description + `
                                        </label>
                                    </div>
                                    <div class="col-2"><button onclick="delTask('` + task.TaskID + `',` + TaskType + `)"class="delete-button"><img src="icon/trash.svg"></button> </div>    

                                </div>
                            </div>`;

                        }
                        typeBody.innerHTML += addContent;

                    }

                }
            }
            getTaskReq.send();

        }

        function addTask(inputID, taskType) {

            // console.log(inputID,taskType);
            let inputObj = document.getElementById(inputID);
            let inputValue = inputObj.value;
            let errSec = document.getElementById(inputID + "Error");
            if (typeof inputValue === "string" && inputValue.trim().length === 0) {
                inputObj.classList.remove("good-input");
                inputObj.classList.add("error-input");
                errSec.classList.remove("good");
                errSec.classList.add("error");
                errSec.innerHTML = "Invalid Input";
            } else {
                inputObj.classList.remove("error-input");
                inputObj.classList.add("good-input");
                errSec.classList.remove("error");
                errSec.classList.add("good");
                errSec.innerHTML = "Looks Good";

                let formData = new FormData();
                formData.append("Description", inputValue);
                formData.append("TaskType", taskType);
                let addTaskReq = new XMLHttpRequest();
                addTaskReq.open("POST", "config/addTask.php", true);
                addTaskReq.onreadystatechange = function() {
                    if (addTaskReq.readyState == 4 && addTaskReq.status == 200) {
                        setTimeout(() => {
                            getTask(taskType);
                            inputObj.classList.remove("good-input");
                            inputObj.value = "";
                            errSec.innerHTML = "";
                            console.log("Ran")

                        }, 300);

                    }
                }
                addTaskReq.send(formData)



            }

        }
        window.onload = function() {
            getTask(1);
            getTask(2);
            getTask(3);
        }
    </script>
</head>


<body>

    <main>



        <div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 280px;background-color:#013801;">
            <div class="container">
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <div class="profileCircle">
                            <a href="dashboard.php"><img src=<?php echo "image\\employee\\" . $_SESSION["empImageURL"]; ?> class="img-fluid img-thumbnail"></a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center col dropdown pt-3 pb-3">
                        <a href="#" style="width:100%" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <strong class="me-3 text-capitalize"><?php echo $_SESSION["empFirstName"]; ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="config\actionSignout.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto d-grid gap-2">
                <li class="nav-item">
                    <a href="dashboard.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
                        <span><img src="./icon/house.svg" alt="House" width="33" height="33"></span>
                        <p class="ms-3">
                            Home
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="building.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
                        <span><img src="./icon/buildings.svg" alt="building" width="33" height="33"></span>
                        <p class="ms-3">
                            Building
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="employee.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
                        <span><img src="./icon/people.svg" alt="people" width="33" height="33"></span>
                        <p class="ms-3">
                            Employee
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="units.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
                        <span><img src="./icon/door-open-fill.svg" alt="units" width="33" height="33"></span>
                        <p class="ms-3">
                            Units
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="appliances.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
                        <span><img style="transform:scale(2);" src="./icon/appliances.png" alt="plug" width="33" height="33"></span>
                        <p class="ms-3">
                            Appliances
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
                        <span><img src="./icon/list-task.svg" alt="plug" width="33" height="33"></span>
                        <p class="ms-3">
                            Task
                        </p>
                    </a>
                </li>
            </ul>
            <hr>
            <a href="https://github.com/PelajarPalingLahanat/PelajarPalingLahanat" target="_blank" style="text-decoration:none;">
                <h6 class="text-white" style="font-weight:200;font-size:small;">ArifRaihan 2023&copy;</h6>
            </a>
        </div>
        <div class="b-example-divider"></div>
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                Tasks
            </div>
            <div class="row">
                <div class="col-sm-12 mb-4" style="background-color:black;height:5px;"></div>
            </div>
            <div class="row">
                <!-- Daily Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary ">
                            Daily
                        </div>
                        <div class="card-body" id="daily-body">


                        </div>
                        <div class="card-footer container">
                            <div class="mb-1 row">
                                <div class="col-10">
                                    <input type="text" onkeyup="isValid('addDaily',this.value)"class="form-control" id="addDaily">
                                </div>
                                <div onclick="addTask('addDaily',1)" class="col-2" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;"><button style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;" class="btn btn-success"><img width=22 height=22 src="icon/plus.svg"></button></div>
                            </div>
                            <div class="row">
                                <div class="col-10 msg" id="addDailyError"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Weekly Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-success ">
                            Weekly
                        </div>
                        <div class="card-body" id="weekly-body">

                        </div>
                        <div class="card-footer container">
                            <div class="mb-1 row">
                                <div class="col-10"><input onkeyup="isValid('addWeekly',this.value)" type="text" class="form-control" id="addWeekly"></div>
                                <div onclick="addTask('addWeekly',2)" class="col-2" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;"><button style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;" class="btn btn-success"><img width=22 height=22 src="icon/plus.svg"></button></div>
                            </div>
                            <div class="row">
                                <div class="col-10 msg" id="addWeeklyError"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Monthly Card -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning ">
                            Monthly
                        </div>
                        <div class="card-body" id="monthly-body">

                        </div>
                        <div class="card-footer container">
                            <div class="mb-1 row">
                                <div class="col-10"><input onkeyup="isValid('addMonthly',this.value)" type="text" class="form-control" id="addMonthly"></div>
                                <div onclick="addTask('addMonthly',3)" class="col-2" style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;"><button style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;" class="btn btn-success"><img width=22 height=22 src="icon/plus.svg"></button></div>
                            </div>
                            <div class="row">
                                <div class="col-10 msg" id="addMonthlyError"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </main>
</body>

</html>