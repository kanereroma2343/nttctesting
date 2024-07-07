<?php
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

// Initialize message variable
$message = "";

// Function to delete all data from the table
function deleteAllData() {
    global $conn, $message;
    
    $sql = "TRUNCATE TABLE excel_data"; // Change 'excel_data' to your table name
    if ($conn->query($sql) === TRUE) {
        $message = "All data deleted successfully.";
    } else {
        $message = "Error deleting data: " . $conn->error;
    }
}

// Check if the delete button is pressed
if (isset($_POST['delete'])) {
    deleteAllData(); // Call the function to delete all data
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete All Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #000000, #0000FF, #FFFFFF); /* Black to Blue to White gradient */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        h2 {
            color: #0000FF; /* Blue heading color */
            margin-bottom: 20px;
        }

        p {
            color: #333; /* Dark text color */
            margin-bottom: 20px;
        }

        .button-container {
            margin-bottom: 20px;
        }

        button, .button-container a {
            padding: 10px 20px;
            background-color: #0000FF; /* Blue button color */
            border: none;
            border-radius: 5px;
            color: #fff; /* White button text color */
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        button:hover, .button-container a:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* Modal Styles */
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
            animation: fadeIn 0.5s forwards;
        }

        .modal-dialog {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .modal-content {
            background-color: #000;
            background-image: linear-gradient(to bottom right, #0000FF, #FFFFFF);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 400px;
            text-align: center;
            transform: translateY(-50px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: slideDown 0.5s forwards, popOut 0.5s forwards;
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); }
            to { transform: translateY(0); }
        }

        @keyframes popOut {
            from { transform: scale(0.8); }
            to { transform: scale(1); }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #fff; /* White close button text color on hover */
            text-decoration: none;
            cursor: pointer;
        }

        .modal-title {
            color: #fff; /* White modal title text color */
            margin-bottom: 15px;
        }

        .modal-body {
            color: #fff; /* White modal body text color */
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #0000FF; /* Blue OK button color */
            border: none;
            border-radius: 5px;
            color: #fff; /* White OK button text color */
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="button-container">
            <a href="index.php" class="btn btn-secondary">Home</a>
        </div>
        <h2>Delete All Data</h2>
        <p>By clicking "Delete All Data", you will delete all records from the "Consolidated NTTC Registry Data". This action cannot be undone.</p>
        <form method="post">
            <button type="submit" name="delete" class="btn btn-danger">Delete All Data</button>
        </form>
    </div>

    <!-- Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo $message; ?></p>
                </div>
                <div class="modal-footer">
                    <a href="uploadxls.php" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var modal = document.getElementById("messageModal");

        // Show the modal if there is a message
        <?php if (!empty($message)): ?>
        modal.style.display = "block";
        modal.style.opacity = 1;
        <?php endif; ?>

        // Close the modal when the user clicks on <span> (x) or outside the modal
        var closeModal = function() {
            modal.style.display = "none";
        };
        
        var closeBtn = document.querySelector(".close");
        closeBtn.onclick = closeModal;

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
