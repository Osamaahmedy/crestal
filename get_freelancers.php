<?php
// Database connection settings
require 'DB.php';

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve freelancers' data
$sql = "SELECT name, phone FROM freelancers";
$result = $conn->query($sql);

$freelancers = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $freelancers[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancers List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"], input[type="tel"] {
            padding: 8px;
            margin-bottom: 10px;
            width: calc(100% - 16px);
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Freelancers List</h2>

<form id="userForm">
    <label for="userName">Your Name:</label>
    <input type="text" id="userName" name="userName" required>
    
    <label for="userPhone">Your Phone Number:</label>
    <input type="tel" id="userPhone" name="userPhone" required pattern="\+?[0-9\s]{10,}">
    
    <input type="submit" value="Start Chat">
</form>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($freelancers as $freelancer): ?>
            <tr>
                <td><?php echo htmlspecialchars($freelancer['name']); ?></td>
                <td><?php echo htmlspecialchars($freelancer['phone']); ?></td>
                <td><button onclick="startChat('<?php echo htmlspecialchars($freelancer['phone']); ?>')">Start Chat</button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function startChat(freelancerPhone) {
        const userName = document.getElementById('userName').value;
        const userPhone = document.getElementById('userPhone').value;
        if (userName && userPhone) {
            const message = `Hello, my name is ${userName} and my phone number is ${userPhone}.`;
            const whatsappUrl = `https://wa.me/${freelancerPhone.replace(/\s+/g, '')}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
        } else {
            alert('Please enter your name and phone number.');
        }
    }
</script>

</body>
</html>