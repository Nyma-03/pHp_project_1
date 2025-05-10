<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();

   
    if ($post['user_id'] == $user_id || $_SESSION['role'] == 'admin') {
        
        $delete_sql = "DELETE FROM posts WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $post_id);
        
        if ($delete_stmt->execute()) {
            echo "<script>alert('Post deleted successfully!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Error deleting post.');</script>";
        }

        $delete_stmt->close();
    } else {
        echo "<script>alert('You do not have permission to delete this post.');</script>";
    }
} else {
    echo "<script>alert('Post not found!');</script>";
}

$stmt->close();
$conn->close();
?>
