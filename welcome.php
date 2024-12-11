<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<br>
<br>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    <p>You have successfully logged in.</p>
    <a href="display_user.php" class="display-button">Display User</a> 
    <a href="logout.php" class="logout-button">Logout</a>
</div>
</body>
</html>

