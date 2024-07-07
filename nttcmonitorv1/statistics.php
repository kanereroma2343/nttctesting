<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NTTC Statistics</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #FFFFFF, #0000FF, #000000);
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    h2, h3 {
        margin-bottom: 20px;
    }

    /* Table styles */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    /* Table header */
    th {
        background-color: #3498db; /* Light blue */
        color: white;
        padding: 10px;
        text-align: center;
    }

    /* Table rows */
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Alternate row color */
    tr:nth-child(even) {
        background-color: #f2f2f2; /* Lighter background */
    }

    /* Hover effect */
    tr:hover {
        background-color: #2980b9; /* Darker blue on hover */
        color: white;
    }

    canvas {
        margin: 20px auto;
        display: block;
        max-width: 600px;
        max-height: 400px;
    }

    .logo-container {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .logo-container img {
        width: 220px;
        height: 100px;
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

    .header-buttons a:hover {
        background-color: #0056b3;
    }

    .flex-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .flex-item {
        width: calc(50% - 10px);
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
    background-color: rgba(0, 0, 0, 0.4);
    transition: opacity 0.3s ease;
    opacity: 0;
}

.modal.show {
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
}

.modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 400px; /* Adjust this to make it smaller */
    border-radius: 10px;
    position: fixed; /* Position fixed for centering */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.5); /* Start with a smaller scale */
    animation: modalopen 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    opacity: 0;
    visibility: hidden;
}

.modal.show .modal-content {
    opacity: 1;
    visibility: visible;
    transform: translate(-50%, -50%) scale(1); /* Full scale when shown */
}

@keyframes modalopen {
    0% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.5); /* Start smaller */
    }
    100% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1); /* End with full size */
    }
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

.modal input {
    width: calc(100% - 20px);
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.modal button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}
</style>

</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="icons/both.png" alt="Logo">
        </div>
        <h2>Current NTTC Holders Monitoring Data</h2>
        <h3 id="currentDate">As of: </h3>

        <div class="header-buttons">
            <a href="index.php">Home</a>
            <a href="#" id="infoButton">Info</a>      
            <a href="statistics2.php">Statistics 2</a>   
        </div>

        <div class="flex-container">
            <div class="flex-item">
                <h2>NTTC Statistics</h2>
                <table>
                    <thead>
                        <tr>
                            <th>NC Level Trainers</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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

                        // Initialize counters for NC levels
                        $nc_counts = array(
                            'NC I' => 0,
                            'NC II' => 0,
                            'NC III' => 0,
                            'NC IV' => 0
                        );

                        // Query to fetch counts of NC holders
                        $sql = "SELECT certificate_number FROM excel_data";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Iterate through each row and count NC holders
                            while ($row = $result->fetch_assoc()) {
                                $certificate_number = $row['certificate_number'];
                                $nc_level = substr($certificate_number, 9, 1);

                                switch ($nc_level) {
                                    case '1':
                                        $nc_counts['NC I']++;
                                        break;
                                    case '2':
                                        $nc_counts['NC II']++;
                                        break;
                                    case '3':
                                        $nc_counts['NC III']++;
                                        break;
                                    case '4':
                                        $nc_counts['NC IV']++;
                                        break;
                                    default:
                                        // Handle other cases if needed
                                        break;
                                }
                            }
                        }

                        // Query to fetch unique names count
$sql_unique = "SELECT DISTINCT first_name, last_name FROM excel_data";
$result_unique = $conn->query($sql_unique);
$unique_count = $result_unique->num_rows;

// Initialize array for training institution type counts
$training_institution_type = array(
    'Private' => 0,
    'Public' => 0
);

// Query to fetch counts of training institutions
$sql_institution = "SELECT training_institution_type FROM excel_data";
$result_institution = $conn->query($sql_institution);

if ($result_institution->num_rows > 0) {
    while ($row = $result_institution->fetch_assoc()) {
        $training_type = $row['training_institution_type'];
        // Count based on the training_institution_type column
        if ($training_type === 'Private') {
            $training_institution_type['Private']++;
        } elseif ($training_type === 'Public') {
            $training_institution_type['Public']++;
        }
    }
}

                        // Close connection
                        $conn->close();

                        // Output the counts of NC levels
                        foreach ($nc_counts as $nc_level => $count) {
                            echo "<tr>";
                            echo "<td>$nc_level</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                        }

                        // Calculate total count
                        $total_count = array_sum($nc_counts);
                        echo "<tr>";
                        echo "<td><strong>Total</strong></td>";
                        echo "<td><strong>$total_count</strong></td>";
                        echo "</tr>";

                        // Output the unique names count (Warm Bodies)
                        echo "<tr>";
                        echo "<td><strong>Warm Bodies</strong></td>";
                        echo "<td><strong>$unique_count</strong></td>";
                        echo "</tr>";
                        ?>
                    </tbody>
                </table>
                <h2>Training Institution Type</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Institution Type</th>
                            <th>Count</th>
                            <th
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Output the training institution type counts
                        foreach ($training_institution_type as $type => $count) {
                            echo "<tr>";
                            echo "<td>$type</td>";
                            echo "<td>$count</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="flex-item">
                <h2>Graphical View</h2>
                <canvas id="myChart"></canvas>
                <h2>Training Institution Chart</h2>
                <canvas id="trainingInstitutionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="infoModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>As of the current date, NTTC holds the following certifications among its members:</p>
        <ul>
            <li><?php echo $nc_counts['NC I']; ?> individuals hold NC I certification.</li>
            <li><?php echo $nc_counts['NC II']; ?> individuals hold NC II certification.</li>
            <li><?php echo $nc_counts['NC III']; ?> individuals hold NC III certification.</li>
            <li><?php echo $nc_counts['NC IV']; ?> individuals hold NC IV certification.</li>
        </ul>
        <p>In total, there are <?php echo $unique_count; ?> unique certified members ("Warm Bodies").</p>
        <p>The NTTC Holders are made up roughly of <?php echo $training_institution_type['Private']; ?> trainers in private sectors and <?php echo $training_institution_type['Public']; ?> in public training institutions.</p>
    </div>
</div>    <script>
         document.addEventListener("DOMContentLoaded", function () {
            // Your existing JavaScript code for the date and charts    
        });
        // JavaScript for the modal
        document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('infoModal');
        var infoBtn = document.getElementById("infoButton");
        var span = document.getElementsByClassName("close")[0];

        infoBtn.onclick = function() {
            modal.classList.add('show');
            modal.style.display = 'block'; // Ensure modal is displayed immediately
            setTimeout(function() {
                modal.classList.add('showModal');
            }, 10); // Small delay for smoother transition start
        }

        span.onclick = function() {
            modal.classList.remove('showModal');
            setTimeout(function() {
                modal.style.display = 'none';
            }, 300); // Ensure modal is hidden after transition
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.classList.remove('showModal');
                setTimeout(function() {
                    modal.style.display = 'none';
                }, 300); // Ensure modal is hidden after transition
            }
        }
    });

        // JavaScript for charts using Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['NC I', 'NC II', 'NC III', 'NC IV'],
                datasets: [{
                    label: 'Number of Holders',
                    data: [<?php echo $nc_counts['NC I']; ?>, <?php echo $nc_counts['NC II']; ?>, <?php echo $nc_counts['NC III']; ?>, <?php echo $nc_counts['NC IV']; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var institutionCtx = document.getElementById('trainingInstitutionChart').getContext('2d');
        var myInstitutionChart = new Chart(institutionCtx, {
            type: 'pie',
            data: {
                labels: ['Private', 'Public'],
                datasets: [{
                    label: 'Training Institution Type',
                    data: [<?php echo $training_institution_type['Private']; ?>, <?php echo $training_institution_type['Public']; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Update current date in the heading
        var currentDate = new Date();
        var formattedDate = currentDate.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true });
        document.getElementById('currentDate').innerText = "As of: " + formattedDate;
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
