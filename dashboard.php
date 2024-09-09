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
  <title>Dashboard</title>
  <link rel="icon" href="Staff_Icon.png" type="image/x-icon">

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/customArif.css" rel="stylesheet">
  <link href="css/bootstrap.css" rel="stylesheet">
  <link href="css/sidebars.css" rel="stylesheet">
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="jQuery/jQuery.js"></script>
  <script src="chartJS/package/dist/chart.js"></script>


  <script>
    (function() {
      'use strict'
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl)
      })
    })()
  </script>

  <style>
    .chartContainer {
      width: 90%;
      height: auto;
      border: 2px solid black;
      margin-top: 20px;
      padding: 30px 30px 30px 30px;
      border-radius: 20px;
    }

    .charttitle {
      text-align: center;
      font-family: 'Open Sans', sans-serif;
      font-weight: bold;
      font-size: larger;
      color: black;
    }

    .card {
      color: white;
      background-position: center;
      background-color: #023500;
      background-repeat: no-repeat;
      background-size: 115%;
      transition: all 0.5s ease-in-out;
      border: 2px solid black;
      cursor: pointer;
      -webkit-user-select: none;
      /* Safari */
      -ms-user-select: none;
      /* IE 10 and IE 11 */
      user-select: none;
      /* Standard syntax */
    }

    .card .card-text {
      margin-top: 20px;
      font-size: 30px;
      font-weight: 600;
    }

    .card:hover {
      background-size: 120%;
    }

    .card:hover img {
      transform: scale(1.1);
    }

    .card img {
      transition: transform 0.5s ease;
    }

    .card-title {
      font-size: medium !important;
    }
  </style>
</head>

<body>
  <?php
  include "config/getBuilding.php";
  include "config/getEmployee.php";
  include "config/getRoom.php";
  include "config/getUnit.php";
  ?>
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
          <a href="#" class="Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
            <span><img style="transform:scale(2);"src="./icon/appliances.png" alt="plug" width="33" height="33"></span>
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

    <div class="container-fluid" style="overflow-x:hidden;">
      <div class="grip gap-3 row d-flex align-items-center justify-content-center ps-4 pb-4" style="background-color:rgb(74, 139, 74);">
        <div class="fw-bold mt-2 w-100" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
          HOME
        </div>
        <hr>

        <div class="card" style="width: 20%;height:70%" onclick="window.location.href='building.php'">
          <div class="card-body container-fluid">
            <div class="row">
              <div class="col-lg-8">
                <h5 class="card-title">Building</h5>
                <p class="card-text"><?php echo $numOfBuilding ?></p>
              </div>
              <div class="col-lg-4">
                <img src="icon/buildings-fill.svg" class="img-fluid" style="width:100%;height:100%">
              </div>
            </div>
          </div>
        </div>


        <div class="card" style="width: 20%;height:70%;background-color: #024000;" onclick="window.location.href='employee.php'">
          <div class="card-body container-fluid">
            <div class="row">
              <div class="col-lg-8">
                <h5 class="card-title">Employee</h5>
                <p class="card-text"><?php echo $numEmployee ?></p>
              </div>
              <div class="col-lg-4">
                <img src="icon/person-fill.svg" class="img-fluid" style="width:100%;height:100%">
              </div>
            </div>
          </div>
        </div>

        <div class="card" style="width: 23%;height:70%;background-color: #024500;" onclick="window.location.href='units.php'">
          <div class="card-body container-fluid">
            <div class="row">
              <div class="col-lg-8">
                <h5 class="card-title">Num. Of Units</h5>
                <p class="card-text"><?php echo $numOfUnit ?></p>
              </div>
              <div class="col-lg-4">
                <img src="icon/door-open-fill.svg" class="img-fluid" style="width:100%;height:100%">
              </div>
            </div>
          </div>
        </div>

        <div onclick="window.location = 'rooms.php?type=1'" class="card" style="width: 26%;height:70%;background-color: #025000;">
          <div class="card-body container-fluid">
            <div class="row">
              <div class="col-lg-8">
                <h5 class="card-title">Occupied Room</h5>
                <p class="card-text"><?php echo $occupiedRoom ?></p>
              </div>
              <div class="col-lg-4 pt-4">
                <img src="icon/sleep-icon.png" class="img-fluid" style="width:100%;height:70%">
              </div>
            </div>
          </div>
        </div>

        <div onclick="window.location = 'rooms.php?type=0'"class="card" style="width: 26%;height:70%;background-color: #025500;">
          <div class="card-body container-fluid">
            <div class="row">
              <div class="col-lg-8">
                <h5 class="card-title">Vacant Room</h5>
                <p class="card-text"><?php echo $vacantRoom ?></p>
              </div>
              <div class="col-lg-4 pt-3">
                <img src="icon/bed-icon.webp" class="img-fluid" style="width:100%;height:88%">
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class=" col-sm-12" style="background-color:black;height:5px;"></div>
      </div>
      <?php
      include "config/connectDB.php";
      $empGraphQuery = "SELECT";
      ?>
      <!-- CHART -->
      <div class="row" style="height:100%;background-color:rgb(74,139,74);">
        <div class="d-flex col-lg-8 mt-4  border border-primary justify-content-center">
          <div class="chartContainer  ">
            <div class="charttitle  ">EMPLOYEE CHART BY RANK</div>
            <hr style="margin-bottom:30px;">
            <canvas id="myChart"></canvas>
          </div>
        </div>
      </div>



    </div>
  </main>
</body>

</html>