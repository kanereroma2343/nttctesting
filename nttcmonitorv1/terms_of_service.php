<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #000, #00008b, #ffffff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
            overflow: hidden;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 90%;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 100px; /* Adjust the size as needed */
            height: 100px; /* Adjust the size as needed */
            margin: 0 10px;
        }

        h1, h2 {
            color: #ffffff;
            text-align: center;
        }

        p {
            line-height: 1.6;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
        <img src="icons/tlogo.png" alt="Logo 1">
        <img src="icons/blogo.png" alt="Logo 2">
        </div>
        <h1>Terms of Service</h1>
        <p>Welcome to our service. These terms of service outline the rules and regulations for the use of our website and services.</p>
        <h2>Acceptance of Terms</h2>
        <p>By accessing and using our services, you accept and agree to be bound by these terms. If you do not agree to these terms, please do not use our services.</p>
        <h2>Changes to Terms</h2>
        <p>We reserve the right to modify these terms at any time. We will notify you of any changes by updating the terms on our website. Your continued use of our services signifies your acceptance of the new terms.</p>
        <h2>Use of Services</h2>
        <p>Our services are intended for your personal, non-commercial use. You agree to use our services only for lawful purposes and in accordance with these terms.</p>
        <h2>Account Responsibilities</h2>
        <p>You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account. Please notify us immediately of any unauthorized use of your account.</p>
        <h2>Termination</h2>
        <p>We may terminate or suspend your access to our services at any time, without prior notice or liability, for any reason, including if you breach these terms.</p>
    </div>
</body>
</html>
