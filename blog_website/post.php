<?php
include 'db.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <style>
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #000;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
        }

        .container h2 {
            color: #fff;
            margin-bottom: 15px;
        }

        .container p {
            color: #eee;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .back-button {
            padding: 10px;
            background-color: #fff;
            color: #000;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #ccc;
        }

        .not-found {
            color: #f00;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <?php if (isset($post) && $post): ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
    <?php else: ?>
        <p class="not-found">Post not found.</p>
    <?php endif; ?>

    <a href="index.php" class="back-button">Go Back</a>
</div>

</body>
</html>
