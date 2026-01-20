<?php
if (session_status() === PHP_SESSION_NONE) {
    // Configure session for Vercel/serverless environment
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "kbc_jamnagar") {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username; // Store username as well
        // Explicitly write and close session before redirect
        session_write_close();
        // Use absolute redirect URL for Vercel compatibility
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['REQUEST_URI']);
        header("Location: " . $protocol . $host . $path . "/admin-dashboard.php");
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
