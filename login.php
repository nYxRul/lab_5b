<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body> 
        <h2>Login Form</h2> <br>
        <form method="POST" action="login.php">
            <label>Matric:</label>
            <input type="text" name="matric" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button><br><br>
            <a href="registration.php">Register here if you not </a>
        </form><br>
</body>
</html>

<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matric = $_POST['matric'];
        $password = $_POST['password'];

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'Lab_5b');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the authentication
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['name']; 
                header("Location: welcome.php");
                exit();
            } else {
                echo "<p class='error'>Invalid password.</p>";
            }
        } else {
            echo "<p class='error'>Invalid matric number.</p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        ?>
        <?php
    }
    ?>


