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


$empID = false;
$Name = false;
$Position = false;
$Location = false;
$Grade = false;
$ContactNumber = false;
$Locker = false;

// EmpIDCheckBox;
// NameCheckBox;
// PosiCheckBox;
// LocaCheckBox;
// GradeCheckBox;
// ContactCheckBox;
// OccupiedCheckBox;

$textHeader = "";
$exportTo = $_GET['exportTo'];
$headerWidth = 0;

if (isset($_GET['EmpIDCheckBox'])) {
    $empID = true;
    $headerWidth += 30;
}
if (isset($_GET['NameCheckBox'])) {
    $Name = true;
    $headerWidth += 70;
}
if (isset($_GET['PosiCheckBox'])) {
    $Position = true;
    $headerWidth += 40;
}
if (isset($_GET['LocaCheckBox'])) {
    $Location = true;
    $headerWidth += 40;
}
if (isset($_GET['GradeCheckBox'])) {
    $Grade = true;
    $headerWidth += 20;
}
if (isset($_GET['ContactCheckBox'])) {
    $ContactNumber = true;
    $headerWidth += 40;
}
if (isset($_GET['LockerCheckBox'])) {
    $Locker = true;
    $headerWidth += 30;
}

$queryBuilder = "SELECT ";

$prevHave = false;
if ($empID) {
    $queryBuilder = $queryBuilder . "`EmployeeID`";
    if ($exportTo == 2) {
        $textHeader .= "EmployeeID \t | ";
    } else $textHeader .= "EmployeeID,";
    $prevHave = true;
}
if ($Name) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`Name`";
    if ($exportTo == 2) {
        $textHeader .= "Name\t\t |";
    } else $textHeader .= "Name,";
    $prevHave = true;
}
if ($Position) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`Position`";
    if ($exportTo == 2) {
        $textHeader .= "Position\t |";
    } else $textHeader .= "Position,";
    $prevHave = true;
}
if ($Location) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`Location`";
    if ($exportTo == 2) {
        $textHeader .= "Location\t |";
    } else $textHeader .= "Location,";
    $prevHave = true;
}
if ($Grade) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`Grade`";
    if ($exportTo == 2) {
        $textHeader .= "Grade\t |";
    } else $textHeader .= "Grade,";
    $prevHave = true;
}

if ($ContactNumber) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`PhoneNumber`";
    if ($exportTo == 2) {
        $textHeader .= "Phone Number\t |";
    } else $textHeader .= "Phone Number,";
    $prevHave = true;
}

if ($Locker) {
    if ($prevHave) {
        $queryBuilder = $queryBuilder . ",";
    }
    $queryBuilder = $queryBuilder . "`Locker1`";
    if ($exportTo == 2) {
        $textHeader .= "Locker\t |";
    } else $textHeader .= "Locker,";
    $prevHave = true;
}


$queryBuilder = $queryBuilder . " FROM 
(SELECT `EmployeeID`,`ImageLink`,`Name`,`Position`,`Grade`,`PhoneNumber`
,`Location`, COALESCE(NULLIF(`Locker`,''),'None')
As `Locker1`FROM `employee`) AS EmployeeList";

$otherQuery = "SELECT `EmployeeID`,`ImageLink`,`Name`,`Position`,`Grade`,`PhoneNumber`
,`Location`, COALESCE(NULLIF(`Locker`,''),'None')
As `Locker1`FROM `employee`";

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        // Calculate the X-coordinate to position the image in the center
        $imageX = ($this->GetPageWidth() - 60) / 2;
        $this->Image('../image/BerjayaLogo.png', $imageX, 12, 60); // Replace with the path to your image
        $this->Ln(40); // Move down to provide space between image and text

        // Set font size for "Employee Report" text
        $this->SetFont('Times', 'B', 30);
        $textY = $this->GetY(); // Get current Y-coordinate
        $this->Cell(0, 10, 'Employee Report', 0, 1, 'L'); // Add text
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


    $pdf = new PDF('L');
    $pdf->AddPage();


    $result = mysqli_query($conn, $queryBuilder);


    $pdf->SetFont('Times', 'B', 11);
    $pdf->SetFillColor(200, 220, 255);
    $pdf->SetTextColor(0, 0, 0);




    $tableX = ($pdf->GetPageWidth() - ($headerWidth)) / 2;
    $pdf->SetX($tableX);

    if ($empID) {
        $pdf->Cell(30, 13, 'Employee ID', 1, 0, 'C', true);
    }
    if ($Name) {
        $pdf->Cell(70, 13, 'Name', 1, 0, 'C', true);
    }
    if ($Position) {
        $pdf->Cell(40, 13, 'Position', 1, 0, 'C', true);
    }
    if ($Location) {
        $pdf->Cell(40, 13, 'Location', 1, 0, 'C', true);
    }
    if ($Grade) {
        $pdf->Cell(20, 13, 'Grade', 1, 0, 'C', true);
    }
    if ($ContactNumber) {
        $pdf->Cell(40, 13, 'Phone Number', 1, 0, 'C', true);
    }
    if ($Locker) {
        $pdf->Cell(30, 13, 'Locker Number', 1, 0, 'C', true);
    }

    $pdf->Ln();
    $fill = false;


    $pdf->SetFont('Times', '', 9);


    while ($row = mysqli_fetch_assoc($result)) {

        $pdf->SetFillColor($fill ? 255 : 240, $fill ? 255 : 240, $fill ? 255 : 240);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetX($tableX);


        if ($empID) {
            $pdf->Cell(30, 7, $row['EmployeeID'], 1, 0, 'L', true);
        }
        if ($Name) {
            $pdf->Cell(70, 7, $row['Name'], 1, 0, 'L', true);
        }
        if ($Position) {
            $pdf->Cell(40, 7, $row['Position'], 1, 0, 'L', true);
        }
        if ($Location) {
            $pdf->Cell(40, 7, $row['Location'], 1, 0, 'L', true);
        }
        if ($Grade) {
            $pdf->Cell(20, 7, $row['Grade'], 1, 0, 'L', true);
        }
        if ($ContactNumber) {
            $pdf->Cell(40, 7, $row['PhoneNumber'], 1, 0, 'L', true);
        }
        if ($Locker) {
            $pdf->Cell(30, 7, $row['Locker1'], 1, 0, 'L', true);
        }
        $pdf->Ln();
        $fill = !$fill;
    }

    // Output the PDF to the browser or save it to a file
    $pdf->Output('Report.pdf', 'D');
    ob_end_flush();
} else if ($exportTo == "1") {

    $result = mysqli_query($conn, $otherQuery);
    $pdf = new PDF('P');

    while ($row = mysqli_fetch_assoc($result)) {

        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 30); // Increase font size for headings
        $pdf->SetTextColor(0, 0, 0);
        try {
            $imagePath = "../image/employee/" . $row['ImageLink'];
            $imageWidth = 60;
            $imageHeight = 60;
            $imageX = ($pdf->GetPageWidth() - $imageWidth) / 2;
            $pdf->Image($imagePath, $imageX, $pdf->GetY(), $imageWidth, $imageHeight);
            $pdf->SetY($pdf->GetY() + $imageHeight + 10);
        } catch (Exception $e) {
            $pdf->Cell(0, 10, "No Image", 0, 1, 'C');
            $pdf->Ln(20);
        }
        $pdf->Cell(0, 10, 'Employee ID: ' . $row['EmployeeID'], 0, 1, 'C'); // Title
        $pdf->SetFont('Times', 'B', 13);
        $pdf->Ln(20);

        if ($Name) {
            $pdf->Cell(0, 7, "Name: " . $row['Name'], 0, 1, 'L');
            $pdf->Ln(5); // Add smaller line break
        }
        if ($Position) {
            $pdf->Cell(0, 7, "Position: " . $row['Position'], 0, 1, 'L');
            $pdf->Ln(5);
        }
        if ($Location) {
            $pdf->Cell(0, 7, "Location: " . $row['Location'], 0, 1, 'L');
            $pdf->Ln(5);
        }
        if ($Grade) {
            $pdf->Cell(0, 7, "Grade: " . $row['Grade'], 0, 1, 'L');
            $pdf->Ln(5);
        }
        if ($ContactNumber) {
            $pdf->Cell(0, 7, "Phone Number: " . $row['PhoneNumber'], 0, 1, 'L');
            $pdf->Ln(5);
        }
        if ($Locker) {
            $pdf->Cell(0, 7, "Locker: " . $row['Locker1'], 0, 1, 'L');
            $pdf->Ln(5);
        }
    }
    $pdf->Output('Employee_Report.pdf', 'D');
    ob_end_flush();
} else if ($exportTo == "4") { 
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
