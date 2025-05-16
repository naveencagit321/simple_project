<?php
session_start();

// If user is already logged in, maybe redirect them to the dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Optionally redirect logged-in users away from index
    // header("location: dashboard.php");
    // exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
     <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; }
        .links a { margin: 0 15px; padding: 10px 20px; text-decoration: none; background-color: #eee; border: 1px solid #ccc; border-radius: 4px; color: #333; }
        .links a:hover { background-color: #ddd; }
        .welcome-msg { margin-top: 30px; color: green; }
    </style>
</head>
<body>
    <h1>Simple PHP Login System</h1>

    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
        <p class="welcome-msg">You are currently logged in as <?php echo htmlspecialchars($_SESSION["username"]); ?>.</p>
        <div class="links">
             <a href="dashboard.php">Go to Dashboard</a>
             <a href="logout.php">Logout</a>
        </div>
    <?php else: ?>
        <p>Please login or sign up.</p>
         <div class="links">
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
        </div>
    <?php endif; ?>

</body>
</html>