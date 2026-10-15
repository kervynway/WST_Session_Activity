<?php
session_start();
require 'db.php'; // database connection file

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists in the database
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Compare the submitted password with the database password
        // Note: For real-world apps, always use password_verify() and hashed passwords
        if ($password === $row['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header("Location: home.php");
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "Invalid username!";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - DB Version</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            background-color: #f0f2f5; 
            margin: 0;
        }
        .login-container { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            width: 300px; 
        }
        .login-container h2 { 
            text-align: center; 
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] { 
            width: 100%; 
            padding: 10px; 
            margin: 10px 0 20px 0; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            box-sizing: border-box; 
        }
        input[type="submit"] { 
            width: 100%; 
            padding: 10px; 
            background-color: #28a745; /* Changed to green to indicate DB version */
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px;
        }
        input[type="submit"]:hover { 
            background-color: #218838; 
        }
        .error { 
            color: red; 
            text-align: center; 
            font-size: 14px; 
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Database Login</h2>
        <?php if($error != "") echo "<p class='error'>$error</p>"; ?>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Secure Login">
        </form>
    </div>
</body>
</html>