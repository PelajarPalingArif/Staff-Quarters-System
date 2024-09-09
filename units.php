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
    <title>Units</title>
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
        var currUnitID = 1;
        (function() {
            'use strict'
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })()

        function setCurrUnitIDClick(val, buildName, uc) {
            currUnitID = val;
            document.getElementById("unitIDPlaceHolder").value = val;
            document.getElementById("BuildingPlaceholder").value = buildName;
            document.getElementById("inputEditRoom").value = uc;
        }

        function editUnits() {
            let editButton = document.getElementById('EditAppButton');

            let inputUnitName = document.getElementById("inputEditRoom").value;
            let objID = document.getElementById('inputEditRoom');
            let checker = true;
            if (inputUnitName == "") {
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                checker = false;
            }
            if (checker) {
                editButton.disabled = true;
                document.getElementById('editUnitsForm').submit();
                setTimeout(() => location.reload(), 200);
            } else {}
        }

        function dumpUnits(unitID) {
            console.log(unitID);
            let remUnitReq = new XMLHttpRequest();
            remUnitReq.open("GET", "config/remUnits.php?unitID=" + unitID, true);
            remUnitReq.onreadystatechange = function() {
                if (remUnitReq.readyState == 4 && remUnitReq.status == 200) {
                    location.reload();
                }
            }
            remUnitReq.send();

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

        function addUnits() {
            let addButton = document.getElementById('addUnitsButton');
            let inputUnitsName = document.getElementById("inputUnitCode").value;
            let objID = document.getElementById('inputUnitCode');
            if (inputUnitsName == "") {
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                return;
            } else {
                addButton.disabled = true;
                document.getElementById('addUnits').submit();
                setTimeout(function() {
                    location.reload();
                }, 600);
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
    <div class="modal fade" id="exportUnits" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportUnitsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportUnitsLabel">Export Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container-fluid">
                    <form action="config/exportUnits.php" method="get">
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
                                    Units
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="RoomCheckBox" name="RoomCheckBox" checked>
                                <label class="form-check-label" for="RoomCheckBox">
                                    Rooms
                                </label>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col">
                                Export To :
                                <select name="exportTo" id="exportTo">
                                    <option value="0">PDF</option>
                                    <option value="3">CSV</option>
                                    <option value="4">Excel</option>
                                </select>
                                <div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <iframe name="dummyframe" style="display:none" id="dummyframe"></iframe>
    <div class="modal fade" id="editUnits" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editUnitsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editUnitsLabel">Edit Units</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="buildname" class="form-label">Building</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><img src="./icon/buildings.svg" alt="AppliancesName" width="26" height="26"></span>
                            <input type="text" class="form-control" name="BuildingPlaceholder" id="BuildingPlaceholder" disabled>
                        </div>
                    </div>
                    <form target="dummyframe" id="editUnitsForm" action="config/editUnit.php" class="row g-3 needs-validation" method="post" novalidate>
                        <input name="unitIDPlaceHolder" id="unitIDPlaceHolder" type="text" style="display:none">
                        <div class="col-md-12">
                            <label for="descinput" class="form-label">Units</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/door-open-fill.svg" alt="AppliancesDesc" width="26" hei ght="26"></span>
                                <input type="text" class="form-control" name="inputEditRoom" id="inputEditRoom" onkeyup="isBlank(this.value,'inputEditRoom')" required></input>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Description
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button id="EditAppButton" type="button" class="btn btn-success" onclick="editUnits()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Units</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form target="dummyframe" id="addUnits" action="config/AddUnits.php" class="row g-3 needs-validation" method="post" novalidate>
                        <div class="col-md-6">
                            <label for="buildname" class="form-label">Building</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/buildings.svg" alt="buildingname" width="26" height="26"></span>
                                <select class="form-select" aria-label="Default select example" name="buildname" id="idbuildname" onchange="isBlank(this.value,'idbuildname')" required>
                                    <?php
                                    include "config/connectDB.php";
                                    $getListQuery = "SELECT `BuildingBlockID`,`BuildingName` FROM `buildingblock`";
                                    $result = mysqli_query($conn, $getListQuery);
                                    $listOfBuilding = array();
                                    while ($row = mysqli_fetch_array($result)) {
                                        $listOfBuilding[] = array($row[0], $row[1]);
                                    }
                                    $count = 0;
                                    foreach ($listOfBuilding as $val) {

                                        if ($count == 0) {
                                            echo "<option selected value=\"$val[0]\">$val[1]</option>";
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

                        <div class="col-md-6">
                            <label for="unitcode" class="form-label">Unit Code</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/door-open-fill.svg" alt="unitcode" width="26" height="26"></span>
                                <input type="text" class="form-control" name="inputUnitCode" id="inputUnitCode" onkeyup="isBlank(this.value,'inputUnitCode')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Unit Code
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button id="addUnitsButton" type="button" class="btn btn-success" onclick="addUnits();">Add</button>
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
                    <a href="#" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
                        },
                        "emptyTable": "No Units In This Building"
                    },
                    initComplete: function() {
                        this.api()
                            .columns()
                            .every(function() {
                                let column = this;
                                let title = column.footer().textContent;

                                // Create input element
                                let input = document.createElement('input');
                                input.placeholder = title;
                                column.footer().replaceChildren(input);

                                // Event listener for user input
                                input.addEventListener('keyup', () => {
                                    if (column.search() !== this.value) {
                                        column.search(input.value).draw();
                                    }
                                });
                            });
                    }
                });
            });
        </script>
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <?php
            if (isset($_GET['buildID'])) {
                $tempBuildName = $_GET['buildName'];
                echo "<div class=\"fw-bold mt-4 w-100 ms-3 mb-4\" style=\"font-family: 'Open Sans', sans-serif;font-size:40px;color:black;\">
                $tempBuildName's Units
            </div>";
            } else {
                echo "<div class=\"fw-bold mt-4 w-100 ms-3 mb-4\" style=\"font-family: 'Open Sans', sans-serif;font-size:40px;color:black;\">
                List of Units
            </div>";
            }
            ?>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 pt-3 " style="flex-wrap:wrap;">
                    <button data-bs-toggle="modal" data-bs-target="#exportUnits" class="export-button"><img src="icon/file-earmark-arrow-down-fill.svg" alt=""><span class="button-text">Export</span></button>
                </div>
            </div>

            <div class="row mt-4 pt-4 pb-4" style="background-color:rgb(0, 48, 0);color:white">
                <table id="buildTable" class="table table-success  table-hover border border-success table-bordered mt-4">
                    <thead class="table-dark">
                        <th scope="col" style="text-align:center;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Units</th>
                        <th scope="col">Rooms</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        include("config/connectDB.php");
                        if (!$conn) {
                            die("Connection Failed: " . mysqli_connect_error());
                        }
                        $num = 1;

                        // "SELECT  u.`UnitID`,u.`UnitCode`,b.`BuildingName`,COUNT(r.`UnitID`) as Pax FROM `unit` u 
                        // LEFT JOIN `BuildingBlock` b ON b.`BuildingBlockID` = u.`BuildingBlockID`
                        // LEFT JOIN `Rooms` r ON r.`UnitID` = u.`UnitID`
                        // GROUP BY u.`UnitID`;
                        // "; 
                        $listUnitsQuery =  "SELECT  u.`UnitID`,u.`UnitCode`,b.`BuildingName`,b.`BuildingBlockID`,COUNT(r.`UnitID`) as Pax FROM `unit` u 
                        LEFT JOIN `BuildingBlock` b ON b.`BuildingBlockID` = u.`BuildingBlockID`
                        LEFT JOIN `Rooms` r ON r.`UnitID` = u.`UnitID`
                        GROUP BY u.`UnitID` ORDER BY b.`BuildingBlockID` ASC,u.`UnitCode` ASC;
                        ";
                        if (isset($_GET['buildID'])) {
                            $tempBuildID =  $_GET['buildID'];
                            $listUnitsQuery =  "SELECT  u.`UnitID`,u.`UnitCode`,b.`BuildingName`,b.`BuildingBlockID`,COUNT(r.`UnitID`) as Pax FROM `unit` u 
                        LEFT JOIN `BuildingBlock` b ON b.`BuildingBlockID` = u.`BuildingBlockID`
                        LEFT JOIN `Rooms` r ON r.`UnitID` = u.`UnitID`
                        WHERE b.`BuildingBlockID` = $tempBuildID
                        GROUP BY u.`UnitID` ORDER BY b.`BuildingBlockID` ASC,u.`UnitCode` ASC;
                        ";
                        }
                        $listUnitsResult = mysqli_query($conn, $listUnitsQuery);
                        if ($listUnitsResult) {

                            while ($row = mysqli_fetch_assoc($listUnitsResult)) {
                                $uID = $row['UnitID'];
                                $uc = $row['UnitCode'];
                                $bn = $row['BuildingName'];
                                $pax = $row['Pax'];
                                echo "<tr>";
                                echo "<td scope=\"row\" style=\"font-weight:bold;text-align:center;\">$num</td>";
                                echo "<td style=\"font-weight:500;\">$bn</td>";
                                echo "<td style=\"font-weight:500;\">$uc</td>";
                                echo "<td style=\"font-weight:500;\">$pax</td>";
                                //! ADD : ACTION BUTTON
                                //onclick=\"window.location.href(\"rooms.php?unitID = $uID\")\"
                                // <button onclick=\"console.log('Hi');\">Click to Redirect</button>
                                echo "<td><div class=\"actionRow\"><button onclick='window.location.href=`rooms.php?unitID=$uID`';\" class=\"viewButton firstButton\"><img src=\"icon/eye.svg\"></button><button data-bs-toggle=\"modal\" onclick=\"setCurrUnitIDClick('$uID','$bn','$uc')\" data-bs-target=\"#editUnits\" class=\"editButton\"><img src=\"icon/pencil-square.svg\"></button><button onclick=\"dumpUnits($uID)\"class=\"dumpButton\"><img src=\"icon/trash.svg\"></button></div></td>";
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
                        <tr>
                            <th scope="col" style="text-align:center;">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Units</th>
                            <th scope="col">Rooms</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col pb-3 pt-2" style="width:100%;background-color:rgb(0, 48, 0);"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="float-end" style="width:6%;height:100%;" id="addButton"><img style="transform:scale(1.2);width:33px;height:33px;" src="icon/door-open-fill-add.png"></button></div>
            </div>

        </div>
    </main>
</body>

</html>