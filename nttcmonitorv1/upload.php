<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to read Excel data and return as an array
function readExcelData($file)
{
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = [];

    $columns = ['D', 'E', 'F', 'G', 'S', 'AD', 'AE', 'AF', 'L']; // Added 'L' for training_institution_type
    foreach ($sheet->getRowIterator(7) as $row) { // Start from the 7th row
        $rowData = [];
        foreach ($columns as $column) {
            $cell = $sheet->getCell($column . $row->getRowIndex());
            $rowData[$column] = $cell->getFormattedValue(); // Use getFormattedValue() to get formatted cell value
        }
        $data[] = $rowData;
    }

    return $data;
}

// Function to save data to the database
function saveToDatabase($data)
{
    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "excel_data";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO excel_data (last_name, first_name, middle_name, extension, qualification, certificate_number, date_of_issuance, validity, training_institution_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $last_name, $first_name, $middle_name, $extension, $qualification, $certificate_number, $date_of_issuance, $validity, $training_institution_type);

    // Insert each row of data
    foreach ($data as $row) {
        $last_name = $row['D'];
        $first_name = $row['E'];
        $middle_name = $row['F'];
        $extension = $row['G'];
        $qualification = $row['S'];
        $certificate_number = $row['AD'];
        // Convert Date of Issuance to proper format (e.g., January 1, 2024)
        $date_of_issuance = date('F j, Y', strtotime($row['AE']));
        // Convert Validity to proper format (e.g., January 1, 2024)
        $validity = date('F j, Y', strtotime($row['AF']));
        $training_institution_type = $row['L'];

        $stmt->execute();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Function to process file upload and save data
function processFileUpload()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
        $file = $_FILES['file']['tmp_name'];
        $allData = readExcelData($file);

        // Save data to database
        saveToDatabase($allData);

        // Return the data to display
        return $allData;
    }
}

// Function to generate table rows with date color formatting
function generateTableRows($data)
{
    foreach ($data as $rowData) {
        echo '<tr>';
        foreach ($rowData as $key => $value) {
            // Check if the current column is "Validity"
            if ($key === 'AF') {
                // Check if the date has already passed
                if (strtotime($value) < strtotime('today')) {
                    // Date has passed, color it red and bold
                    echo '<td style="color: red; font-weight: bold;">' . htmlspecialchars($value) . '</td>';
                } else {
                    // Check if the date is within 3 months from now
                    $threeMonthsLater = date('Y-m-d', strtotime('+3 months'));
                    if (strtotime($value) <= strtotime($threeMonthsLater)) {
                        // Date is within 3 months, color it orange and bold
                        echo '<td style="color: orange; font-weight: bold;">' . htmlspecialchars($value) . '</td>';
                    } else {
                        // Date is normal, display it without formatting
                        echo '<td>' . htmlspecialchars($value) . '</td>';
                    }
                }
            } else {
                // For other columns, display data without formatting
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
        }
        echo '</tr>';
    }
}

// Call the function to process file upload and get the data
$allData = processFileUpload();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Data</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add hover animation */
        .search-button:hover {
            transform: scale(1.1);
        }

        /* Add transition for smooth animation */
        .search-button {
            transition: transform 0.3s ease;
        }

        /* Add margin to lock button */
        .lock-button {
            margin-left: 5px;
        }

        /* Disable appearance for the redirect button */
        .redirect-button {
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 10px;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            margin-left: 10px;
            cursor: pointer;
        }

        /* Style for enabled redirect button */
        .redirect-button.enabled {
            background: linear-gradient(90deg, blue, black);
            border: 2px solid white;
            color: white;
            pointer-events: auto; /* Enable pointer events */
        }

        /* Style for disabled redirect button */
        .redirect-button.disabled {
            background: linear-gradient(90deg, lightgrey, darkgrey);
            border: 2px solid grey;
            color: grey;
            pointer-events: none; /* Disable pointer events */
        }
    </style>
</head>
<body>
<div class="container">
    <div class="container" style="text-align: center;">
        <img src="icons/both.png" alt="Logo" style="width: 220px; height: 100px; margin-right: 10px; display: inline-block;">
        <h1 style="margin: -5px 0 0;">NTTC Monitoring System</h1>
    </div>

    <div style="display: flex; align-items: center;">
        <input type="text" id="searchInput" onkeyup="searchOnEnter(event)" placeholder="Search..." style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
        <button onclick="searchTable()" class="search-button" style="padding: 10px; background-color: #007bff; border: none; border-radius: 5px; margin-left: 5px; cursor: pointer;">
            <i class="fas fa-search" style="color: white;"></i>
        </button>
        <button id="lockButton" onclick="lockInData()" class="lock-button" style="background: linear-gradient(90deg, blue, black); border: 2px solid white; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; cursor: pointer; border-radius: 10px; transition: background-color 0.3s, box-shadow 0.3s, transform 0.3s; font-family: 'Arial', sans-serif; font-weight: bold;"
                onmouseover="this.style.background='linear-gradient(90deg, black, blue)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.3)'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.background='linear-gradient(90deg, blue, black)'; this.style.boxShadow='none'; this.style.transform='scale(1)';">
            Lock In
        </button>
        <button id="redirectButton" class="redirect-button disabled" onclick="redirect()">Open Monitoring</button>
    </div>

    <table id="dataTable">
        <thead>
        <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Extension</th>
            <th>Qualification</th>
            <th>Certificate Number</th>
            <th>Date of Issuance</th>
            <th>Validity</th>
            <th>Training Institution Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Generate table rows with date color formatting
        generateTableRows($allData);
        ?>
        </tbody>
    </table>
</div>

<script>
    function lockInData() {
        // Get the data from the table rows
        var tableRows = document.querySelectorAll('#dataTable tbody tr');
        var dataToUpload = [];
        tableRows.forEach(function(row) {
            var rowData = [];
            row.querySelectorAll('td').forEach(function(cell) {
                rowData.push(cell.textContent.trim());
            });
            dataToUpload.push(rowData);
        });

        // Send the data to a server-side script (like PHP) using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "upload_data.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Data uploaded successfully
                console.log(xhr.responseText);
                document.getElementById("redirectButton").classList.remove("disabled");
                document.getElementById("redirectButton").classList.add("enabled");
                document.getElementById("redirectButton").setAttribute("onclick", "redirect()");
            }
        };
        xhr.send(JSON.stringify(dataToUpload));
    }

    function redirect() {
        window.location.href = "index.php"; // Redirect to monitoring.php
    }

    // Other functions...
</script>
</body>
</html>
