<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
       
        $stmt = $conn->prepare("INSERT INTO posts (title, content, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $content, $user_id);

        if ($stmt->execute()) {
            echo "<script>alert('Post created successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error creating post.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('All fields are required!');</script>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Create Post</title>
</head>
<body>
    <h2>Create a New Post</h2>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="5" required></textarea><br><br>

        <button type="submit">Create Post</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
