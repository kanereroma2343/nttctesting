<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "excel_data_2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $fileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file);
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);
    $spreadsheet = $reader->load($file);

    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // Prepare the SQL statement with the exact number of columns
    $stmt = $conn->prepare("INSERT INTO excel_data_2 (Region, Province, LastName, FirstName, MiddleInitial, Extension, Birthday, Sex, CompleteAddress, TrainingInstitutionCompany, TypeOfTrainingInstitution, EmailAddress, ContactNo, EducationalAttainment, TrainingHours, PracticingTheQualification, Sector, Qualification, CertificateNumber1, DateIssued1, ExpirationDate1, CertificateNumber2, DateIssued2, ExpirationDate2, Assessor1, Assessor2, Assessor3, SerialNo, CertificateNumber3, DateIssued3, ExpirationDate3, CLNNTCNo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($data as $row) {
        // Check if the row has at least 33 columns (adjust this condition as needed)
        if (count($row) >= 33) {
            // Slice the row data to match 33 columns (adjust if your data structure differs)
            $rowData = array_slice($row, 0, 33);
            // Bind parameters dynamically based on the number of columns
            $stmt->bind_param(
                "isssssssssssssssssssssssssssssss",
                $rowData[0],  // No
                $rowData[1],  // Region
                $rowData[2],  // Province
                $rowData[3],  // Last Name
                $rowData[4],  // First Name
                $rowData[5],  // Middle Initial
                $rowData[6],  // Extension
                $rowData[7],  // Birthday
                $rowData[8],  // Sex
                $rowData[9],  // Complete Address
                $rowData[10], // Training Institution/Company
                $rowData[11], // Type of Training Institution
                $rowData[12], // E-mail Address
                $rowData[13], // Contact No.
                $rowData[14], // Educational Attainment
                $rowData[15], // Training Hours
                $rowData[16], // Practicing the Qualification
                $rowData[17], // SECTOR
                $rowData[18], // Qualification
                $rowData[19], // Certificate Number 1
                $rowData[20], // Date Issued 1
                $rowData[21], // Expiration Date 1
                $rowData[22], // Certificate Number 2
                $rowData[23], // Date Issued 2
                $rowData[24], // Expiration Date 2
                $rowData[25], // Assessor 1
                $rowData[26], // Assessor 2
                $rowData[27], // Assessor 3
                $rowData[28], // Serial No.
                $rowData[29], // Certificate Number 3
                $rowData[30], // Date Issued 3
                $rowData[31], // Expiration Date 3
                $rowData[32]  // CLN-NTC No.
            );
            $stmt->execute();
        } else {
            // Log or handle rows with fewer than 33 columns if necessary
            echo "Skipped row: " . implode(", ", $row) . "<br>";
        }
    }
    echo "Data uploaded successfully.";
} else {
    echo "No file uploaded or invalid request.";
}

$conn->close();
?>
