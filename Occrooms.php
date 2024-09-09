<?php
session_start();
if (!isset($_SESSION["empID"])) {
    header("Location:index.php");
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link rel="icon" href="Staff_Icon.png" type="image/x-icon">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/customArif.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/sidebars.css" rel="stylesheet">


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jQuery/jQuery.js"></script>

    <script src="DataTables/jquery.dataTables.min.js"></script>
    <script src="DataTables/dataTables.bootstrap5.min.js"></script>

    <link href="DataTables/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script>
        var currRoomID;

        function setCurrRoom(value) {
            currRoomID = value;
        }

        (function() {
            'use strict'
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })()


        function isBlank(val, id) {
            let objID = document.getElementById(id);
            if (val == "") {
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                return true;
            } else {
                objID.classList.remove("is-invalid");
                objID.classList.add("is-valid");
                return false;
            }
        }

        function addOccModal(roomID) {
            setCurrRoom(roomID);
            let myModal = new bootstrap.Modal(document.getElementById('addEmpToRoom'), {
                keyboard: false
            })
            myModal.show();
            let sample = document.getElementById('sampleText');
        }
    </script>

    <style>
        tfoot th input {
            background-color: lightgreen;
            border: 2px solid rgb(26, 158, 26);
            box-sizing: border-box;
            outline: none;
        }

        tfoot th input::placeholder {
            color: black;
        }

        tfoot th input:focus::placeholder {
            color: transparent;
        }

        tfoot th input:hover,
        tfoot th input:focus {
            border: 2px solid darkgreen;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_GET['unitID'])) $unitID = $_GET['unitID'];
    ?>


    <main>
        <div class="modal fade" id="addEmpToRoom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEmpToRoomLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addEmpToRoomLabel">Add Occupant</h1>
                        <h1 id="sampleText"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label for="inputEmpId" class="form-label">Employee ID</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="inputEmpId" id="inputEmpId" onkeyup="verifyValidId(this.value,0)" required>
                                <div id="empIdValid" class="valid-feedback">

                                </div>
                                <div id="empIdInvalid" class="invalid-feedback">
                                    Please enter the Employee ID
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button onclick="verifyValidId(document.getElementById('inputEmpId').value,1)" type="button" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <form id="addRoomForm" action="config/addRoom.php" method="post">
        </form>
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
                    <a href="units.php" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
                    <a href="task.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
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

        <!-- MAIN CONTENT -->
        <script>
            function verifyValidId(val, ori) {
                let verifyIdReq = new XMLHttpRequest();
                verifyIdReq.open("POST", "config/validEmpID.php", true);
                verifyIdReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                verifyIdReq.send("empID=" + val);
                verifyIdReq.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        let empIdInput = document.getElementById("inputEmpId");
                        if (this.responseText == 0) {
                            document.getElementById("empIdInvalid").innerHTML = `Employee ID does not exist`;
                            empIdInput.classList.remove("is-valid");
                            empIdInput.classList.add("is-invalid");

                        } else if (this.responseText == 1) {
                            document.getElementById("empIdValid").innerHTML = `Employee ID Exist`;
                            empIdInput.classList.add("is-valid");
                            empIdInput.classList.remove("is-invalid");
                            if (ori == 1) sendAdd(val);


                        } else {
                            document.getElementById("empIdInvalid").innerHTML = `Please Enter an Employee's ID`;

                            empIdInput.classList.remove("is-valid");
                            empIdInput.classList.add("is-invalid");
                        }
                    }
                }
            }
            function dumpRoom(roomID) {
            console.log(roomID);
            let remUnitReq = new XMLHttpRequest();
            remUnitReq.open("GET", "config/remRooms.php?roomID=" + roomID, true);
            remUnitReq.onreadystatechange = function() {
                if (remUnitReq.readyState == 4 && remUnitReq.status == 200) {
                    location.reload();
                }
            }
            remUnitReq.send();

        }
            function remEmpFromRoom(roomID) {
                setCurrRoom(roomID);
                let remReq = new XMLHttpRequest();
                remReq.open("POST", "config/removeEmpFromRoom.php", true);
                remReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                remReq.onreadystatechange = function() {
                    if (remReq.readyState == 4 && remReq.status == 200) {
                        location.reload();
                    }
                }
                remReq.send("roomID=" + currRoomID);
            }

            function sendAdd(empID) {
                let addOccReq = new XMLHttpRequest();
                addOccReq.open("POST", "config/addEmpToRoom.php", true);
                addOccReq.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                addOccReq.onreadystatechange = function() {
                    if (addOccReq.readyState == 4 && addOccReq.status == 200) {
                        location.reload();
                    }
                }
                addOccReq.send("empID=" + empID + "&roomID=" + currRoomID);
            }

            $(document).ready(function() {
                $('#buildTable').DataTable({
                    "language": {
                        "paginate": {
                            "previous": "<span style=\"color:black\">Previous</span>",
                            "next": "<span style=\"color:black\">Next</span>"
                        },
                        "emptyTable": "No rooms in this unit"


                    },
                });
            });
        </script>
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                <?php

                if (!isset($unitID)) {
                    echo "All's Rooms";
                } else echo "$unitID's Rooms";
                ?>
            </div>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>

            <div class="row mt-4 pt-4 pb-4" style="background-color:rgb(0, 48, 0);color:white">
                <table id="buildTable" class="table table-success  table-hover border border-success table-bordered mt-4">
                    <thead class="table-dark">
                        <th scope="col" style="text-align:center;">#</th>
                        <th scope="col">Employee ID</th>
                        <th scope="col">Employee Name</th>
                        <th scope="col">Status</th>
                        <?php

                        ?>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        include("config/connectDB.php");
                        if (!$conn) {
                            die("Connection Failed: " . mysqli_connect_error());
                        }
                        $num = 1;

                        $listUnitsQuery =  "";
                        if (!isset($unitID)) {

                            $listUnitsQuery =  "SELECT r.`UnitID`,r.`RoomID`,r.`Status`,COALESCE(e.`EmployeeID`, 'None') as 'EmployeeID',COALESCE(e.`Name`,'None') as 'Name' FROM `rooms` r left JOIN `employee` e on e.`EmployeeID` = r.`EmployeeID`;";
                        } else $listUnitsQuery =  "SELECT r.`UnitID`,r.`RoomID`,r.`Status`,COALESCE(e.`EmployeeID`,'None') as 'EmployeeID',COALESCE(e.`Name`,'None') as 'Name' FROM `rooms` r left JOIN `employee` e on e.`EmployeeID` = r.`EmployeeID` WHERE `unitID`= $unitID";

                        $listBuildingResult = mysqli_query($conn, $listUnitsQuery);
                        if ($listUnitsQuery) {

                            while ($row = mysqli_fetch_assoc($listBuildingResult)) {
                                $rID = $row['RoomID'];
                                $stat = ($row['Status'] == 0) ? "Occupied" : "Vacant";
                                $eID = $row['EmployeeID'];
                                $eName = strtolower(strtok($row["Name"], " "));



                                echo "<tr>";
                                echo "<td scope=\"row\" style=\"font-weight:bold;text-align:center;\">$num</td>";
                                // echo "<td style=\"font-weight:500;\">$aid</td>";
                                echo "<td style=\"font-weight:500;\">$eID</td>";
                                echo "<td class=\"text-capitalize\"style=\"font-weight:500;\">$eName</td>";
                                echo "<td style=\"font-weight:500;\">$stat</td>";
                                //! ADD : ACTION BUTTON
                                echo "<td><div class=\"actionRow\"><button onclick='window.location.href=`rooms_applience.php?roomID=$rID`'class=\"appButton\"><img style=\"transform:scale(1.8);\"src=\"icon/appliances.png\"></button><button onclick=\"dumpRoom($rID)\"class=\"dumpButton\"><img src=\"icon/trash.svg\"></button>";
                                if ($row['Status'] == 0) {
                                    echo "<button onclick=\"remEmpFromRoom($rID);\"class=\"viewButton\"><img src=\"icon/dash-circle.svg\"></button></div></td>";
                                } else echo "<button onclick=\"addOccModal($rID);\"class=\"editButton\"><img src=\"icon/plus-circle.svg\"></button></div></td>";
                                echo "</tr>";
                                $num++;
                            }
                        } else {
                            echo "Error :" . mysqli_error($conn);
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col pb-3 pt-2" style="width:100%;background-color:rgb(0, 48, 0);"><button onclick="addRoom();" class="float-end" style="width:6%;height:100%;" id="addButton"><img style="transform:scale(1.2);width:33px;height:33px;" src="icon/sleep-add.png"></button></div>
            </div>
            <script>
                function addRoom() {
                    let addRoomButton = document.getElementById('addButton');
                    addRoomButton.disabled = true;
                    let addRoomReq = new XMLHttpRequest();
                    let url = 'config/addRoom.php?unitID=' + <?php echo $unitID ?>;
                    addRoomReq.open('GET', url, true);
                    addRoomReq.onreadystatechange = function() {
                        if (addRoomReq.readyState == 4 && addRoomReq.status == 200) {
                            addRoomButton.disabled = false;
                            console.log(addRoomReq.responseText);
                            location.reload();
                        }
                    }
                    addRoomReq.send();
                }
            </script>

        </div>
    </main>
</body>

</html>