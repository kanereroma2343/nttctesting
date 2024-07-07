
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Details</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #000, #fff);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 1074px;
            height: 878.73px;
            background: linear-gradient(to bottom right, #001f3f, #007bff);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .name-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .name-header h2 {
            margin: 0;
            color: #fff;
            font-size: 1.5em;
        }

        .tabs {
            display: flex;
            justify-content: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .tab {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .tab.active {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .tab h2 {
            margin: 0;
            color: #fff;
            transition: color 0.3s ease;
        }

        .tab.active h2 {
            color: #001f3f;
        }

        .content {
            display: none;
            width: 100%;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .content.active {
            display: block;
            opacity: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            word-wrap: break-word;
        }

        th {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }

        td {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .full-width {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <img src="../icons/tlogo.png" alt="Logo 1" id="logo1">
        <h1>Information Details</h1>
        <img src="../icons/blogo.png" alt="Logo 2" id="logo2">
    </div>

    <div class="name-header">
        <h2 id="name-header">John A. Doe Jr.</h2>
    </div>

    <div class="tabs">
        <div class="tab active" id="tab-trainer-profile">
            <h2>Trainer Profile</h2>
        </div>
        <div class="tab" id="tab-nttc-records">
            <h2>NTTC Records</h2>
        </div>
    </div>

    <div class="content active" id="content-trainer-profile">
        <table>
            <tr>
                <th>No.</th>
                <td id="no">12345</td>
                <th>Region</th>
                <td id="region">Region Name</td>
            </tr>
            <tr>
                <th>Province</th>
                <td id="province">Province Name</td>
                <th>Last Name</th>
                <td id="last-name">Doe</td>
            </tr>
            <tr>
                <th>First Name</th>
                <td id="first-name">John</td>
                <th>Middle Initial</th>
                <td id="middle-initial">A</td>
            </tr>
            <tr>
                <th>Extension</th>
                <td id="extension">Jr.</td>
                <th>Birthday</th>
                <td id="birthday">01/01/1980</td>
            </tr>
            <tr>
                <th>Sex</th>
                <td id="sex">Male</td>
                <th>Complete Address</th>
                <td id="complete-address" class="full-width">123 Main St, City, Country</td>
            </tr>
            <tr>
                <th>Training Institution/Company</th>
                <td id="training-institution">XYZ Training Center</td>
                <th>Type of Training Institution</th>
                <td id="type-of-institution">Private</td>
            </tr>
            <tr>
                <th>E-mail Address</th>
                <td id="email">johndoe@example.com</td>
                <th>Contact No.</th>
                <td id="contact-no">123-456-7890</td>
            </tr>
            <tr>
                <th>Educational Attainment</th>
                <td id="educational-attainment">Bachelor's Degree</td>
                <th>Training Hours</th>
                <td id="training-hours">120</td>
            </tr>
            <tr>
                <th>Practicing the Qualification</th>
                <td id="practicing-qualification">Yes</td>
            </tr>
        </table>
    </div>

    <div class="content" id="content-nttc-records">
        <table>
        <h3>Trainer's Methodology Details</h3>
            <tr>
                <th>TM Certificate Number</th>
                <td id="tm-certificate-number">TM123456</td>
            </tr>
            <tr>
                <th>Date Issued</th>
                <td id="date-issued">01/01/2020</td>
            </tr>
            <tr>
                <th>Expiration Date</th>
                <td id="expiration-date">01/01/2025</td>
            </tr>
            <tr>
                <th>Assessor 1</th>
                <td id="assessor1">Jane Smith</td>
            </tr>
            <tr>
                <th>Assessor 2</th>
                <td id="assessor2">Michael Brown</td>
            </tr>
            <tr>
                <th>Assessor 3</th>
                <td id="assessor3">Emily Johnson</td>
            </tr>
        </table>
        <h3>National Certificates Earned</h3>
        <table>
        <tr>
                <th>National Certificates</th>
                <td id="nc-issuance-date">Date of Issuances</td>
                <td id="nc-expiry-date">Validity</td>
            </tr>
    </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabTrainerProfile = document.getElementById('tab-trainer-profile');
        const tabNTTCRecords = document.getElementById('tab-nttc-records');
        const contentTrainerProfile = document.getElementById('content-trainer-profile');
        const contentNTTCRecords = document.getElementById('content-nttc-records');

        tabTrainerProfile.addEventListener('click', function() {
            tabTrainerProfile.classList.add('active');
            tabNTTCRecords.classList.remove('active');
            contentTrainerProfile.classList.add('active');
            contentNTTCRecords.classList.remove('active');
            contentNTTCRecords.style.minHeight = contentTrainerProfile.offsetHeight + 'px';
        });

        tabNTTCRecords.addEventListener('click', function() {
            tabNTTCRecords.classList.add('active');
            tabTrainerProfile.classList.remove('active');
            contentNTTCRecords.classList.add('active');
            contentTrainerProfile.classList.remove('active');
            contentNTTCRecords.style.minHeight = contentTrainerProfile.offsetHeight + 'px';
        });

        // Update the header with combined name fields
        const lastName = document.getElementById('last-name').innerText;
        const firstName = document.getElementById('first-name').innerText;
        const middleInitial = document.getElementById('middle-initial').innerText;
        const extension = document.getElementById('extension').innerText;
        document.getElementById('name-header').innerText = `${firstName} ${middleInitial}. ${lastName} ${extension}`;

        // Set initial height for NTTC Records content
        contentNTTCRecords.style.minHeight = contentTrainerProfile.offsetHeight + 'px';
    });
</script>

</body>
</html>
