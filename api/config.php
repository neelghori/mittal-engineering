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

// --- 3. SESSION CONFIGURATION FOR VERCEL ---
// Configure database-based sessions for serverless environment
// This MUST run before any session_start() calls
if (session_status() === PHP_SESSION_NONE && !isset($GLOBALS['session_handler_set'])) {
    // Include session handler for database-backed sessions
    require_once __DIR__ . '/session_handler.php';
    
    // Set session handler to use database
    $handler = new DatabaseSessionHandler($conn);
    session_set_save_handler($handler, true);
    
    // Configure session cookie settings for Vercel
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on');
    ini_set('session.cookie_samesite', 'Lax');
    ini_set('session.gc_maxlifetime', 86400); // 24 hours
    
    // Mark handler as set to prevent duplicate setup
    $GLOBALS['session_handler_set'] = true;
}