<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel File</title>
</head>
<body>
    <h2>Upload Excel File</h2>
    <form action="upload_excel.php" method="post" enctype="multipart/form-data">
        Select Excel file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <?php
    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if file was uploaded without errors
        if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
            $fileName = $_FILES["fileToUpload"]["tmp_name"];

            // Load Excel library (PHPExcel or PhpSpreadsheet)
            require 'vendor/autoload.php'; // Adjust path as needed

            // Create a new Reader of the type defined in $inputFileType
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);
            
            // Select active sheet
            $sheet = $spreadsheet->getActiveSheet();

            // Database connection details
            $servername = "localhost";
            $username = "your_username";
            $password = "your_password";
            $dbname = "excel_data_2";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Define columns and starting row
            $startRow = 7;
            $lastColumn = 'G';

            // Loop through rows starting from row 7
            for ($row = $startRow; $row <= $sheet->getHighestRow(); $row++) {
                // Prepare SQL statement
                $sql = "INSERT INTO your_table_name (column1, column2, column3, ...) VALUES (?, ?, ?, ...)";
                $stmt = $conn->prepare($sql);

                // Bind parameters and execute statement
                $stmt->bind_param("sss", $cellA, $cellB, $cellC, ...);

                // Get cell values
                $cellA = $sheet->getCell('A' . $row)->getValue();
                $cellB = $sheet->getCell('B' . $row)->getValue();
                $cellC = $sheet->getCell('C' . $row)->getValue();
                // Repeat for other columns as needed

                // Execute the statement
                $stmt->execute();
            }

            // Close connection
            $conn->close();
            echo "Data uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }
    ?>

</body>
</html>
