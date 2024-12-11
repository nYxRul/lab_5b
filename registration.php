<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
</head>
<body>
<h2>Registration Form</h2> <br>
    <form method="POST" action="registration.php">
        <label>Matric:</label>
        <input type="text" name="matric" required><br>
        
        <label>Name:</label>
        <input type="text" name="name" required><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br>
        
        <label>Role:</label>
        <select name="accessLevel" required>
            <option value="">Please select</option>
            <option value="lecturer">Lecturer</option>
            <option value="student">Student</option>
        </select><br>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'Lab_5b');

        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $accessLevel = $_POST['accessLevel'];

        
        $sql = "INSERT INTO users (matric, name, password, accessLevel) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $matric, $name, $password, $accessLevel);

        if ($stmt->execute()) {
            echo "<p>Registration successful!</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

