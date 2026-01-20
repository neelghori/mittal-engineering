<?php
require_once __DIR__ . '/../config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Admin access check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Server-side validation
    if (empty($_POST['company_name']) || empty($_POST['email']) || empty($_POST['phone1'])) {
        echo "<script>alert('Company Name, Email, and Phone 1 are required!'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE footer_settings SET company_name=?, description=?, address=?, phone1=?, phone2=?, email=?, facebook=?, linkedin=?, instagram=? WHERE id=1");
    $stmt->bind_param(
        "sssssssss",
        $_POST['company_name'],
        $_POST['description'],
        $_POST['address'],
        $_POST['phone1'],
        $_POST['phone2'],
        $_POST['email'],
        $_POST['facebook'],
        $_POST['linkedin'],
        $_POST['instagram']
    );
    $stmt->execute();
    echo "<script>alert('Footer updated successfully!'); window.location='footer-settings.php';</script>";
    exit;
}

// ✅ Fetch current footer data
$result = $conn->query("SELECT * FROM footer_settings WHERE id=1");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Footer Settings | Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold tracking-wide">Admin Panel</h1>
    <div class="flex items-center space-x-4">
        <a href="admin-dashboard.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Dashboard</a>
        <a href="logout.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Logout</a>
    </div>
</header>

<!-- Main Content -->
<main class="flex-grow p-6 max-w-3xl mx-auto">

    <div class="bg-white p-8 rounded-xl shadow-md mt-6">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <i data-feather="edit-3" class="text-orange-500 w-6 h-6 mr-2"></i> Edit Footer Settings
        </h2>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block font-medium mb-1">Company Name:</label>
                <input type="text" name="company_name" value="<?= htmlspecialchars($data['company_name']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Description:</label>
                <textarea name="description" class="w-full p-2 border rounded"><?= htmlspecialchars($data['description']) ?></textarea>
            </div>

            <div>
                <label class="block font-medium mb-1">Address:</label>
                <textarea name="address" class="w-full p-2 border rounded"><?= htmlspecialchars($data['address']) ?></textarea>
            </div>

            <div>
                <label class="block font-medium mb-1">Phone 1:</label>
                <input type="text" name="phone1" value="<?= htmlspecialchars($data['phone1']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Phone 2:</label>
                <input type="text" name="phone2" value="<?= htmlspecialchars($data['phone2']) ?>" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="w-full p-2 border rounded" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Facebook:</label>
                <input type="url" name="facebook" value="<?= htmlspecialchars($data['facebook']) ?>" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">LinkedIn:</label>
                <input type="url" name="linkedin" value="<?= htmlspecialchars($data['linkedin']) ?>" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Instagram:</label>
                <input type="url" name="instagram" value="<?= htmlspecialchars($data['instagram']) ?>" class="w-full p-2 border rounded">
            </div>

            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700 transition">Save Changes</button>
        </form>
    </div>

</main>

<!-- Footer -->
<footer class="bg-gray-800 text-gray-300 text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Kanchva Brass Components — Admin Panel
</footer>

<script>feather.replace();</script>
</body>
</html>


