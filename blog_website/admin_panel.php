<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$users_sql = "SELECT * FROM users";
$posts_sql = "SELECT * FROM posts";
$users_result = $conn->query($users_sql);
$posts_result = $conn->query($posts_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <p>Welcome, Admin!</p>


    <h3>Manage Users</h3>
    <?php
    if ($users_result->num_rows > 0) {
        echo "<table border='1'>
                <tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr>";
        while ($row = $users_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['username'] . "</td>
                    <td>" . $row['role'] . "</td>
                    <td>
                        <a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> |
                        <a href='delete_user.php?id=" . $row['id'] . "'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }
    ?>

    <br><br>

    <!-- Post Management Section -->
    <h3>Manage Posts</h3>
    <?php
    if ($posts_result->num_rows > 0) {
        echo "<table border='1'>
                <tr><th>ID</th><th>Title</th><th>Author ID</th><th>Actions</th></tr>";
        while ($row = $posts_result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['user_id'] . "</td>
                    <td>
                        <a href='editPost.php?id=" . $row['id'] . "'>Edit</a> |
                        <a href='deletePost.php?id=" . $row['id'] . "'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No posts found.</p>";
    }
    ?>

    <br><br>
    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
