<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Post not found!";
    exit();
}

$row = $result->fetch_assoc();

if ($row['user_id'] != $user_id && $_SESSION['role'] != 'admin') {
    echo "You do not have permission to edit this post.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $post_id);

        if ($stmt->execute()) {
            echo "<script>alert('Post updated successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating post.');</script>";
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
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Post</h2>
    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>

        <label for="content">Content:</label>
        <textarea name="content" id="content" rows="5" required><?php echo htmlspecialchars($row['content']); ?></textarea><br><br>

        <button type="submit">Update Post</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php
$conn->close();
?>
