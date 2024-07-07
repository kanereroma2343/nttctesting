<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel File Upload</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome for icons -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery for animation -->
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #000000, #000033, #ffffff); /* Black-blue-white gradient background */
        }

        .container {
            width: 50%;
            border: 2px solid #d9d2e9; 
            border-radius: 10px;
            padding: 20px;
            background: linear-gradient(to right, #000000, #0000FF);
            color: white;
            text-align: center;
            position: relative; /* Position for relative positioning of the uploading icon */
        }

        h1 {
            color: white;
        }

        form {
            margin-top: 20px;
            position: relative; /* Position for the icon */
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="file"] {
            display: block;
            margin: 0 auto;
            border: 1px solid #d9d2e9; /* Neon green border */
            padding: 8px;
            border-radius: 5px;
            background: linear-gradient(to right, #000000, #0000FF);
            color: white;
            font-weight: bold;
        }

        button[type="submit"] {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            background: linear-gradient(to right, #000000, #0000FF);
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            position: relative; /* Position for the icon */
        }

        button[type="submit"]:hover {
            background: linear-gradient(to right, #0000FF, #000000);
        }

        /* Animation for the icon */
        .uploading-icon {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            display: none; /* Initially hidden */
            width: 100%;
            margin-top: 20px; /* Adjusted margin to position below the form */
        }

        .progress-bar {
            width: 50%;
            height: 20px;
            background-color: #333;
            border-radius: 10px;
            overflow: hidden;
            margin: 0 auto; /* Center the progress bar */
            position: relative;
            border: 2px solid black; /* Black outline */
            margin-top: 30px;
        }

        .progress-bar-inner {
            height: 100%;
            background-image: linear-gradient(45deg, rgba(0, 255, 0, 0.5) 25%, transparent 25%, transparent 50%, rgba(0, 255, 0, 0.5) 50%, rgba(0, 255, 0, 0.5) 75%, transparent 75%, transparent);
            background-size: 40px 40px;
            animation: move-stripes 1s linear infinite;
        }

        @keyframes move-stripes {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 40px 0;
            }
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload NTTC Consolidated File</h1>
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Select Excel file:</label>
            <input type="file" name="file" id="file" accept=".xls,.xlsx" required>
            <button type="submit" id="uploadButton">Upload</button>
            <!-- Uploading icon -->
            <div class="uploading-icon" id="uploadingIcon">
                <div class="progress-bar">
                    <div class="progress-bar-inner"></div>
                    <div class="progress-text">0%</div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function() {
                $('#uploadButton').hide(); // Hide the upload button
                $('#uploadingIcon').show(); // Show the uploading icon
                simulateProgress();
                // You can add further actions like AJAX submission here if needed
            });
        });

        function simulateProgress() {
            var progressBar = $('.progress-bar-inner');
            var progressText = $('.progress-text');
            var width = 0;
            var interval = setInterval(function() {
                width += 5;
                progressBar.width(width + '%');
                progressText.text(width + '%');
                if (width >= 100) {
                    clearInterval(interval);
                    // Here you can perform actions after upload completion
                }
            }, 200); // Adjust the interval as needed for the progress speed
        }
    </script>
</body>
</html>
