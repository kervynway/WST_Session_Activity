<?php
session_start();

// Check if the user is actually logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f0f2f5; 
            text-align: center; 
            padding-top: 100px; 
        }
        .home-container { 
            background: white; 
            padding: 40px; 
            border-radius: 8px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            display: inline-block; 
        }
        .btn-logout { 
            display: inline-block; 
            margin-top: 20px; 
            padding: 10px 20px; 
            background-color: #dc3545; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
        }
        .btn-logout:hover { 
            background-color: #c82333; 
        }
    </style>
</head>
<body>
    <div class="home-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>You have successfully logged in using PHP Sessions.</p>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>