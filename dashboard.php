<?php
// dashboard.php
session_start(); // Initialize the session

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include db connection if you need to fetch more user data
// require_once 'config/db_connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        /* Basic Styling */
        body { font-family: sans-serif; text-align: center; padding: 50px; }
        h1 { color: #333; }
        p { margin-top: 20px; }
        a { color: #007bff; text-decoration: none; padding: 5px 10px; border: 1px solid #007bff; border-radius: 3px; }
        a:hover { background-color: #007bff; color: white; }
        .user-info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>!</h1>
    <div class="user-info">
        <p>Welcome to your dashboard.</p>
        <p>Your registered email is: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
        </div>

    <p>
        <a href="logout.php">Sign Out of Your Account</a>
    </p>
</body>
</html>