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
    <title>Room's Applience</title>
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
        function changeDesc(val) {
            let changeDescReq = new XMLHttpRequest();
            changeDescReq.open("GET","config/changeDesc.php?appID=" + val,true);
            changeDescReq.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let temp = this.responseText;
                    res = temp.replace(/^\s+/, '');
                    document.getElementById("inputAppDesc").innerHTML = res;
                }
            }
            changeDescReq.send();

        }
        function changeStat(r_appID, val) {
            console.log("RUN : " + r_appID + "," + val);
            let changeStatReq = new XMLHttpRequest();
            changeStatReq.open("GET", "config/changeAppStat.php?room_appID=" + r_appID + "&val=" + val, true);
            changeStatReq.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                }
            }
            changeStatReq.send();
        }

        function InsertApp(room) {
            let insertButton = document.getElementById('insertAppButton');
            insertButton.disabled = true;
            let insertAppReq = new XMLHttpRequest();
            let insertAppId = document.getElementById('idappName').value;
            insertAppReq.open('GET', 'config/insertApp.php?room=' + room + "&appID=" + insertAppId, true);
            insertAppReq.onreadystatechange = function() {
                if (insertAppReq.readyState == 4 && insertAppReq.status == 200) {
                    insertButton.disabled = false;
                    window.location.reload();
                }
            }
            insertAppReq.send();
        }
        $(document).ready(function() {
            $('#buildTable').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<span style=\"color:black\">Previous</span>",
                        "next": "<span style=\"color:black\">Next</span>"
                    }
                }
            });
        });

        function removeRoomApp(val) {
            let remRoomAppReq = new XMLHttpRequest();
            remRoomAppReq.open('GET', 'config/remAppFromRoom.php?roomAppID=' + val, true);
            remRoomAppReq.onreadystatechange = function() {
                if (remRoomAppReq.readyState == 4 && remRoomAppReq.status == 200) {
                    window.location.reload();
                }
            }
            remRoomAppReq.send();

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
    if (isset($_GET['roomID'])) $roomID = $_GET['roomID'];

    ?>
    <main>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Appliances</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="col-md-12">
                            <label for="appName" class="form-label">Applience</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/appliances.png" alt="buildingname" width="26" height="26" style="transform:scale(2.0);"></span>
                                <select class="form-select" aria-label="Default select example" name="appName" id="idappName" onchange="changeDesc(this.value)" required>
                                    <?php
                                    include "config/connectDB.php";
                                    $getListQuery = "SELECT * FROM `applience`";
                                    $result = mysqli_query($conn, $getListQuery);
                                    $listOfApplience = array();
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $listOfApplience[] = array($row['ApplienceID'], $row['ApplienceName'], $row['Description']);
                                    }
                                    $count = 0;
                                    $firstValueAppliance = "";
                                    foreach ($listOfApplience as $val) {
                                        if ($count == 0) {
                                            echo "<option selected value=\"$val[0]\">$val[1]</option>";
                                            $firstValueAppliance = $val[2];
                                            $count++;
                                        } else echo "<option value=\"$val[0]\">$val[1]</option>";
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </select>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="descinput" class="form-label">Description</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/file-earmark-text-fill.svg" alt="AppliancesDesc" width="26" hei ght="26"></span>
                                <textarea type="text" class="form-control" name="inputAppDesc" id="inputAppDesc" disabled><?php echo $firstValueAppliance ?></textarea>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button id="insertAppButton" type="button" class="btn btn-success" onclick="InsertApp(<?php echo $roomID ?>)">Insert</button>
                    </div>
                </div>
            </div>
        </div>

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
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                Room ID : <?php echo $roomID ?> Appliances
            </div>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>

            <div class="row mt-4 pt-4 pb-4" style="background-color:rgb(0, 48, 0);color:white">
                <table id="buildTable" class="table table-success  table-hover border border-success table-bordered mt-4">
                    <thead class="table-dark">
                        <th scope="col" style="text-align:center;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        include("config/connectDB.php");
                        if (!$conn) {
                            die("Connection Failed: " . mysqli_connect_error());
                        }
                        $num = 1;
                        $listRoomsAppQuery =  "SELECT ra.`Rooms_ApplienceID`,ra.`RoomID`,ra.`ApplienceID`,ra.`Status`,a.`ApplienceName` FROM `rooms_applience` ra LEFT JOIN `applience` a ON a.`ApplienceID` = ra.`ApplienceID` WHERE ra.`RoomID` = '$roomID';";
                        $listRoomsAppResult = mysqli_query($conn, $listRoomsAppQuery);
                        if ($listRoomsAppResult) {
                            while ($row = mysqli_fetch_assoc($listRoomsAppResult)) {
                                $rAID = $row['Rooms_ApplienceID'];
                                $an = $row['ApplienceName'];
                                $trueS = $row['Status'];
                                $trueS = min($trueS, 2);
                                $s = ($row['Status'] == 0) ? "Fine " : (($row['Status'] == 1) ? "Broke" : "Missing");
                                $statArr = array("Fine", "Broke", "Missing");
                                $unsetVal = $statArr[$trueS];
                                unset($statArr[$trueS]);
                                echo "<tr>";
                                echo "<td scope=\"row\" style=\"font-weight:bold;text-align:center;\">$num</td>";
                                echo "<td style=\"font-weight:500;\">$an</td>";
                                echo "
                                <td style=\"font-weight:500;\">
                                <select style=\"border:2px solid black\" class=\"form-select\" aria-label=\"Default select example\" name=\"changeAppStat\" id=\"changeAppStatID\" onchange=\"changeStat($rAID,this.value)\">
                                <optgroup>
                                <option selected value=$trueS>$s</option>";
                                foreach ($statArr as $i => $val) {
                                    echo "<option value=$i>$val</option>";
                                }
                                echo "</optgroup>";
                                echo "</select>
                                </td>";
                                echo "<td><div class=\"actionRow\"><button onclick=\"removeRoomApp($rAID)\"class=\"dumpButton\"><img src=\"icon/trash.svg\"></button></div></td>";
                                echo "</tr>";
                                $num++;
                            }
                        } else {
                            echo "Error :" . mysqli_error($conn);
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>

                </table>
            </div>
            <div class="row">
                <div class="col pb-3 pt-2" style="width:100%;background-color:rgb(0, 48, 0);"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="float-end" style="width:6%;height:100%;" id="addButton"><img style="transform:scale(1.2);width:33px;height:33px;" src="icon/appliances-add.png"></button>
                </div>
            </div>

        </div>
    </main>
</body>

</html>