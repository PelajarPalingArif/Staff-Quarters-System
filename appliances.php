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
    <title>Appliances</title>
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
        var currAppIDClick = '1';
        function setCurrAppIDClick(appID){
            currAppIDClick = appID;
            document.getElementById("appIdPlaceholder").value = appID;
            console.log(currAppIDClick + "," + appID);
            let getAppInfoReq = new XMLHttpRequest();
            getAppInfoReq.open("GET","config/getAppInfo.php?appID=" + currAppIDClick,true);
            getAppInfoReq.onreadystatechange = function() {
                if(getAppInfoReq.readyState == 4 && getAppInfoReq.status == 200){
                    let EditAppNameInput = document.getElementById("inputEditAppName");
                    let EditAppDescInput = document.getElementById("inputEditAppDesc");
                    let responseData = JSON.parse(getAppInfoReq.responseText);
                    EditAppNameInput.value = responseData.name; 
                    EditAppDescInput.innerHTML = responseData.desc;
                }
            }
            getAppInfoReq.send()
        }
        function EditAppliances() {
            let editButton = document.getElementById('EditAppButton');

            let inputAppName = document.getElementById("inputEditAppName").value;
            let inputAppDesc = document.getElementById("inputEditAppDesc").value;
            let objID = document.getElementById('inputEditAppName');
            let objID1 = document.getElementById('inputEditAppDesc');
            // console.log(inputAppName + "," + inputAppDesc + "," + document.getElementById("appIdPlaceholder").value);
            let checker = true;
            if (inputAppName == "") {
                console.log("AppNameBlank");
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                checker = false;
            }
            if (inputAppDesc == "") {
                console.log("AppDescBlank");
                objID1.classList.remove("is-valid");
                objID1.classList.add("is-invalid");
                checker = false;
            }
            if (checker) {
                addButton.disabled = true;
                document.getElementById('editAppliance').submit();
                setTimeout(() => {
                    location.reload();
                }, 200);
            }
        }

        
        function remAppliences(val) {
            console.log(val);
            let remAppRequest = new XMLHttpRequest();
            remAppRequest.open("GET", "config/remApplience.php?appID=" + val, true);
            remAppRequest.onreadystatechange = function() {
                if (remAppRequest.readyState == 4 && remAppRequest.status == 200) {
                    window.location.reload();
                }
            }
            remAppRequest.send();
        }

        function addAppliances() {
            let addButton = document.getElementById('addAppButton');

            let inputAppName = document.getElementById("inputAppName").value;
            let inputAppDesc = document.getElementById("inputAppDesc").value;
            let objID = document.getElementById('inputAppName');
            let objID1 = document.getElementById('inputAppDesc');
            let checker = true;
            if (inputAppName == "") {
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                checker = false;

            }
            if (inputAppDesc == "") {
                objID1.classList.remove("is-valid");
                objID1.classList.add("is-invalid");
                checker = false;
            }
            if (checker) {
                addButton.disabled = true;
                document.getElementById('addAppliance').submit();
                setTimeout(function() {
                    location.reload();
                }, 600);
            }
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
    <iframe style="display:none;"name="dummyframe" id="dummyframe"></iframe>

    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch static backdrop modal
    </button> -->


    <div class="modal fade" id="editApp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editAppLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editAppLabel">Edit Appliences</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form target="dummyframe" id="editAppliance" action="config/editAppliances.php" class="row g-3 needs-validation" method="post" novalidate>
                        <input name="appIdPlaceholder" id="appIdPlaceholder" style="display:none;"type="text">
                        <div class="col-md-12">
                            <label for="nameinput" class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img style="transform:scale(2.0);" src="./icon/appliances.png" alt="AppliancesName" width="26" height="26"></span>
                                <input type="text" class="form-control" name="inputEditAppName" id="inputEditAppName" onkeyup="isBlank(this.value,'inputEditAppName')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Name
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="descinput" class="form-label">Description</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/file-earmark-text-fill.svg" alt="AppliancesDesc" width="26" hei ght="26"></span>
                                <textarea type="text" class="form-control" name="inputEditAppDesc" id="inputEditAppDesc" onkeyup="isBlank(this.value,'inputEditAppDesc')" required></textarea>
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
                        <button id="EditAppButton" type="button" class="btn btn-success" onclick="EditAppliances();">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Appliances</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form target="dummyframe" id="addAppliance" action="config/addAppliances.php" class="row g-3 needs-validation" method="post" novalidate>
                        <div class="col-md-12">
                            <label for="nameinput" class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img style="transform:scale(2.0);" src="./icon/appliances.png" alt="AppliancesName" width="26" height="26"></span>
                                <input type="text" class="form-control" name="inputAppName" id="inputAppName" onkeyup="isBlank(this.value,'inputAppName')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Name
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="descinput" class="form-label">Description</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/file-earmark-text-fill.svg" alt="AppliancesDesc" width="26" hei ght="26"></span>
                                <textarea type="text" class="form-control" name="inputAppDesc" id="inputAppDesc" onkeyup="isBlank(this.value,'inputAppDesc')" required></textarea>
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
                    <button id="addAppButton" type="button" class="btn btn-success" onclick="addAppliances();">Add</button>
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
                    <a href="units.php" class="border Arifnav Arifinactive d-flex align-items-center" aria-current="page">
                        <span><img src="./icon/door-open-fill.svg" alt="units" width="33" height="33"></span>
                        <p class="ms-3">
                            Units
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
                    },
                });
            });
        </script>
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                List of Appliances
            </div>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>
            

            <div class="row mt-4 pt-4 pb-4" style="background-color:rgb(0, 48, 0);color:white">
                <table id="buildTable" class="table table-success  table-hover border border-success table-bordered mt-4">
                    <thead class="table-dark">
                        <th scope="col" style="text-align:center;">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        include("config/connectDB.php");
                        if (!$conn) {
                            die("Connection Failed: " . mysqli_connect_error());
                        }
                        $num = 1;
                        $listAppQuery =  "SELECT * FROM `applience`";
                        $listAppResult = mysqli_query($conn, $listAppQuery);
                        if ($listAppResult) {

                            while ($row = mysqli_fetch_assoc($listAppResult)) {
                                $aid = $row['ApplienceID'];
                                $an = $row['ApplienceName'];
                                $desc = $row['Description'];
                                echo "<tr>";
                                echo "<td scope=\"row\" style=\"font-weight:bold;text-align:center;\">$num</td>";
                                // echo "<td style=\"font-weight:500;\">$aid</td>";
                                echo "<td style=\"font-weight:500;\">$an</td>";
                                echo "<td style=\"font-weight:500;\">$desc</td>";
                                echo "<td><div class=\"actionRow\"><button data-bs-toggle=\"modal\" onclick=\"setCurrAppIDClick($aid)\"data-bs-target=\"#editApp\"class=\"editButton\"><img src=\"icon/pencil-square.svg\"></button><button onclick=\"remAppliences($aid)\"class=\"dumpButton\"><img src=\"icon/trash.svg\"></button></div></td>";
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
                <div class="col pb-3 pt-2" style="width:100%;background-color:rgb(0, 48, 0);"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="float-end" style="width:6%;height:100%;" id="addButton"><img style="transform:scale(2);" src="./icon/appliances-add.png" alt="plug" width="20" height="20"></button></div>
            </div>

        </div>
    </main>
</body>

</html>
