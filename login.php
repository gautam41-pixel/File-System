<?php
session_start(); // Start the session

$error = ""; // Initialize error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = md5($_POST['password']);

    $file = 'student.csv';
    $handle = fopen($file, "r");

    $loginSuccessful = false; // Initialize login status to false

    if ($handle !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[3] === $email && $data[4] === $password) {
                $loginSuccessful = true;

                // Create session variables
                $_SESSION['fname'] = $data[0];
                $_SESSION['lname'] = $data[1];
                $_SESSION['email'] = $email;

                break;
            }
        }
        fclose($handle);

        if ($loginSuccessful) {
            header("Location: profile.php");
            exit();
        } else {
            $error = "Invalid email or password. Please try again.";
        }
    } else {
        $error = "Error accessing user data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
         h1{
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 300px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="number"], input[type="email"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 22px);
        }
        input[type="submit"], button {
            padding: 10px;
            border: none;
            border-radius: 38px;
            background: #007BFF;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        input[type="submit"]:hover, button:hover {
            background: #0056b3;
        }
        button a {
            color: white;
            text-decoration: none;
        }
        button {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        a {
            text-align: center;
            display: block;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login">
        <a href="register.php">Sign Up</a>
    </form>
  
    <?php
    if ($error != "") {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</body>
</html>
