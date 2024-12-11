<?php
session_start();  

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


if (!isset($_GET['matric'])) {
    die("Error: No matric provided.");
}

$matric = $_GET['matric']; 

// Database connection
$conn = new mysqli('localhost', 'root', '', 'Lab_5b');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete the user from the database
$sql = "DELETE FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric); 

if ($stmt->execute()) {
    echo "User deleted successfully.";
} else {
    echo "Error deleting user: " . $conn->error;
}

$stmt->close();
$conn->close();


header("Location: display_user.php");
exit();
?>
