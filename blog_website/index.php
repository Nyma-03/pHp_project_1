<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog Website</title>

    <style>
    /* General body styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }

    /* Navbar styles */
    nav {
        background-color: #333;
        overflow: hidden;
        width: 100%; /* Ensure the navbar takes the full width of the page */
    }

    nav a {
        float: left;
        display: block;
        color: white;
        text-align: center;
        padding: 30px 100px; /* Increase padding for wider navbar */
        text-decoration: none;
        font-size: 17px;
        transition: background-color 0.3s ease; /* Smooth hover effect */
    }

    nav a:hover {
        background-color: #ddd;
        color: black;
    }

    /* Container for the content */
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
    }

    /* Blog post box styles */
    .post-box {
        background-color: #fff;
        padding: 20px;
        margin: 10px 0;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .post-box h2 {
        color: #333;
    }

    .post-box p {
        color: #555;
        font-size: 16px;
    }

    .post-box a {
        color: #007bff;
        text-decoration: none;
    }

    .post-box a:hover {
        text-decoration: underline;
    }

    hr {
        margin-top: 20px;
        border: 0;
        border-top: 1px solid #eee;
    }
</style>
</head>
<body>
    
    <nav>
        <a href="index.php">Home</a>
        <a href="register.php">Sign Up</a>
        <a href="login.php">Sign In</a>
        <a href="create_post.php">Post a Blog</a>
        <a href="dashboard.php">Go to profile</a>
    </nav>

    
    <div class="container">
        <h1>Welcome to My Blog Website</h1>

        <?php
        include 'db.php';

       
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        
        if ($result->num_rows > 0) {
           
            while($row = $result->fetch_assoc()) {
                echo "<div class='post-box'>";
                echo "<h2>" . $row['title'] . "</h2>";
                echo "<p>" . substr($row['content'], 0, 100) . "... <a href='post.php?id=" . $row['id'] . "'>Read more</a></p>";
                echo "<hr>";
                echo "</div>";
            }
        } else {
            echo "<p>No posts found.</p>";
        }

       
        $conn->close();
        ?>
    </div>

</body>
</html>
