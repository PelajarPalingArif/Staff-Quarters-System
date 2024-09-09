<?php


ob_start();
require('../fpdf186/fpdf.php');
$servername = "localhost";
$username = "root";
$password = "";
$db = "staffquarterssystem";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

$name = false;
$units = false;
$rooms = false;
$available = false;
$occupied = false;
$prevHave = false;

$textHeader = "";
$exportTo = $_GET['exportTo'];

if (isset($_GET['NameCheckBox'])) {
    $name = true;
}
if (isset($_GET['UnitsCheckBox'])) {
    $units = true;
}
if (isset($_GET['RoomsCheckBox'])) {
    $rooms = true;
}
if (isset($_GET['AvailableCheckBox'])) {
    $available = true;
}
if (isset($_GET['OccupiedCheckBox'])) {
    $occupied = true;
}

$queryBuilder = "SELECT ";

if ($name) {
    $queryBuilder = $queryBuilder . "`BuildingName`";
    if ($exportTo == 1) {
        $textHeader .= "BuildingName \t | ";
    } else $textHeader .= "BuildingName,";
    $prevHave = true;
}
if ($units) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`TotalUnits`";
    if ($exportTo == 1) {
        $textHeader .= "TotalUnits\t |";
    } else $textHeader .= "TotalUnits,";
    $prevHave = true;
}
if ($rooms) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`RoomCount`";
    if ($exportTo == 1) {
        $textHeader .= "RoomCount\t |";
    } else $textHeader .= "RoomCount,";
    $prevHave = true;
}
if ($available) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`VacRoom`";
    if ($exportTo == 1) {
        $textHeader .= "Vacant Room\t |";
    } else $textHeader .= "Vacant Room,";
    $prevHave = true;
}
if ($occupied) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`OccRoom`";
    if ($exportTo == 1) {
        $textHeader .= "Occupied Rooms\t";
    } else $textHeader .= "Occupied Rooms";
}
// echo "$queryBuilder";
$queryBuilder = $queryBuilder . " FROM (SELECT b.BuildingBlockID, b.BuildingName,COUNT(u.UnitID) AS TotalUnits, COUNT(r.RoomID) AS RoomCount, COUNT(CASE WHEN r.Status = 0 THEN 1 ELSE NULL END) AS OccRoom, COUNT(CASE WHEN r.Status = 1 THEN 0 ELSE NULL END) AS VacRoom
FROM BuildingBlock b
LEFT JOIN Unit u ON b.BuildingBlockID = u.BuildingBlockID
LEFT JOIN Rooms r ON u.UnitID = r.UnitID
GROUP BY b.BuildingBlockID) AS BuildingQuery";

$BuildingImage = "SELECT `buildingblock`.*, `floorplan`.`FloorPlanID`, `floorplan`.`FloorDiagram`
FROM `buildingblock`
LEFT JOIN `floorplan` ON `buildingblock`.`BuildingBlockID` = `floorplan`.`BuildingBlockID`
";

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        // Calculate the X-coordinate to position the image in the center
        $imageX = ($this->GetPageWidth() - 60) / 2;
        $this->Image('../image/BerjayaLogo.png', $imageX, 12, 60); // Replace with the path to your image
        $this->Ln(40); // Move down to provide space between image and text

        // Set font size for "Building Report" text
        $this->SetFont('Times', 'B', 30);
        $textY = $this->GetY(); // Get current Y-coordinate
        $this->Cell(0, 10, 'Building Report', 0, 1, 'L'); // Add text
        $this->Ln(3);
        // Set Y-coordinate for the line
        $lineY = $this->GetY();
        // Add a line below the text
        $this->SetLineWidth(2); // Set line width
        $this->SetDrawColor(0, 0, 0); // Set line color (black)
        $this->Line(12, $lineY, $this->GetPageWidth() - 10, $lineY); // Draw a line

        // Move down to provide space between text and table
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}
// TEXT
if ($exportTo == "1") {
    //config
    $namefile = "BuildingReport.txt";
    $textHeader .= PHP_EOL;
    $divider = "";
    for ($i = 0; $i < strlen($textHeader); $i += 1) {
        $divider .= "=";
    }
    $divider .= PHP_EOL;
    $result = mysqli_query($conn, $queryBuilder);

    // Check if the query was successful
    if ($result) {
        $formattedContent = "";
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($row as $value) {
                // Check the length of each value in the row
                if (strlen($value) < 8) {
                    $formattedContent .= $value . "\t\t | ";
                } else {
                    $formattedContent .= $value . "\t | ";
                }
            }

            // Remove the last "| " and add a new line
            $formattedContent = rtrim($formattedContent, "| ") . PHP_EOL;
        }

        $fileContent = $textHeader . $divider . $formattedContent;

        //save file
        $file = fopen($namefile, "w") or die("Unable to open file!");
        fwrite($file, $fileContent);
        fclose($file);
        //header download
        header("Content-Disposition: attachment; filename=\"" . $namefile . "\"");
        header("Content-Type: application/force-download");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header("Content-Type: text/plain");

        echo $fileContent;
    } else {
        // echo "Query failed: " . mysqli_error($conn);
    }
}

// CSV export
else if ($exportTo == "2") {
    $namefile = "BuildingReport.csv";
    $delimiter = ",";

    $textHeader .= PHP_EOL;
    $result = mysqli_query($conn, $queryBuilder);

    // Check if the query was successful
    if ($result) {
        $formattedContent = $textHeader;

        while ($row = mysqli_fetch_assoc($result)) {
            $formattedContent .= implode($delimiter, $row) . PHP_EOL;
        }

        // Save file
        $file = fopen($namefile, "w") or die("Unable to open file!");
        fwrite($file, $formattedContent);
        fclose($file);

        // Header download
        header("Content-Disposition: attachment; filename=\"" . $namefile . "\"");
        header("Content-Type: application/force-download");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header("Content-Type: text/plain");

        echo $formattedContent;
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }
}
//PDF
else if ($exportTo == "0") {

    // Create PDF instance
    $pdf = new PDF();
    $pdf->AddPage();

    // Execute the query
    $result = mysqli_query($conn, $queryBuilder);
    $imageResult = mysqli_query($conn, $BuildingImage);

    // Calculate the total width of the table
    $totalWidth = 0;
    if ($name) {
        $totalWidth += 40;
    }
    if ($units) {
        $totalWidth += 30;
    }
    if ($rooms) {
        $totalWidth += 30;
    }
    if ($available) {
        $totalWidth += 40;
    }
    if ($occupied) {
        $totalWidth += 50;
    }

    // Calculate the starting position to center the table
    $startX = ($pdf->GetPageWidth() - $totalWidth) / 2;

    // Set font and move to the starting position
    $pdf->SetFont('Times', 'B', 12);
    $pdf->SetX($startX);

    // Output table headers
    if ($name) {
        $pdf->Cell(40, 10, 'Building Name', 1);
    }
    if ($units) {
        $pdf->Cell(30, 10, 'Total Units', 1);
    }
    if ($rooms) {
        $pdf->Cell(30, 10, 'Room Count', 1);
    }
    if ($available) {
        $pdf->Cell(40, 10, 'Vacant Rooms', 1);
    }
    if ($occupied) {
        $pdf->Cell(50, 10, 'Occupied Rooms', 1);
    }
    $pdf->Ln(); // Move to the next row

    // Set font for data rows
    $pdf->SetFont('Times', '', 12);

    // Output data rows
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->SetX($startX); // Set X position for each row
        if($name){
            $pdf->Cell(40, 10, $row['BuildingName'], 1);
        }
        if ($units) {
            $pdf->Cell(30, 10, $row['TotalUnits'], 1);
        }
        if ($rooms) {
            $pdf->Cell(30, 10, $row['RoomCount'], 1);
        }
        if ($available) {
            $pdf->Cell(40, 10, $row['VacRoom'], 1);
        }
        if ($occupied) {
            $pdf->Cell(50, 10, $row['OccRoom'], 1);
        }
        $pdf->Ln(); // Move to the next row
    }

    $pdf->AddPage();
    $firstIte = true;
    $ImageResult = mysqli_query($conn, $BuildingImage);
    $prevBuild = "";
    while ($rowImage = mysqli_fetch_assoc($ImageResult)) {
        // echo $rowImage['BuildingBlockID'];
        if ($firstIte) {
            $firstIte = false;
            $prevBuild = $rowImage['BuildingBlockID'];
            $buildName = $rowImage['BuildingName'];
            $pdf->SetFont('Arial', 'B', 20); // Set font to normal size
            $pdf->Cell(40, 10, $buildName . " FloorPlan", 0, 0, 'L');
        } else {
            if ($rowImage['BuildingBlockID'] != $prevBuild) {
                $pdf->AddPage();
                $prevBuild = $rowImage['BuildingBlockID'];
                $buildName = $rowImage['BuildingName'];
                $pdf->SetFont('Arial', 'B', 20); // Set font to normal size
                $pdf->Cell(40, 10, $buildName . " FloorPlan", 0, 0, 'L');
            }
        }
        if (isset($rowImage['FloorDiagram'])) {
            $centerX = ($pdf->GetPageWidth() - 40) / 2;
            $centerY = $pdf->GetY() + 40;
            $pdf->SetXY($centerX, $centerY);


            $imagePath = "..\\image\\floorplan\\" . $rowImage['FloorDiagram'];
            $pdf->Image($imagePath, null, null, 40);
            $pdf->Ln();
        } else {
        }
    }

    
    $pdf->Output('Report.pdf', 'D');
    ob_end_flush();
} else if ($exportTo == "3") { 
    require '../AnyFolder/PhpOffice/autoload.php';
    $headerArr = explode(",", $textHeader);


    $headerStart = 'A';
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    for ($i = 1; $i <= count($headerArr); $i++) {
        $sheet->setCellValue(chr(ord($headerStart++)) . "1", $headerArr[$i - 1]);
    }
    $result = mysqli_query($conn, $queryBuilder);
    $ctStart = 2;
    while ($row = mysqli_fetch_assoc($result)) {
        $headerStart = 'A';
        
        foreach ($row as $value) {
            $sheet->setCellValue(chr(ord($headerStart++)) . $ctStart, $value);
        }
        $ctStart++;
    }
    foreach (range('A', $spreadsheet->getActiveSheet()->getHighestDataColumn()) as $column) {
        $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
    }
    $writer = new Xlsx($spreadsheet);


    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Building_Report.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
}

mysqli_close($conn);
