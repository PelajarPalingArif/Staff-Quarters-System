<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="icon\Staff_Icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css\bootstrap.css">
    <link rel="stylesheet" href="css\customArif.css">
    <script src="js\bootstrap.js"></script>
    <script src="js\bootstrap.bundle.min.js"></script>
</head>

<body style="overscroll-behavior-y: none;background-image: url('./image/StaffQuartersAboveView.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
    <div class="card w-100 bg-gradient border border-dark border-bottom border-5" style="background-color:#015919">
        <div class="card-body ms-2">
            <h1 class="text-uppercase " style="letter-spacing:3px;font-family: 'Gabarito', sans-serif;font-weight:700;color:black;font-size:45px;margin-left:20px;">
                Staff &nbsp;Quarters &nbsp; System</h1>
        </div>
    </div>

    <div class="container d-flex align-items-center justify-content-center pt-5">

        <div class="card w-75 border border-secondary border-4 border-dark">
            <div class="card-header d-flex justify-content-center">
                Registration
            </div>
            <div class="card-body ms-2">
                <form target="dummyframe" id="registerForm" action="config/actionRegister.php" class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
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
                                Please enter the Employee's Phone Number
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
                            <input type="text" class="form-control" name="lockerinput" id="Locker" onkeyup="isValid('Locker')">
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


                    <div class="w-100 p-3 d-flex justify-content-center">Have an account?&nbsp;<a href="index.php" style="text-decoration:none;">Log In</a></div>
                    <div class="col-md-9"></div>
                    <button type="button" onclick="idHint(document.getElementById('idinput').value,0)" id="validateRegister" class="ms-6 col-md-2 btn btn-primary float-end mt-2 btnArif-1" value="register" name="register">Register</button>
                </form>


                <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="height:500px">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Administrator / Manager Account</h5>
                                <button type="button" id="buttonCloseModal" onclick="restoreModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                            </div>
                            <form id="verifyForm" class="need-validity" novalidate>
                                <div class="modal-body" id="modalBody">
                                    <div>
                                        <div class="form-floating mb-3">

                                            <input id="adminAcc" type="text" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                            <label for="floatingInput">Employee ID</label>
                                            <div class="invalid-feedback">
                                                Please enter your Employee ID
                                            </div>
                                        </div>

                                        <div class="form-floating">
                                            <input id="adminPass" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                            <label for="floatingPassword">Password</label>
                                            <div class="invalid-feedback">
                                                Please enter your password
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-4">
                                    <button id="submitButton" type="button" class="btn btn-primary" onclick="verifyAdminMgr()">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>
    </div>

    <script>
        function isValid(str) {
            document.getElementById(str).classList.add("is-valid");
        }

        function idHint(num, ori) {
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
                isValid('Locker')

                if (formisValid) {
                    let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                        keyboard: false
                    })
                    myModal.show();
                }

            }
        }


        // AVOID RESUBMIT FORM ON REFRESH
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        function verifyAdminMgr() {
            'use strict'
            let form1 = document.getElementById("verifyForm");
            if (!form1.checkValidity()) {
                form1.classList.add('was-validated');
                return;
            } else {
                form1.classList.add('was-validated');
            }
            let submitButton = document.getElementById("submitButton");
            let closeButton = document.getElementById("buttonCloseModal");
            submitButton.disabled = true;
            closeButton.disabled = true;
            let xmlhttp = new XMLHttpRequest();
            let inputAdminEmpID = document.getElementById("adminAcc").value;
            let inputAdminEmpPass = document.getElementById("adminPass").value;
            document.getElementById("modalBody").innerHTML = `
                    <div class="d-flex justify-content-center mt-5" style="height:100px">
                        <div class="spinner-border" role="status" style="width: 3rem; height: 3rem;" >
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    `;

            setTimeout(function() {
                let empID = document.getElementById("idinput").value;
                let empPass = document.getElementById("passwordInput").value;
                xmlhttp.open("POST", "config/fetchAdminMgrAcc.php", true);
                xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xmlhttp.send("adminID=" + inputAdminEmpID + "&adminEmpPass=" + inputAdminEmpPass);
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        closeButton.disabled = false;
                        if (this.responseText == 0) {
                            document.getElementById("modalBody").innerHTML =
                                `
                            <div class="col-md-12 d-flex justify-content-center mt-5" >
                                <img src="image/success_checkmark.png" alt="" style="height:60px;width:60px;">
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                <h3>REGISTRATION ADDED</h3>
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                Employee ID : ` + empID + `<br>` + `Password : ` + empPass + `
                            </div>
                            `;

                            document.getElementById('registerForm').submit();
                            setTimeout(function() {
                                window.location.href = "index.php";
                            }, 2000);

                        } else {
                            console.log("fail");
                            document.getElementById("modalBody").innerHTML =
                                `
                            <div class="col-md-12 d-flex justify-content-center mt-5" >
                                <img src="image/fail_cross.png" alt="" style="height:60px;width:60px;">
                            </div>
                            <div class="d-flex justify-content-center mt-2">
                                <h3>REGISTRATION FAILED</h3>
                            </div>
                            `;
                        }
                    }
                }
            }, 1000);

            closeButton.disabled = false;
        }

        // ADD SO WHEN USER IS PRESSING ENTER THE 'REGISTER BUTTON IS PRESSED / CLICKED'
        var ele = document.getElementById("registerForm");
        ele.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                document.getElementById("validateRegister").click();
            }
        });

        // RESTORE MODAL INTO ORIGINAL STATE
        function restoreModal() {
            let submitButton = document.getElementById("submitButton");
            submitButton.disabled = false;
            document.getElementById("modalBody").innerHTML = `
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="adminAcc" placeholder="name@example.com" required>
                <label for="floatingInput">Employee ID</label>
                    <div class="invalid-feedback">
                        Please enter your Employee ID
                    </div>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="adminPass" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">
                        Please enter your Password
                    </div>
            </div>
            `
            let verForm = document.getElementById("verifyForm");
            verForm.classList.remove("was-validated");
        }
    </script>
</body>

</html>