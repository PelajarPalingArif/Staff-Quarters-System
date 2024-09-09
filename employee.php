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
    <title>Employees</title>
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
        function isValid(str) {
            document.getElementById(str).classList.add("is-valid");
        }

        function remEmployee(employeeID) {
            let remEmployeeReq = new XMLHttpRequest();
            remEmployeeReq.open("GET", "config/remEmployee.php?empID=" + employeeID, true);
            remEmployeeReq.onreadystatechange = () => {
                if (remEmployeeReq.readyState == 4 && remEmployeeReq.status == 200) {
                    setTimeout(() => {
                        location.reload();
                    }, 400);
                }
            }
            remEmployeeReq.send();
        }

        function showPassword(employeeID) {
            let reqEmpPassword = new XMLHttpRequest();
            reqEmpPassword.open("GET", "config/getPass.php?empID=" + employeeID, true);
            reqEmpPassword.onreadystatechange = () => {
                if (reqEmpPassword.readyState == 4 && reqEmpPassword.status == 200) {
                    console.log(reqEmpPassword.responseText.trimStart());
                    // document.getElementById("InputGetPass").value = reqEmpPassword.responseText.trimStart();
                    // var myModal = new bootstrap.Modal(document.getElementById('getPassModal'), {
                    //     backdrop: 'static',
                    //     keyboard: false
                    // });
                    // myModal.show();
                }
            }
            reqEmpPassword.send();
        }

        function idHint(num, ori) {
            //ori = 1
            let xmlhttp2 = new XMLHttpRequest();
            xmlhttp2.open("POST", "config/validEmpID.php", true);
            xmlhttp2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp2.send("empID=" + num);
            xmlhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let newempIDInput = document.getElementById('idinput');
                    if (this.responseText == 0) {
                        newempIDInput.classList.remove("is-invalid");
                        newempIDInput.classList.add("is-valid");
                        validateForm(true, ori);
                    } else if (this.responseText == 1) {
                        document.getElementById("empIdInvalid").innerHTML = `Employee ID is Taken`;
                        newempIDInput.classList.remove("is-valid");
                        newempIDInput.classList.add("is-invalid");
                        validateForm(false, ori);
                    } else {
                        document.getElementById("empIdInvalid").innerHTML = `Please Enter an Employee's ID`;
                        newempIDInput.classList.remove("is-valid");
                        newempIDInput.classList.add("is-invalid");
                        validateForm(false, ori);
                    }
                }
            }
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

        function isPassword(val, id) {
            let regexExpression = "^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[^A-Za-z0-9]).{8,}$";
            let objID = document.getElementById(id);
            if (val.match(regexExpression)) {
                objID.classList.remove("is-invalid");
                objID.classList.add("is-valid");
                return true;
            } else {
                objID.classList.remove("is-valid");
                objID.classList.add("is-invalid");
                return false;
            }
        }


        function validateForm(idRes, origin) {
            let form = document.getElementById("registerForm");
            let formisValid = true;
            if (!idRes) {
                formisValid = false;
            }
            if (origin == 0) {
                let inputName = document.getElementById('nameinput');
                if (isBlank(inputName.value, 'nameinput')) formisValid = false;
                let inputPass = document.getElementById('passwordInput');
                if (!isPassword(inputPass.value, 'passwordInput')) formisValid = false;
                let inputPosi = document.getElementById('position');
                if (isBlank(inputPosi.value, 'position')) formisValid = false;
                let inputLoca = document.getElementById('location');
                if (isBlank(inputLoca.value, 'location')) formisValid = false;
                let inputGrade = document.getElementById('idgrade');
                if (isBlank(inputGrade.value, 'idgrade')) formisValid = false;
                isValid('PhoneNumber');
                isValid('Locker');
            }
            if (formisValid && origin != 1) {
                document.getElementById('registerForm').submit();
                setTimeout(function() {
                    location.reload();
                }, 900);
            }



        }


        // AVOID RESUBMIT FORM ON REFRESH
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function changeEmployee() {
            // TODO : COMPLETE THIS
            let form = document.getElementById("changeForm");
            let changeButton = document.getElementById("changeEmployeeButton");
            changeButton.disabled = true;
            let formisValid = true;

            let inputName = document.getElementById('changeNameInput');
            if (isBlank(inputName.value, 'changeNameInput')) formisValid = false;
            let inputPass = document.getElementById('changePassInput');
            if (!isPassword(inputPass.value, 'changePassInput')) formisValid = false;
            let inputPosi = document.getElementById('changePositionInput');
            if (isBlank(inputPosi.value, 'changePositionInput')) formisValid = false;
            let inputLoca = document.getElementById('changeLocationInput');
            if (isBlank(inputLoca.value, 'changeLocationInput')) formisValid = false;
            let inputGrade = document.getElementById('changeGrade');
            if (isBlank(inputGrade.value, 'changeGrade')) formisValid = false;
            isValid('changePhoneNumber');
            isValid('changeLocker')

            if (formisValid) {
                document.getElementById("changeForm").submit();
                setTimeout(() => {
                    location.reload();
                }, 300);
            } else {
                changeButton.disabled = false;
                console.log("Not Ran")
            }

        }

        function openModalChangeEmployee(empID) {
            let getEmpDataReq = new XMLHttpRequest();
            getEmpDataReq.open("GET", "config/getEmpData.php?empID=" + empID, true);

            getEmpDataReq.onreadystatechange = () => {
                if (getEmpDataReq.readyState == 4 && getEmpDataReq.status == 200) {
                    let empData = JSON.parse(getEmpDataReq.responseText);

                    document.getElementById("changeNameInput").value = empData.Name;
                    document.getElementById("changePassInput").value = empData.Password;
                    document.getElementById("changePositionInput").value = empData.Position;
                    document.getElementById("changeLocationInput").value = empData.Location;
                    document.getElementById("changeGrade").selected = empData.Grade;
                    document.getElementById("changePhoneNumber").value = empData.ContactNumber;
                    document.getElementById("changeLocker").value = empData.Locker;
                    console.log(empData);
                }

            }
            getEmpDataReq.send();
            document.getElementById('changeID').value = empID;
            document.getElementById('changeIDPlaceHolder').value = empID;
            var myModal = new bootstrap.Modal(document.getElementById('changeEmployeeModal'), {
                backdrop: 'static',
                keyboard: false
            });
            myModal.show()
        }

        (function() {
            'use strict'
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })()
    </script>

    <style>
        
        .actionRow button {
            width: 30px;
            height: 30px;
            flex-wrap: wrap;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .actionRow button img {
            width: 20px;
            height: 20px;
        }

        td,
        th {
            font-size: 13px;
        }

        .modal-lg {
            max-width: 80%;
        }

        /* Optional: Increase modal body height */
        .modal-lg .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="exportEmployee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exportEmployeeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportEmployeeLabel">Export Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container-fluid">
                    <form action="config/exportEmployee.php" method="get">
                        <div class="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="EmpIDCheckBox" name="EmpIDCheckBox" checked>
                                <label class="form-check-label" for="EmpIDCheckBox">
                                    Employee ID
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="NameCheckBox" name="NameCheckBox" checked>
                                <label class="form-check-label" for="NameCheckBox">
                                    Name
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="PosiCheckBox" name="PosiCheckBox" checked>
                                <label class="form-check-label" for="PosiCheckBox">
                                    Position
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="LocaCheckBox" name="LocaCheckBox" checked>
                                <label class="form-check-label" for="LocaCheckBox">
                                    Location
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="GradeCheckBox" name="GradeCheckBox" checked>
                                <label class="form-check-label" for="GradeCheckBox">
                                    Grade
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="ContactCheckBox" name="ContactCheckBox" checked>
                                <label class="form-check-label" for="ContactCheckBox">
                                    Contact Number
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="0" id="LockerCheckBox" name="LockerCheckBox" checked>
                                <label class="form-check-label" for="LockerCheckBox">
                                    Locker
                                </label>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col">
                                Export To :
                                <select name="exportTo" id="exportTo">
                                    <option value="0">PDF (Table)</option>
                                    <option value="1">PDF (Profile)</option>
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

    <div class="modal fade" id="getPassModal" tabindex="-1" aria-labelledby="getPassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="getPassModalLabel">Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><img src="./icon/lock-fill.svg" alt="Person" width="26" height="26"></span>
                        <input type="text" class="form-control" name="InputGetPass" id="InputGetPass" disabled>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" target="dummyframe" action="config/actionRegister.php" class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                        <div class="col-md-12">
                            <label for="idInput" class="form-label">Employee ID</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-badge-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="number" class="form-control" name="idinput" id="idinput" onkeyup="idHint(this.value,1)" required>
                                <div class="invalid-feedback" id="empIdInvalid">
                                    <div>Please enter the Employee ID </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="nameinput" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-circle.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="nameinput" id="nameinput" onkeyup="isBlank(this.value,'nameinput')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's Name
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="passwordInput" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/lock-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="password" class="form-control" name="passinput" id="passwordInput" onkeyup="isPassword(this.value,'passwordInput')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Password must contain 8 or more characters that are of at least one number, one uppercase and lowercase letter, and one special character
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 mt-3">
                            <label for="PhoneNumber" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/telephone-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="tel" class="form-control" name="phoneinput" id="PhoneNumber" onkeyup="isValid('PhoneNumber')">
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's position
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-workspace.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="posiinput" id="position" onkeyup="isBlank(this.value,'position')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's position
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="location" class="form-label">Location</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/geo-alt-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="locainput" id="location" onkeyup="isBlank(this.value,'location')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's work location
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="grade" class="form-label">Grade</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-badge.svg" alt="Person" width="26" height="26"></span>
                                <!-- <input type="text" class="form-control" id="grade" required> -->
                                <select class="form-select" aria-label="Default select example" name="namegrade" id="idgrade" onchange="isBlank(this.value,'idgrade')" required>
                                    <option selected value="RF">RF</option>
                                    <option value="DD">DD</option>
                                    <option value="CC2">CC2</option>
                                    <option value="CC1">CC1</option>
                                    <option value="CC">CC</option>
                                    <option value="BB2">BB2</option>
                                    <option value="BB1">BB1</option>
                                    <option value="BB">BB</option>
                                    <option value="AA">AA</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's grade
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="Locker" class="form-label">Locker Number</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/telephone-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="tel" class="form-control" name="lockerinput" id="Locker" onkeyup="isValid('Locker')">
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's Locker Number
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="Image" class="form-label">Image</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/images.svg" alt="Person" width="26" height="24"></span>
                                <input type="file" name="imageinput" class="form-control" id="imageinput">
                            </div>
                        </div>


                        <div class="col-md-9"></div>
                        <button type="button" onclick="idHint(document.getElementById('idinput').value,0)" id="validateRegister" class="ms-6 col-md-2 btn btn-primary float-end mt-2 btnArif-1" value="register" name="register">Add</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="changeEmployeeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="changeEmployeeModalLabel">Edit Employee</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="changeForm" target="dummyframe" action="config/actionChangeEmployee.php" class="row g-3 needs-validation" method="post" novalidate>
                        <input type="text" name="changeIDEmpPlaceHolder" style="display:none" id="changeIDPlaceHolder">
                        <div class="col-md-12">
                            <label for="idInput" class="form-label">Employee ID</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-badge-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="number" class="form-control" name="changeID" id="changeID" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="changeNameInput" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-circle.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="changeNameInput" id="changeNameInput" onkeyup="isBlank(this.value,'changeNameInput')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's Name
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="changePassInput" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/lock-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="password" class="form-control" name="changePassInput" id="changePassInput" onkeyup="isPassword(this.value,'changePassInput')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Password must contain 8 or more characters that are of at least one number, one uppercase and lowercase letter, and one special character
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6 mt-3">
                            <label for="changePhoneNumber" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/telephone-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="tel" class="form-control" name="changePhoneNumber" id="changePhoneNumber" onkeyup="isValid('changePhoneNumber')">
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's Phone Number
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="changePositionInput" class="form-label">Position</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-workspace.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="changePositionInput" id="changePositionInput" onkeyup="isBlank(this.value,'changePositionInput')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's Position
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="changeLocationInput" class="form-label">Location</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/geo-alt-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="text" class="form-control" name="changeLocationInput" id="changeLocationInput" onkeyup="isBlank(this.value,'changeLocationInput')" required>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's work location
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="changeGrade" class="form-label">Grade</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/person-badge.svg" alt="Person" width="26" height="26"></span>
                                <!-- <input type="text" class="form-control" id="grade" required> -->
                                <select class="form-select" aria-label="Default select example" name="changeGrade" id="changeGrade" onchange="isBlank(this.value,'changeGrade')" required>
                                    <option selected value="RF">RF</option>
                                    <option value="DD">DD</option>
                                    <option value="CC2">CC2</option>
                                    <option value="CC1">CC1</option>
                                    <option value="CC">CC</option>
                                    <option value="BB2">BB2</option>
                                    <option value="BB1">BB1</option>
                                    <option value="BB">BB</option>
                                    <option value="AA">AA</option>
                                </select>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's grade
                                </div>
                            </div>


                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="Locker" class="form-label">Locker Number</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><img src="./icon/telephone-fill.svg" alt="Person" width="26" height="26"></span>
                                <input type="tel" class="form-control" name="changeLocker" id="changeLocker" onkeyup="isValid('Locker')">
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                                <div class="invalid-feedback">
                                    Please enter the Employee's Locker Number
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9"></div>
                        <button type="button" onclick="changeEmployee();" id="changeEmployeeButton" class="ms-6 col-md-2 btn btn-primary float-end mt-2 btnArif-1" value="register" name="register">Submit</button>
                    </form>
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
                    <a href="#" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
                    "aLengthMenu": [
                        [25, 50, 100, -1],
                        [25, 50, 100, "All"]
                    ],
                    "iDisplayLength": -1,
                    "columnDefs": [{
                        "targets": [1, 2, 3, 4, 5, 6, 7],
                        "searchable": false
                    }],
                    "language": {
                        "paginate": {
                            "previous": "<span style=\"color:black\">Previous</span>",
                            "next": "<span style=\"color:black\">Next</span>"
                        }
                    },
                    "columnDefs": [{
                            "width": "20%",
                            "targets": 2
                        },
                        {
                            "width": "10%",
                            "targets": 6
                        }
                    ]

                });
            });
        </script>
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                List of Employees
            </div>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 pt-3 " style="flex-wrap:wrap;">
                    <button data-bs-toggle="modal" data-bs-target="#exportEmployee" class="export-button"><img src="icon/file-earmark-arrow-down-fill.svg" alt=""><span class="button-text">Export</span></button>
                </div>
            </div>

            <div class="row mt-4 pt-4 pb-4" style="background-color:rgb(0, 48, 0);color:white">
                <table id="buildTable" class="table table-success  table-hover border border-success table-bordered mt-4">
                    <thead class="table-dark">
                        <th scope="col">Employee ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Position</th>
                        <th scope="col">Location</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Contact Number</th>
                        <th scope="col">Locker</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        include("config/connectDB.php");
                        if (!$conn) {
                            die("Connection Failed: " . mysqli_connect_error());
                        }
                        $num = 1;
                        $listEmpQuery =  "SELECT `EmployeeID`,`ImageLink`,`Name`,`Position`,`Grade`,`PhoneNumber`,`Location`, COALESCE(NULLIF(`Locker`,''),'None') As `Locker1`FROM `employee`";
                        $listBuildingResult = mysqli_query($conn, $listEmpQuery);
                        if ($listBuildingResult) {
                            while ($row = mysqli_fetch_assoc($listBuildingResult)) {
                                $eid1 = $row['EmployeeID'];
                                $iml = $row['ImageLink'];
                                $n1 = $row['Name'];
                                $pos1 = $row['Position'];
                                $gr1 = $row['Grade'];
                                $phn1 = $row['PhoneNumber'];
                                $loc1 = $row['Location'];
                                $locker = $row['Locker1'];
                                echo "<tr>";
                                echo "<td scope=\"row\" style=\"font-weight:bold;text-align:center;\">$eid1</td>";
                                echo "<td style=\"font-weight:500;max-width:45px;max-height:40px\"><img src=\"image\\employee\\$iml\";  class=\"img-fluid img-thumbnail table-img\"></td>";
                                echo "<td style=\"font-weight:500;\">$n1</td>";
                                echo "<td style=\"font-weight:500;\">$pos1</td>";
                                echo "<td style=\"font-weight:500;\">$loc1</td>";
                                echo "<td style=\"font-weight:500;\">$gr1</td>";
                                echo "<td style=\"font-weight:500;\">$phn1</td>";
                                echo "<td style=\"font-weight:500;\">$locker</td>";
                                //! ADD : ACTION BUTTON
                                echo "<td class=\"actRow\"><div class=\"actionRow\"><button onclick=\"window.location.href = 'rooms.php?type=3&empID=$eid1'\"class=\"viewButton firstButton\"><img src=\"icon/house.svg\"></button><button onclick=\"openModalChangeEmployee($eid1)\"class=\"editButton\"><img src=\"icon/pencil-square.svg\"></button><button onclick=\"remEmployee($eid1)\"class=\"dumpButton\"><img src=\"icon/trash.svg\"></button><button onclick=\"showPassword($eid1)\"class=\"passButton\"><img src=\"icon/lock.svg\"></button></div></td>";
                                echo "</tr>";
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
                <div class="col pb-3 pt-2" style="width:100%;background-color:rgb(0, 48, 0);"><button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="float-end" style="width:6%;height:100%;" id="addButton"><img style="width:max-width;height:max-height;" src="icon/person-add.svg"></button></div>
            </div>

        </div>
    </main>
</body>

</html>