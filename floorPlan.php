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
    <title>Floor Plan</title>
    <link rel="icon" href="Staff_Icon.png" type="image/x-icon">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/customArif.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/sidebars.css" rel="stylesheet">


    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="jQuery/jQuery.js"></script>

    <style>
        .carousel-inner {
            height: 100%;
        }

        .carousel-item {
            background-color: black;
            width: 100%;

        }
        

        .carousel-item img {
            height: 400px;
            width: 400px;
            object-fit: contain;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .carousel-item {
            position: relative;
        }

        .carousel-item:hover img {
            opacity: 0.4;
        }

        .carousel-item:hover button {
            opacity: 1;
        }

        .carousel-button-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            /* Ensure buttons appear above the image */
        }

        .carousel-button-overlay button {
            opacity: 0;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            ;
        }
        .del-button {
            background-color: rgb(255, 99, 71, 0.5);
        }
        .del-button:hover {
            background-color: rgb(255, 99, 71, 1);
            outline: 2px solid red;
        }
        .down-button {
            background-color: rgb(27, 148, 13, 0.5);
            opacity: 0;
        }
        .down-button:hover {
            background-color: rgb(27, 148, 13, 1);
            outline: 2px solid green;
        }
        .error-message {
            color: red;
            font-weight: 400;
            font-family: 'Times New Roman', Times, serif;
            font-size: small;
        }
    </style>
</head>


<body>
    <?php
    $buildID = $_GET['buildID'];

    ?>
    <main>
        <script>
            window.onload = () => {
                document.getElementById("BuildingID").value = <?php echo $buildID ?>
            }

            function getFileExtension(fileName) {
                var parts = fileName.split('.');
                return parts[parts.length - 1];
            }

            function verifyForm(origin) {
                let fileSubmitCondition = true;

                FileInputForm = document.getElementById("formFile");
                if (FileInputForm.files.length > 0) {
                    let ImageFile = FileInputForm.files[0];

                    let ImageExtension = getFileExtension(ImageFile.name);
                    console.log(ImageFile.name);
                    console.log(ImageExtension);
                    if (ImageExtension == "jpeg" || ImageExtension == "jpg" || ImageExtension == "png") {
                        FileInputForm.classList.remove("is-invalid");
                        FileInputForm.classList.add("is-valid");
                    } else {
                        document.getElementById("invalid-message").innerHTML = "Wrong File Type";
                        FileInputForm.classList.remove("is-valid");
                        FileInputForm.classList.add("is-invalid");
                        fileSubmitCondition = false;
                    }
                    if (origin == 1 && fileSubmitCondition) {
                        
                        document.getElementById("addFloorPlanForm").submit();
                        setTimeout(() => {
                            window.location.reload();
                        },400);
                    }
                } else {
                    document.getElementById("invalid-message").innerHTML = "Please Enter A File";
                    FileInputForm.classList.add("is-invalid")
                }
            }

            function getFloorPlan(fileName) {
                console.log(fileName);
                let getFloorPlanReq = new XMLHttpRequest();
                getFloorPlanReq.open("GET", "config/FloorPlanDownload.php?floorPlanName=" + fileName + "", true);
                getFloorPlanReq.responseType = "blob";
                getFloorPlanReq.onreadystatechange = function() {
                    if (getFloorPlanReq.readyState === 4) {
                        if (getFloorPlanReq.status === 200) {
                            // Request was successful
                            // Create a blob URL and initiate the download
                            var blob = new Blob([getFloorPlanReq.response], {
                                type: 'image/*'
                            });
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = fileName;
                            document.body.appendChild(a);
                            a.click();
                            document.body.removeChild(a);
                            window.URL.revokeObjectURL(url);
                        } else {
                            // Request failed
                            console.error('Error:', getFloorPlanReq.status);
                        }
                    }
                };
                getFloorPlanReq.send();
            }
            function DeleteFloorPlan(FloorID){
                console.log(FloorID);
                let delFloorPlanReq = new XMLHttpRequest();
                delFloorPlanReq.open("GET","config/remFloorPlan.php?floorID=" + FloorID,true);
                delFloorPlanReq.onreadystatechange = () => {
                    if(delFloorPlanReq.status == 200 && delFloorPlanReq.readyState == 4){
                        setTimeout(()=> {
                            window.location.reload();
                        },300)
                    }
                }
                delFloorPlanReq.send();

            }
        </script>

<iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

        <!-- Modal -->
        <div class="modal fade" id="floorPlanAddModal" tabindex="-1" aria-labelledby="floorPlanAddModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="floorPlanAddModalLabel">Add Floor Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form target="dummyframe"class="needs-validation" id="addFloorPlanForm" action="config/addFloorPlan.php" method="post" enctype="multipart/form-data" novalidate>
                            <input type="text" name="BuildingID" id="BuildingID" style="display:none;">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Floor Plan</label>
                                <input onchange="verifyForm(0)" class="form-control" type="file" name="formFile" id="formFile">
                                <div class="invalid-feedback" id="invalid-message">
                                    Please Enter A File
                                </div>
                                <div class="valid-feedback">
                                    Looks Good
                                </div>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button onclick="verifyForm(1);" type="button" class="btn btn-success">Add</button>
                    </div>
                    </form>
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
                    <a href="building.php" class="border Arifnav Arifactive d-flex align-items-center" aria-current="page">
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
        <div class="container-fluid" style="overflow-x:hidden;background-color:green;">
            <div class="fw-bold mt-4 w-100 ms-3 mb-4" style="font-family: 'Open Sans', sans-serif;font-size:40px;color:black;">
                <?php
                $buildName = $_GET['buildName'];
                echo $buildName . " Floor Plan";
                ?>
            </div>
            <div class="row">
                <div class="col-sm-12" style="background-color:black;height:5px;"></div>
            </div>
            <div class="row mt-4">


                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        <?php
                        include 'config/connectDB.php';

                        $firstImage = true;
                        $getFloorPlanQuery = "SELECT * FROM `floorplan` WHERE `BuildingBlockID` = '$buildID'";
                        $getFloorPlanResult = mysqli_query($conn, $getFloorPlanQuery);

                        while ($row = mysqli_fetch_assoc($getFloorPlanResult)) {
                            $floorPlanID = $row['FloorPlanID'];
                            $floorDiagram = "";
                            if (isset($row['FloorDiagram'])) {
                                $floorDiagram = $row['FloorDiagram'];
                            } else {
                                $floorDiagram = "None";
                            }
                            if ($firstImage) {
                                $firstImage = false;
                                echo "
                                <div class=\"carousel-item active\">
                                    <img src=\"image\\floorplan\\$floorDiagram\" class=\"d-block w-100\" alt=\"...\">
                                    <div class=\"carousel-button-overlay\">
                                        <button class=\"del-button\"onclick=\"DeleteFloorPlan($floorPlanID)\">Delete</button>
                                        <button class=\"down-button\" onclick=\"getFloorPlan('$floorDiagram')\">Download</button>
                                    </div>
                                </div>";
                            } else {
                                echo "
                                <div class=\"carousel-item\">
                                    <img src=\"image\\floorplan\\$floorDiagram\" class=\"d-block w-100\" alt=\"...\">
                                    <div class=\"carousel-button-overlay\">
                                        <button class=\"del-button\"onclick=\"DeleteFloorPlan($floorPlanID)\">Delete</button>
                                        <button class=\"down-button\" onclick=\"getFloorPlan('$floorDiagram')\">Download</button>
                                    </div>
                                </div>";
                            }
                        }
                        ?>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

            </div>

            <div class="row">
                <div class="col pb-3 pt-2" style="width:100%;"><button data-bs-toggle="modal" data-bs-target="#floorPlanAddModal" class="float-end" style="width:6%;height:100%;" id="addButton">Add</button></div>
            </div>
        </div>
    </main>
</body>

</html>