<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #000000, #0000FF, #FFFFFF);
            margin: 0;
            padding: 0;
            
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #FFFFFF;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #000000;
        }

        .header-buttons {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .header-buttons a, .header-buttons button {
            background-color: #0000FF; /* Blue */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .header-buttons a:hover, .header-buttons button:hover {
            background-color: #0056b3;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .tab {
            margin-left: 10px;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #ddd;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .tabs button:first-child {
        margin-left: 0;
    }

        .tab.active {
            background-color: #007bff;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff; /* Ensure table background is white */
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }

        .expired {
            color: red;
            font-weight: bold;
        }

        .expiring-soon {
            color: orange;
            font-weight: bold;
        }

        .active-status {
            color: green;
            font-weight: bold;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: #000000;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        .lock-container button {
            background-color: #0000FF; /* Blue */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .lock-container button:hover {
            background-color: #0056b3;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            width: 50%;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .search-container button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin-left: 5px;
            transition: background-color 0.3s;
        }

        .search-container button:hover {
            background-color: #0056b3;
        }

        /* Form Styles */
        form {
            margin: 20px 0;
        }

        form input[type="text"], form input[type="password"], form input[type="email"], form select, form textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button[type="submit"]:hover {
            background-color: #0056b3;
        }
        .utils {
            text-align: center;
        }

        .utils button {
            background-color: #0000FF; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 10px;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 4px #999;
            transition: all 0.3s ease;
            align-items: center;
            justify-content: center;
        }

        .utils button:hover {
            background: linear-gradient(to right, #000000, #0000FF, #FFFFFF);
        }

        .utils button:active {
            background-color: #45a049;
            box-shadow: 0 2px #666;
            transform: translateY(4px);
        }

        .utils button img {
            margin-right: 8px;
        }

        /* Ensure buttons are in line */
        .utils button:first-child {
            margin-right: 10px;
        }
    </style>

</head>
<body>
<div class="container">
    <div style="text-align: center;">
        <img src="icons/both.png" alt="Logo" style="width: 220px; height: 100px; margin-right: 10px; display: inline-block;">
        <h2> NTTC Due for Renewal</h2>
        <h3 id="currentDate">As of: </h3>
    </div>

    <div class="header-buttons">
        <a href="index.php">Home</a>
        <a href="#" id="uploadButton">Upload XLS</a>
        <a href="#" id="infoButton">Info</a>
        <a href="statistics.php" id="statisticsButton">Statistics</a>
        <a href="delete.php" id="deleteButton">Delete</a>
        <a href="dfr.php" id="dfrButton">Due for Renewal</a>
        
    </div>

    <div class="tabs">
        <div class="tab active" data-tab="cebu">CEBU</div>
        <div class="tab" data-tab="bohol">BOHOL</div>
        <div class="tab" data-tab="siquijor">SIQUIJOR</div>
        <div class="tab" data-tab="negros">NEGROS</div>
    </div>
    <div class="utils">
    <button onclick="printContent()">
        <img src="https://img.icons8.com/ios-filled/16/ffffff/print.png" alt="Print Icon">
        Print
    </button>
    <button onclick="screenshotContent()">
        <img src="https://img.icons8.com/ios-filled/16/ffffff/camera.png" alt="Screenshot Icon">
        Screenshot
    </button>
</div>
    <div class="tab-content active" id="cebu">
     <table>
            <?php
            // PHP code starts here
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

            // Get current date
            $currentDate = new DateTime();

            // Query to fetch all data from the excel_data table
            $sql = "SELECT * FROM excel_data";
            $result = $conn->query($sql);

            $regions = ['CEBU' => '22', 'BOHOL' => '12', 'SIQUIJOR' => '61', 'NEGROS' => '46'];
            $data = ['CEBU' => '', 'BOHOL' => '', 'SIQUIJOR' => '', 'NEGROS' => ''];

            // Output data of each row
            while($row = $result->fetch_assoc()) {
                $validityDate = new DateTime($row['validity']);
                $interval = $currentDate->diff($validityDate);
                $class = '';

                // Check if the validity is expiring soon (within 3 months)
                if ($interval->m <= 3 && $interval->invert == 0 && $currentDate->format('Y') == $validityDate->format('Y')) {
                    $certificate_number = $row['certificate_number'];
                    $digits_7_8 = substr($certificate_number, 6, 2);
                    $region = array_search($digits_7_8, $regions);

                    if ($region !== false) {
                        $class = 'expiring-soon';

                        $data[$region] .= "<tr>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['middle_name']) . "</td>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['extension']) . "</td>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['qualification']) . "</td>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['certificate_number']) . "</td>";
                        $data[$region] .= "<td>" . htmlspecialchars($row['date_of_issuance']) . "</td>";
                        $data[$region] .= "<td class='" . $class . "'>" . htmlspecialchars($row['validity']) . "</td>";
                        $data[$region] .= "</tr>";
                    }
                }
            }
            

            foreach ($data as $region => $rows) {
                echo "<div class='tab-content' id='$region'>";
                echo "<table><thead><tr><th>Last Name</th><th>First Name</th><th>Middle Name</th><th>Extension</th><th>Qualification</th><th>Certificate Number</th><th>Date of Issuance</th><th>Validity</th></tr></thead><tbody>";
                echo $rows;
                echo "</tbody></table>";
                echo "</div>";
            }
            

            // Close the database connection
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="bohol">
        <table>
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
            </tr>
            </thead>
            <tbody>
            <!-- BOHOL Data will be populated here by PHP -->
            <?php echo $data['BOHOL']; ?>
            </tbody>
        </table>
    </div>

    <div class="tab-content" id="siquijor">
        <table>
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
            </tr>
            </thead>
            <tbody>
            <!-- SIQUIJOR Data will be populated here by PHP -->
            <?php echo $data['SIQUIJOR']; ?>
            </tbody>
        </table>
    </div>

    <div class=" tab-content " id="negros">
    <table>
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
    </tr>
    </thead>
    <tbody>
    <!-- NEGROS Data will be populated here by PHP -->
    <?php echo $data['NEGROS']; ?>
    </tbody>
    </table>
    </div>

    <div class="pagination">
    <!-- Pagination links would go here -->
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tab");
            const tabContents = document.querySelectorAll(".tab-content");

            tabs.forEach(tab => {
                tab.addEventListener("click", function() {
                    tabs.forEach(tab => tab.classList.remove("active"));
                    tabContents.forEach(content => content.classList.remove("active"));

                    tab.classList.add("active");
                    document.getElementById(tab.getAttribute("data-tab")).classList.add("active");
                });
            });

            // Set the current date
            const currentDate = new Date();
            document.getElementById("currentDate").innerText = `As of: ${currentDate.toLocaleDateString()}`;
        });

        function printContent() {
            const printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Print Preview</title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(document.querySelector('.tab-content.active').innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function screenshotContent() {
            html2canvas(document.querySelector('.tab-content.active')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'screenshot.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    </script>
    <?php include 'footer.php'; ?>
    </body>
    </html>
