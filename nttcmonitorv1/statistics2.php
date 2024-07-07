<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTTC Statistics</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <style>
        /* General styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #FFFFFF, #0000FF, #000000);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            opacity: 0; /* Start with opacity 0 for fade-in effect */
            transition: opacity 0.8s ease; /* Smooth transition effect */
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-container {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 220px;
            height: auto;
        }

        h2, h3 {
            margin-bottom: 20px;
            text-align: center;
            color: #333333;
        }

        .left-column, .right-column {
            width: 48%;
        }

        .content {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            width: 100%;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 10px;
            text-align: center;
            border: 1px solid #dddddd;
        }

        th {
            background-color: #3498db; /* Light blue */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Lighter background for even rows */
        }

        tr:hover {
            background-color: #2980b9; /* Darker blue on hover */
            color: white;
        }

        /* Chart canvas */
        canvas {
            max-width: 100%;
            max-height: 300px;
            margin: auto;
            display: block;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .content {
                flex-direction: column;
            }

            .left-column, .right-column {
                width: 100%;
            }
        }

        .header-buttons {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .header-buttons a {
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
            transition: background-color 0.3s ease;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 70%; /* Adjust width as needed */
    max-width: 400px; /* Set a maximum width */
    animation-name: modalopen;
    animation-duration: 0.3s;
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Soft shadow */
}

@keyframes modalopen {
    0% {transform: scale(0.7); opacity: 0;}
    100% {transform: scale(1); opacity: 1;}
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="icons/both.png" alt="NTTC Logo">
        </div>
        <div class="header-buttons">
            <a href="index.php">Home</a>
            <a href="#" id="infoButton">Info</a>   
            <a href="statistics.php">Statistics</a>      
        </div>
        <div class="content">
            <div class="left-column">
                <h2>NTTC Warm Bodies</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Province</th>
                            <th>Warm Bodies Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // PHP logic for fetching count of unique names per province from database
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

                        // Query to fetch count of unique names per province
                        $sql_cebu = "SELECT COUNT(DISTINCT CONCAT(first_name, ' ', middle_name, ' ', last_name)) AS num_unique_cebu 
                                     FROM excel_data 
                                     WHERE SUBSTRING(certificate_number, 7, 2) = '22'";
                        $sql_bohol = "SELECT COUNT(DISTINCT CONCAT(first_name, ' ', middle_name, ' ', last_name)) AS num_unique_bohol 
                                      FROM excel_data 
                                      WHERE SUBSTRING(certificate_number, 7, 2) = '12'";
                        $sql_siquijor = "SELECT COUNT(DISTINCT CONCAT(first_name, ' ', middle_name, ' ', last_name)) AS num_unique_siquijor 
                                         FROM excel_data 
                                         WHERE SUBSTRING(certificate_number, 7, 2) = '61'";
                        $sql_negros = "SELECT COUNT(DISTINCT CONCAT(first_name, ' ', middle_name, ' ', last_name)) AS num_unique_negros 
                                       FROM excel_data 
                                       WHERE SUBSTRING(certificate_number, 7, 2) = '46'";

                        // Execute queries
                        $result_cebu = $conn->query($sql_cebu);
                        $result_bohol = $conn->query($sql_bohol);
                        $result_siquijor = $conn->query($sql_siquijor);
                        $result_negros = $conn->query($sql_negros);

                        // Fetch results
                        $num_unique_cebu = $result_cebu->fetch_assoc()["num_unique_cebu"] ?? 0;
                        $num_unique_bohol = $result_bohol->fetch_assoc()["num_unique_bohol"] ?? 0;
                        $num_unique_siquijor = $result_siquijor->fetch_assoc()["num_unique_siquijor"] ?? 0;
                        $num_unique_negros = $result_negros->fetch_assoc()["num_unique_negros"] ?? 0;

                        // Display results in table rows
                        echo "<tr><td>Cebu</td><td>$num_unique_cebu</td></tr>";
                        echo "<tr><td>Bohol</td><td>$num_unique_bohol</td></tr>";
                        echo "<tr><td>Siquijor</td><td>$num_unique_siquijor</td></tr>";
                        echo "<tr><td>Negros</td><td>$num_unique_negros</td></tr>";

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="right-column">
                <h3>Pie Chart: Distribution of NTTC Holders by Province</h3>
                <canvas id="provinceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>NTTC Warm Bodies Count</h2>
            <p>This data represents the distribution of NTTC holders across the four provinces:</p>
            <ul>
                <li><strong>Cebu:</strong> <?php echo $num_unique_cebu; ?> unique NTTC holders</li>
                <li><strong>Bohol:</strong> <?php echo $num_unique_bohol; ?> unique NTTC holders</li>
                <li><strong>Siquijor:</strong> <?php echo $num_unique_siquijor; ?> unique NTTC holders</li>
            <li><strong>Negros:</strong> <?php echo $num_unique_negros; ?> unique NTTC holders</li>
            </ul>
        </div>
    </div>

    <script>
        // JavaScript code to render the pie chart using Chart.js
        var ctx = document.getElementById('provinceChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Cebu', 'Bohol', 'Siquijor', 'Negros'],
                datasets: [{
                    label: 'NTTC Holders',
                    data: [<?php echo $num_unique_cebu; ?>, <?php echo $num_unique_bohol; ?>, <?php echo $num_unique_siquijor; ?>, <?php echo $num_unique_negros; ?>],
                    backgroundColor: [
                        '#3498db', // Cebu
                        '#2ecc71', // Bohol
                        '#e74c3c', // Siquijor
                        '#f39c12'  // Negros
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        fontColor: '#333333'
                    }
                },
                title: {
                    display: true,
                    text: 'Distribution of NTTC Holders by Province',
                    fontSize: 18,
                    fontColor: '#333333'
                }
            }
        });

        // Modal script
        var modal = document.getElementById('infoModal');
        var infoBtn = document.getElementById('infoButton');
        var span = document.getElementsByClassName('close')[0];

        // When the user clicks the button, open the modal
        infoBtn.onclick = function() {
            modal.style.display = 'block';
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = 'none';
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Smooth transition effect after page is fully loaded
        window.onload = function() {
            var container = document.querySelector('.container');
            container.style.opacity = '1';
        };
    </script>
    
</body>
</html>
