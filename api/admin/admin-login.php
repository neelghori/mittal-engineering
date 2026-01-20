<?php
// Start session - config.php will configure database-backed sessions
require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "kbc_jamnagar") {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_login_time'] = time();
        // Write session to database
        session_write_close();
        // Simple redirect - will work with Vercel routing
        header("Location: admin-dashboard.php");
        exit;
    } else {
        $error = "Invalid login details!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-8 rounded-lg shadow-md w-96 space-y-4">
        <h2 class="text-2xl font-bold text-center text-gray-800">Login</h2>
        <?php if(isset($error)): ?><div class="text-red-500 text-center"><?= $error ?></div><?php endif; ?>
        <input type="text" name="username" placeholder="Username" required class="w-full p-3 border rounded-lg">
        <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded-lg">
        <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg">Login</button>
    </form>
</body>
</html>
