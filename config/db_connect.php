<?php
// config/db_connect.php

define('DB_SERVER', 'localhost'); // Or your DB host
define('DB_USERNAME', 'root');    // Your DB username
define('DB_PASSWORD', '');        // Your DB password (leave empty for default XAMPP/WAMP)
define('DB_NAME', 'user_system'); // Your database name

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    // Don't echo detailed errors in production! Log them instead.
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

// Optional: Set character set (good practice)
$mysqli->set_charset("utf8mb4");

// Turn on error reporting for mysqli (useful for development)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

?>