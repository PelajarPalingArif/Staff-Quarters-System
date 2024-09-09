<?php

$floorPlanName = "../image/floorplan/" . $_GET['floorPlanName'];

if (file_exists($floorPlanName)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($floorPlanName) . '"');
    header('Content-Length: ' . filesize($floorPlanName));

    // Output the image content
    readfile($floorPlanName);
    exit; // Make sure to exit after sending the file
} else {
    echo "Not Ran" . $floorPlanName;
}
?>
