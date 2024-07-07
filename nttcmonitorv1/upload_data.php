<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to read Excel data and return as an array
function readExcelData($file)
{
    // Database connection parameters (update with your database details)
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "excel_data";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement for checking duplicate certificate_number
    $checkStmt = $conn->prepare("SELECT certificate_number FROM excel_data WHERE certificate_number = ?");

    // Prepare and bind SQL statement for inserting data
    $stmt = $conn->prepare("INSERT INTO excel_data (last_name, first_name, middle_name, extension, qualification, certificate_number, date_of_issuance, validity, sector, training_institution_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $last_name, $first_name, $middle_name, $extension, $qualification, $certificate_number, $date_of_issuance, $validity, $sector, $training_institution_type);

    // Array to store counts of training_institution_type
    $trainingTypeCounts = [];

    // Load Excel spreadsheet
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();

    // Get highest row number
    $highestRow = $sheet->getHighestRow();

    // Iterate through each row of data (starting from row 7)
    for ($row = 7; $row <= $highestRow; $row++) {
        // Assuming column indices based on your Excel layout
        $last_name = $sheet->getCellByColumnAndRow(3, $row)->getValue(); // Column D
        $first_name = $sheet->getCellByColumnAndRow(4, $row)->getValue(); // Column E
        $middle_name = $sheet->getCellByColumnAndRow(5, $row)->getValue(); // Column F
        $extension = $sheet->getCellByColumnAndRow(6, $row)->getValue(); // Column G
        $qualification = $sheet->getCellByColumnAndRow(18, $row)->getValue(); // Column S
        $certificate_number = $sheet->getCellByColumnAndRow(29, $row)->getValue(); // Column AD
        
        // Convert Date of Issuance to proper format (e.g., January 1, 2024)
        $date_of_issuance = date('F j, Y', strtotime($sheet->getCellByColumnAndRow(30, $row)->getValue())); // Column AE
        // Convert Validity to proper format (e.g., January 1, 2024)
        $validity = date('F j, Y', strtotime($sheet->getCellByColumnAndRow(31, $row)->getValue())); // Column AF
        $sector = $sheet->getCellByColumnAndRow(17, $row)->getValue(); // Column R
        $training_institution_type = $sheet->getCellByColumnAndRow(25, $row)->getValue(); // Assuming 'Z' is the column for training_institution_type

        // Count occurrences of training_institution_type
        if (!isset($trainingTypeCounts[$training_institution_type])) {
            $trainingTypeCounts[$training_institution_type] = 0;
        }
        $trainingTypeCounts[$training_institution_type]++;

        // Check for duplicate certificate_number
        $checkStmt->bind_param("s", $certificate_number);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows == 0) {
            // No duplicate found, execute insert statement
            $stmt->execute();
        } else {
            // Duplicate found, skip insertion
            continue;
        }
    }

    // Close statements and connection
    $checkStmt->close();
    $stmt->close();
    $conn->close();

    // Return training institution type counts
    return $trainingTypeCounts;
}

// Function to process file upload and save data
function processFileUpload()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        $file = $_FILES['file']['tmp_name'];
        $allData = readExcelData($file);
        return $allData;
    }
    return false; // Return false if file upload fails or no file is uploaded
}

// Call the function to process file upload and get the data
$allData = processFileUpload();

// Return a success message or handle as needed
if ($allData) {
    echo "Data inserted successfully";
} else {
    echo "Upload failed. Please try again.";
}
?>
