<?php
session_start();
if(isset($_SESSION["empID"])){
  header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Quarters System</title>
  <link rel="icon" href="icon\Staff_Icon.png" type="image/x-icon">
  <link rel="stylesheet" href="css\bootstrap.css">
  <link rel="stylesheet" href="css\customArif.css">
  <script src="js\bootstrap.js"></script>
</head>

<body style="background-image: url('./image/StaffQuartersAboveView.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;">
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background-color:red">
          <h3 class="modal-title" id="exampleModalLabel">Alert</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex justify-content-center mt-3" style="height:85px">
          <h4>Wrong Employee ID or Password<h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <iframe name="dummyframe" id="dummyframe" style="display:none;"></iframe>
  <!-- TOP BAR -->
  <div class="card w-100 bg-gradient border border-dark border-bottom border-5" style="background-color:#015919">
    <div class="card-body ms-2">
      <h1 class="text-uppercase" style="letter-spacing:3px;font-family: 'Gabarito', sans-serif;font-weight:700;color:black;font-size:45px;margin-left:20px;">Staff &nbsp;Quarters &nbsp; System</h1>
    </div>
  </div>

  <!-- LOG IN CONTAINER -->
  <div class="container d-flex align-items-center justify-content-center pt-5">
    <!--  LOG IN BOX  -->
    <div class="card w-50 border border-secondary border-4 border-dark">
      <div class="card-header d-flex justify-content-center">
        Log In
      </div>
      <div class="card-body">
        <form id="loginForm" target="dummyframe" action="config/actionLogin.php" class="needs-validation" method="post" novalidate>
          <div class="mb-3 pt-4">
            <label for="Username" class="form-label fs-6" style="font-family:'Poppins', sans-serif;">Employee ID</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><img src="./icon/person-circle.svg" alt="Person" width="26" height="26"></span>
              <input type="text" class="form-control" id="UserNameID" name="UserName" onkeyup="isBlank(this.value,'UserNameID')" required>
              <div class="invalid-feedback">
                Please Enter an ID!
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="Password" class="form-label fs-6" style="font-family:'Poppins', sans-serif;">Password</label>
            <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><img src="./icon/lock-fill.svg" alt="Lock" width="26" height="26"></span>
              <input type="password" class="form-control" id="PasswordId" name="Password" onkeyup="isBlank(this.value,'PasswordId')" required>
              <div class="invalid-feedback">
                Please Enter a Password!
              </div>
            </div>
          </div>

          <div class="w-100 p-3 d-flex justify-content-center">Don't have an account?&nbsp;<a href="register.php" style="text-decoration:none;">Register</a></div>
          <button class="btn btn-primary float-end mt-2 btnArif-1" type="button" value="login" name="login" id="login" onclick="validateForm()">Log In</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
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

    function validateForm() {
      let $empID = document.getElementById('UserNameID').value;
      let $empPass = document.getElementById('PasswordId').value;
      let formisValid = true;
      if (isBlank($empID, 'UserNameID')) formisValid = false;
      if (isBlank($empPass, 'PasswordId')) formisValid = false;
      if (formisValid) {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "config/fetchRightLogin.php", true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send("loginName=" + $empID + "&loginPass=" + $empPass);
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 0) {
              document.getElementById('loginForm').submit();
              console.log("ran");
              window.location.href = "dashboard.php";
            } else {
              let myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                keyboard: true
              });
              myModal.show();

            }
          }
        }
      }

    }

    var ele = document.getElementById("loginForm");
    ele.addEventListener("keypress", function(event) {
      if (event.key === "Enter") {
        document.getElementById("login").click();
      }
    });
  </script>


</body>

</html>