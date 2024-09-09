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
    <title>Building</title>
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
        var currSelectBuildingID;
        (function() {
            'use strict'
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })()

        function SetEditBuilding(buildingID, buildingName) {
            currSelectBuildingID = buildingID;
            // console.log(buildingID,buildingName);
            document.getElementById("inputChangeBuildName").value = buildingName;
        }

        function removeBuilding(buildingID) {
            let remBuildingReq = new XMLHttpRequest();
            remBuildingReq.open("GET", "config/remBuilding.php?buildingID=" + buildingID, true);
            remBuildingReq.onreadystatechange = function() {
                if (remBuildingReq.status == 200 && remBuildingReq.readyState == 4) {
                    location.reload();
                }
            }
            remBuildingReq.send();

        }

        function addBuilding() {
            let addButton = document.getElementById('addBuildingButton');
            let inputBuildName = document.getElementById("inputBuildName").value;
            let objID = document.getElementById('inputBuildName');
            if (inputBuildName == "") {
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                return;
            } else {
                addButton.disabled = true;
                document.getElementById('addBuilding').submit();
                setTimeout(function() {
                    location.reload();
                }, 600);
            }
        }

        function goToUnit(buildingID, buildingName) {
            window.location.href = "units.php?buildID=" + buildingID + "&buildName=" + buildingName;
        }

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

        function submitChange() {
            let buildNameChange = document.getElementById("inputChangeBuildName").value;
            document.getElementById("changeBuildingButton").disabled = true;
            if (!(buildNameChange == "")) {
                let changeBuildReq = new XMLHttpRequest();
                changeBuildReq.open("GET", "config/changeBuilding.php?buildID=" + currSelectBuildingID + "&buildName=" + buildNameChange, true);
                changeBuildReq.onreadystatechange = () => {
                    if (changeBuildReq.status == 200 && changeBuildReq.readyState == 4) {
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    }
                }
                changeBuildReq.send();
            }
            document.getElementById("changeBuildingButton").disabled = false;



        }
    </script>

    <style>    </style>
</head>

<body>
    <div class="modal fade" id="ExportBuilding" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ExportBuildingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ExportBuildingLabel">Export Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container-fluid">
                    <form action="config/exportBuilding.php" method="get">
                        <div class="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="NameCheckBox" name="NameCheckBox" checked>
                                <label class="form-check-label" for="NameCheckBox">
                                    Name
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="UnitsCheckBox" name="UnitsCheckBox" checked>
                                <label class="form-check-label" for="UnitsCheckBox">
                                    Unit
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="RoomsCheckBox" name="RoomsCheckBox" checked>
                                <label class="form-check-label" for="RoomsCheckBox">
                                    Rooms
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="AvailableCheckBox" name="AvailableCheckBox" checked>
                                <label class="form-check-label" for="AvailableCheckBox">
                                    Available Rooms
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="OccupiedCheckBox" name="OccupiedCheckBox" checked>
                                <label class="form-check-label" for="OccupiedCheckBox">
                                    OccupiedCheckBox
                                </label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col">
                                Export To :
                                <select name="exportTo" id="exportTo">
                                    <option value="0">PDF</option>
                                    <option value="1">Text</option>
                                    <option value="2">CSV</option>
                                    <option value="3">Excel</option>
                                </select>
                                <div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Building</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form target="dummyframe" id="addBuilding" action="config/AddBuilding.php" class="row g-3 needs-validation" method="post" novalidate>
                        <div class="col-md-12">
                            <label for="nameinput" class="form-label">Building's Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/building.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="inputBuildName" id="inputBuildName" onkeyup="isBlank(this.value,'inputBuildName')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Building's Name
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="addBuildingButton" type="button" class="float-end btn btn-success" onclick="addBuilding();">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changeBackdropLabel">Edit Building</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form target="dummyframe" id="addBuilding" action="config/AddBuilding.php" class="row g-3 needs-validation" method="post" novalidate>
                        <div class="col-md-12">
                            <label for="nameinput" class="form-label">Building's Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/building.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="inputChangeBuildName" id="inputChangeBuildName" onkeyup="isBlank(this.value,'inputChangeBuildName')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Building's Name
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="changeBuildingButton" type="button" class="btn btn-success" onclick="submitChange()">Submit</button>
                </div>
            </div>
        </div>
    </div>

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
                    <a href="#" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
        </script>
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                List of Buildings
            </div>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 pt-3 " style="flex-wrap:wrap;">
                    <button data-bs-toggle="modal" data-bs-target="#ExportBuilding" class="export-button"><img src="icon/file-earmark-arrow-down-fill.svg" alt=""><span class="button-text">Export</span></button>
                </div>
            </div>

            <div class="row mt-4 pt-4 pb-4" style="background-color:rgb(0, 48, 0);color:white">
                <table id="buildTable" class="table table-success  table-hover border border-success table-bordered mt-4">
                    <thead class="table-dark">
                        <th scope="col" style="text-align:center;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Units</th>
                        <th scope="col">Rooms</th>
                        <th scope="col">Available Rooms</th>
                        <th scope="col">Occupied Rooms</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        include("config/connectDB.php");
                        if (!$conn) {
                            die("Connection Failed: " . mysqli_connect_error());
                        }
                        $num = 1;
                        $listBuildingArr = array();
                        $listBuildingQuery =  "SELECT b.BuildingBlockID, b.BuildingName,COUNT(DISTINCT u.UnitID) AS TotalUnits, COUNT(r.RoomID) AS RoomCount, COUNT(CASE WHEN r.Status = 0 THEN 1 ELSE NULL END) AS OccRoom, COUNT(CASE WHEN r.Status = 1 THEN 0 ELSE NULL END) AS VacRoom
                        FROM BuildingBlock b
                        LEFT JOIN Unit u ON b.BuildingBlockID = u.BuildingBlockID
                        LEFT JOIN Rooms r ON u.UnitID = r.UnitID
                        GROUP BY b.BuildingBlockID;
                        ";
                        $listBuildingResult = mysqli_query($conn, $listBuildingQuery);
                        if ($listBuildingQuery) {
                            while ($row = mysqli_fetch_assoc($listBuildingResult)) {
                                $bId = $row['BuildingBlockID'];
                                $bn = $row['BuildingName'];
                                $tu = $row['TotalUnits'];
                                $rc = $row['RoomCount'];
                                $or = $row['OccRoom'];
                                $vr = $row['VacRoom'];
                                echo "<tr>";
                                echo "<td scope=\"row\" style=\"font-weight:bold;text-align:center;\">$num</td>";
                                echo "<td style=\"font-weight:500;\">$bn</td>";
                                echo "<td style=\"font-weight:500;\">$tu</td>";
                                echo "<td style=\"font-weight:500;\">$rc</td>";
                                echo "<td style=\"font-weight:500;\">$vr</td>";
                                echo "<td style=\"font-weight:500;\">$or</td>";
                                //! ADD : ACTION BUTTON
                                echo "<td><div class=\"actionRow\"><button onclick=\"window.location.href = `floorPlan.php?buildID=$bId&buildName=$bn`\"class=\"floorButton firstButton\"><img  src=\"icon/floor-plan-nobg.png\"></button><button onclick=\"goToUnit('$bId','$bn')\"class=\"viewButton \"><img src=\"icon/eye.svg\"></button><button data-bs-toggle=\"modal\" data-bs-target=\"#changeBackdrop\" onclick=\"SetEditBuilding('$bId','$bn')\" class=\"editButton\"><img src=\"icon/pencil-square.svg\"></button><button onclick=\"removeBuilding($bId)\" class=\"dumpButton\"><img src=\"icon/trash.svg\"></button></div></td>";
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
                <div class="col pb-3 pt-2" style="width:100%;background-color:rgb(0, 48, 0);"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="float-end" style="width:6%;height:100%;" id="addButton"><img style="width:max-width;height:max-height;" src="icon/building-add.svg"></button></div>
            </div>

        </div>
    </main>
</body>

</html>