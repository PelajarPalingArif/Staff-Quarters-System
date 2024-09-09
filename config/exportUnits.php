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


$Name = false;
$Units = false;
$Rooms = false;
$buildID = "";
$type = 1;
if (isset($_POST['type'])) {
    $type = $_POST['type'];
}

if (isset($_POST['buildID'])) {
    $buildID = $_POST['buildID'];
}

/*

NameCheckBox
UnitsCheckBox
RoomCheckBox

*/

$textHeader = "";
$exportTo = $_GET['exportTo'];
$headerWidth = 0;

$appTo = "SELECT ";
$prevHave = false;
if (isset($_GET['NameCheckBox'])) {
    $Name = true;
    $headerWidth += 60;
}
if (isset($_GET['UnitsCheckBox'])) {

    $Units = true;
    $headerWidth += 50;
}
if (isset($_GET['RoomCheckBox'])) {
    $Rooms = true;
    $headerWidth += 50;
}





if ($Name) {
    $appTo .= "`BuildingName`";
    if ($exportTo == 2) {
        $textHeader .= "BuildingName\t\t |";
    } else $textHeader .= "BuildingName,";
    $prevHave = true;
}
if ($Units) {
    if ($prevHave) {
        $appTo .= ",";
    }
    $appTo .= "`UnitCode`";
    if ($exportTo == 2) {
        $textHeader .= "Units\t\t |";
    } else $textHeader .= "Units,";
    $prevHave = true;
}
if ($Rooms) {
    if ($prevHave) {
        $appTo .= ",";
    }

    $appTo .= "`Pax`";
    if ($exportTo == 2) {
        $textHeader .= "Rooms\t\t |";
    } else $textHeader .= "Rooms,";
}
$queryBuilder = "";
if ($type == 1) {
    $queryBuilder =  "SELECT  u.`UnitID`,u.`UnitCode`,b.`BuildingName`,b.`BuildingBlockID`,COUNT(r.`UnitID`) as Pax FROM `unit` u 
                        LEFT JOIN `BuildingBlock` b ON b.`BuildingBlockID` = u.`BuildingBlockID`
                        LEFT JOIN `Rooms` r ON r.`UnitID` = u.`UnitID`
                        GROUP BY u.`UnitID` ORDER BY b.`BuildingBlockID` ASC,u.`UnitCode` ASC
                        ";
} else {
    $queryBuilder = "SELECT  u.`UnitID`,u.`UnitCode`,b.`BuildingName`,b.`BuildingBlockID`,COUNT(r.`UnitID`) as Pax FROM `unit` u 
    LEFT JOIN `BuildingBlock` b ON b.`BuildingBlockID` = u.`BuildingBlockID`
    LEFT JOIN `Rooms` r ON r.`UnitID` = u.`UnitID`
    WHERE b.`BuildingBlockID` = $buildID
    GROUP BY u.`UnitID` ORDER BY b.`BuildingBlockID` ASC,u.`UnitCode` ASC";
}
// echo $queryBuilder;
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        // Calculate the X-coordinate to position the image in the center
        $imageX = ($this->GetPageWidth() - 60) / 2;
        $this->Image('../image/BerjayaLogo.png', $imageX, 12, 60); // Replace with the path to your image
        $this->Ln(40); // Move down to provide space between image and text

        $this->SetFont('Times', 'B', 30);
        $textY = $this->GetY(); // Get current Y-coordinate
        $this->Cell(0, 10, 'Units Report', 0, 1, 'L'); // Add text
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
// CSV export
if ($exportTo == "3") {
    $namefile = "BuildingReport.csv";
    $delimiter = ",";
    $queryBuilder = "$appTo FROM (" . $queryBuilder . ") AS TempTable";

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

    $pdf = new PDF('P');
    $pdf->AddPage();

    $queryBuilder = "$appTo FROM (" . $queryBuilder . ") AS TempTable";
    $result = mysqli_query($conn, $queryBuilder);

    $pdf->SetFont('Times', 'B', 11);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->SetTextColor(0, 0, 0);

    // Calculate the starting X position to center the table
    $remainingSpace = $pdf->GetPageWidth() - $headerWidth;
    $tableX = $remainingSpace / 2;
    $pdf->SetX($tableX);

    if ($Name) {
        $pdf->Cell(60, 13, 'Name', 1, 0, 'C', true);
    }
    if ($Units) {
        $pdf->Cell(50, 13, 'Units', 1, 0, 'C', true);
    }
    if ($Rooms) {
        $pdf->Cell(50, 13, 'Rooms', 1, 0, 'C', true);
    }

    $pdf->Ln();
    $fill = false;

    $pdf->SetFont('Times', '', 9);

    while ($row = mysqli_fetch_assoc($result)) {

        $pdf->SetFillColor($fill ? 255 : 240, $fill ? 255 : 240, $fill ? 255 : 240);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX($tableX);

        if ($Name) {
            $pdf->Cell(60, 13, $row['BuildingName'], 1, 0, 'C', true);
        }
        if ($Units) {
            $pdf->Cell(50, 13, $row['UnitCode'], 1, 0, 'C', true);
        }
        if ($Rooms) {
            $pdf->Cell(50, 13, $row['Pax'], 1, 0, 'C', true);
        }
        $pdf->Ln();
        $fill = !$fill;
    }
    $allRoomsQuery =
        "SELECT 
    B.BuildingName, 
    U.UnitID, 
    U.UnitCode, 
    R.RoomID, 
    COALESCE(E.EmployeeID, 'Null') AS EmployeeID,
    COALESCE(E.Name, 'Null') AS EmpName
    FROM Unit U 
    JOIN BuildingBlock B ON U.BuildingBlockID = B.BuildingBlockID 
    JOIN Rooms R ON U.UnitID = R.UnitID 
    LEFT JOIN Employee E ON R.EmployeeID = E.EmployeeID;";
    $resultAllRooms = mysqli_query($conn, $allRoomsQuery);

    $pdf->AddPage();
    $pdf->SetFont('Times', 'B', 15);
    $pdf->Cell(0, 10, 'All Rooms', 0, 1, 'C');
    $pdf->Ln(10);

    $tableWidthAllRooms = array_sum([29, 23, 19, 30, 60]);
    $remainingSpaceAllRooms = $pdf->GetPageWidth() - $tableWidthAllRooms;
    $tableXAllRooms = $remainingSpaceAllRooms / 2;
    $pdf->SetX($tableXAllRooms);

    $pdf->SetFont('Times', 'B', 9);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->Cell(29, 10, 'Building Name', 1, 0, 'C', true);
    $pdf->Cell(23, 10, 'Unit Code', 1, 0, 'C', true);
    $pdf->Cell(19, 10, 'Room ID', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Employee ID', 1, 0, 'C', true);
    $pdf->Cell(60, 10, 'Employee Name', 1, 1, 'C', true);

    // Set font for data
    $pdf->SetFont('Times', '', 7);
    $fill = false;
    while ($rowAllRooms = mysqli_fetch_assoc($resultAllRooms)) {
        $pdf->SetX($tableXAllRooms);
        // Add data to PDF
        $pdf->SetFillColor($fill ? 255 : 240, $fill ? 255 : 240, $fill ? 255 : 240);
        $pdf->Cell(29, 8, $rowAllRooms['BuildingName'], 1, 0, 'L', true);
        $pdf->Cell(23, 8, $rowAllRooms['UnitCode'], 1, 0, 'L', true);
        $pdf->Cell(19, 8, $rowAllRooms['RoomID'], 1, 0, 'L', true);
        $pdf->Cell(30, 8, $rowAllRooms['EmployeeID'], 1, 0, 'L', true);
        $pdf->Cell(60, 8, $rowAllRooms['EmpName'], 1, 1, 'L', true);
        
        $fill = !$fill;
    }


    $pdf->Output('Report.pdf', 'D');
    ob_end_flush();
} else if ($exportTo == "4") {
    require '../AnyFolder/PhpOffice/autoload.php';
    $headerArr = explode(",", $textHeader);
    $queryBuilder = "$appTo FROM (" . $queryBuilder . ") AS TempTable";

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
