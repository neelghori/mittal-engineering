<?php
// config.php
// Global application and database configuration settings

// --- 1. SESSION CONFIGURATION FOR VERCEL ---
// Configure session settings FIRST before any output or database connection
// This MUST run before any session_start() calls or output
if (session_status() === PHP_SESSION_NONE && !isset($GLOBALS['session_handler_set'])) {
    // Only configure session ini settings if headers haven't been sent
    // If headers are already sent, sessions will use default settings
    if (!headers_sent()) {
        @ini_set('session.cookie_httponly', '1');
        @ini_set('session.use_only_cookies', '1');
        @ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? '1' : '0');
        @ini_set('session.cookie_samesite', 'Lax');
        @ini_set('session.gc_maxlifetime', 86400); // 24 hours
    }
    
    // Mark handler as being set (we'll complete it after DB connection)
    $GLOBALS['session_handler_set'] = true;
}

// --- 2. APPLICATION CONSTANTS ---

// Define the recipient for contact form emails
// !!! IMPORTANT: CHANGE THIS TO YOUR ACTUAL EMAIL ADDRESS !!!
if (!defined('RECIPIENT_EMAIL')) {
    define('RECIPIENT_EMAIL', 'purchasekbc@gmail.com');
}

// Define your project's base URL path for links (e.g., /demo if your project is at http://localhost/demo/)
if (!defined('BASE_PATH')) {
    define('BASE_PATH', '/demo');
}

// --- 3. DATABASE CONFIGURATION ---

$servername = "118.139.183.156";
$username = "SeventGraphic";        // MySQL username (often 'root' on WAMP)
$password = "seventhGraphicTeam@2025";            // MySQL password (often empty on WAMP)
$dbname = "metalcraft_db"; // Your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection and stop execution if it fails
if ($conn->connect_error) {
    // If we can't set session settings, just die with error
    die("Connection failed: " . $conn->connect_error);
}

// --- 4. COMPLETE SESSION HANDLER SETUP ---
// Now that we have DB connection, set up database session handler
// Only configure if headers haven't been sent yet
if (session_status() === PHP_SESSION_NONE && isset($GLOBALS['session_handler_set']) && !isset($GLOBALS['session_handler_configured']) && !headers_sent()) {
    // Include session handler for database-backed sessions
    require_once __DIR__ . '/session_handler.php';
    
    // Set session handler to use database
    $handler = new DatabaseSessionHandler($conn);
    session_set_save_handler($handler, true);
    
    // Mark handler as fully configured
    $GLOBALS['session_handler_configured'] = true;
}