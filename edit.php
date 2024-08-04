<?php
session_start();

$file = 'student.csv';
$data = array();

if (($fp = fopen($file, 'r')) !== FALSE) {
    while (($row = fgetcsv($fp)) !== FALSE) {
        $data[] = $row;
    }
    fclose($fp);
} else {
    echo "Error reading CSV file.";
}

if (isset($_GET['index'])) {
    $index = $_GET['index'];
    if (isset($data[$index])) {
        $student = $data[$index];
    } else {
        echo "Invalid index.";
        exit();
    }
} else {
    echo "No index provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = htmlspecialchars($_POST['fname']);
    $lname = htmlspecialchars($_POST['lname']);
    $age = htmlspecialchars($_POST['age']);
    $email = htmlspecialchars($_POST['email']);
    $password = $student[4]; // Keep the original password

    $data[$index] = array($fname, $lname, $age, $email, $password);

    $fp = fopen($file, 'w');

    if ($fp) {
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);

        // Update session variables if the edited student is the current user
        if ($_SESSION['email'] == $email) {
            $_SESSION['fname'] = $fname;
            $_SESSION['lname'] = $lname;
        }

        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error writing to CSV file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 50%;
            max-width: 500px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px;
            border: none;
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>
        <form method="post" action="" id="editForm">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($student[0]); ?>" required>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($student[1]); ?>" required>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($student[2]); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student[3]); ?>" required>
            <input type="submit" value="Update">
        </form>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
