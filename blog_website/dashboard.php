<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role']; 

$sql = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-container {
            width: 80%;
            max-width: 800px;
            background-color: #000;
            padding: 20px;
            border-radius: 8px;
            color: #fff;
            box-shadow: 0px 0px 15px #ccc;
        }

        .dashboard-container h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .dashboard-container p {
            text-align: center;
            margin-bottom: 20px;
        }

        .dashboard-container a button {
            background-color: #fff;
            color: #000;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .dashboard-container a button:hover {
            background-color: #ccc;
        }

        .post {
            background-color: #fff;
            color: #000;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px #bbb;
        }

        .post h2 {
            margin: 0 0 10px;
        }

        .post p {
            margin-bottom: 10px;
        }

        .post a button {
            background-color: #000;
            color: #fff;
            padding: 8px 16px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .post a button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>This is your dashboard.</p>

    <?php if ($role == 'admin'): ?>
        <a href="admin_panel.php"><button>Admin Panel</button></a>
    <?php endif; ?>

    <a href="create_post.php"><button>Create a New Post</button></a>
    <a href="index.php"><button>View All Posts</button></a>
    <a href="logout.php"><button>Logout</button></a>

    <h3>Your Posts</h3>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post">';
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p>" . htmlspecialchars($row['content']) . "</p>";

            if ($role == 'admin' || $row['user_id'] == $user_id) {
                echo '<a href="editPost.php?id=' . $row['id'] . '"><button>Edit</button></a>';
                echo ' <a href="deletePost.php?id=' . $row['id'] . '"><button>Delete</button></a>';
            }

            echo "</div>";
        }
    } else {
        echo "<p>You have no posts yet.</p>";
    }
    ?>
</div>

</body>
</html>

<?php $conn->close(); ?>