<?php
session_start(); // Start the session
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['fname']) . " " . htmlspecialchars($_SESSION['lname']); ?>!</h1>
        <p>Your email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <div class="buttons">
            <a href="logout.php" class="btn">Logout</a>
            <a href="dashboard.php" class="btn">Dashboard</a>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
