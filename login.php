<?php
// login.php
session_start(); // Start the session

// If user is already logged in, redirect them to the dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

require_once 'config/db_connect.php';

$login_identifier = $password = ""; // Can be username or email
$login_identifier_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username/email is empty
    if (empty(trim($_POST["login_identifier"]))) {
        $login_identifier_err = "Please enter username or email.";
    } else {
        $login_identifier = trim($_POST["login_identifier"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($login_identifier_err) && empty($password_err)) {
        // Prepare a select statement
        // Check both username and email
        $sql = "SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $param_login, $param_login);
            $param_login = $login_identifier;

            if ($stmt->execute()) {
                $stmt->store_result();

                // Check if user exists
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        // Verify password
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_regenerate_id(); // Prevent session fixation

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email; // Store email too if needed

                            // Redirect user to dashboard page
                            header("location: dashboard.php");
                            exit; // Important to exit after redirection
                        } else {
                            // Display an error message if password is not valid
                            $login_err = "Invalid username/email or password.";
                        }
                    }
                } else {
                    // Display an error message if user doesn't exist
                    $login_err = "Invalid username/email or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    // Close connection
    // $mysqli->close(); // Might be needed later by other parts of the page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
     <style>
        /* Basic Styling - Same as signup or link to external CSS */
        body { font-family: sans-serif; padding: 20px; }
        .wrapper { width: 360px; padding: 20px; margin: auto; border: 1px solid #ccc; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] {
            width: 95%; /* Adjusted for padding */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .help-block { color: red; font-size: 0.9em; }
        .login-err { color: red; font-size: 0.9em; margin-bottom: 15px; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php
        if (!empty($login_err)) {
            echo '<div class="login-err">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($login_identifier_err)) ? 'has-error' : ''; ?>">
                <label>Username or Email</label>
                <input type="text" name="login_identifier" value="<?php echo htmlspecialchars($login_identifier); ?>">
                <span class="help-block"><?php echo $login_identifier_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login">
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>