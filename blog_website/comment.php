<?php
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $author = $_POST['author'];
    $comment = $_POST['comment'];

   
    $sql = "INSERT INTO comments (post_id, author, comment) VALUES ('$post_id', '$author', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "Comment added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    
    header('Location: index.php');
    exit;
}
?>
