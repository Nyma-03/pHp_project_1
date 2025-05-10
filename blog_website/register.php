<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; 

 
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already taken.";
    } else {
       
        $insert_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ss", $username, $hashed_password);

        if ($insert_stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php"); 
        } else {
            echo "Error during registration.";
        }

        $insert_stmt->close();
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #000;
            border-radius: 8px;
            box-shadow: 0px 0px 10px #ccc;
        }

        .container h2 {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container input {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
        }

        .container input[type="text"],
        .container input[type="password"] {
            background-color: #eee;
        }

        .container button {
            padding: 10px;
            background-color: #fff;
            color: #000;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .container button:hover {
            background-color: #ccc;
        }

        .container p {
            text-align: center;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>