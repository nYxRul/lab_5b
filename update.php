<?php

session_start();  

// Check if the user is logged in
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


$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric);  
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows == 0) {
    die("Error: User not found with matric " . htmlspecialchars($matric));
}

$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newMatric = $_POST['matric']; 
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel']; 

    
    $update_sql = "UPDATE users SET matric = ?, name = ?, accessLevel = ? WHERE matric = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssss", $newMatric, $name, $accessLevel, $matric);

    if ($update_stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $conn->error;
    }

    $update_stmt->close();
    $conn->close();

    header("Location: display_user.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    
</head>
<body>
    <h2>Update User</h2>

    
    <?php if (isset($user)): ?>
    <form method="POST" action="update.php?matric=<?php echo urlencode($matric); ?>">
        <label for="matric">Matric:</label>
        <input type="text" name="matric" id="matric" value="<?php echo htmlspecialchars($user['matric']); ?>" required><br><br>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br><br>

        <label for="accessLevel">Access Level:</label>
        <select name="accessLevel" id="accessLevel" required>
            <option value="student" <?php if ($user['accessLevel'] == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($user['accessLevel'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br><br>

        <!-- Update and Cancel buttons -->
        <button type="submit">Update User</button><br><br>
        <a href="display_user.php"> 
            <button type="button" class="cancel-button">Cancel</button> 
        </a>
    </form>
</body>
</html>

<?php else: ?>
        <p>User data not found.</p>
    <?php endif; ?>