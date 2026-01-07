<?php
// config.php
// Global application and database configuration settings

// --- 1. APPLICATION CONSTANTS ---

// Define the recipient for contact form emails
// !!! IMPORTANT: CHANGE THIS TO YOUR ACTUAL EMAIL ADDRESS !!!
if (!defined('RECIPIENT_EMAIL')) {
    define('RECIPIENT_EMAIL', 'purchasekbc@gmail.com');
}

// Define your project's base URL path for links (e.g., /demo if your project is at http://localhost/demo/)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/demo');
}


// --- 2. DATABASE CONFIGURATION ---

$servername = "118.139.183.156";
$username = "SeventGraphic";        // MySQL username (often 'root' on WAMP)
$password = "seventhGraphicTeam@2025";            // MySQL password (often empty on WAMP)
$dbname = "metalcraft_db"; // Your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection and stop execution if it fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
