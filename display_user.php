<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
</html>

<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'Lab_5b');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
    $sql = "SELECT matric, name, accessLevel FROM users";
    $result = $conn->query($sql);

    
    if ($result === false) {
        die("Error fetching data: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Matric</th>
                    <th>Name</th>
                    <th>Access Level</th>
                    <th>Actions</th>
                </tr>";

        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['matric']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['accessLevel']) . "</td>
                    <td>
                        <a href='update.php?matric=" . urlencode($row['matric']) . "'>Update</a> |
                        <a href='delete.php?matric=" . urlencode($row['matric']) . "'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
