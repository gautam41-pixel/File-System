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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 5px 10px;
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
        <h1>Students List</h1>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php foreach ($data as $index => $row) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row[0]); ?></td>
                <td><?php echo htmlspecialchars($row[1]); ?></td>
                <td><?php echo htmlspecialchars($row[2]); ?></td>
                <td><?php echo htmlspecialchars($row[3]); ?></td>
                <td><a href="edit.php?index=<?php echo $index; ?>" class="btn">Edit</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const editLinks = document.querySelectorAll('.btn');

            editLinks.forEach(link => {
                link.addEventListener('click', (event) => {
                    if (!confirm('Are you sure you want to edit this entry?')) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
