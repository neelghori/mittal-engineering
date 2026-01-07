<?php
session_start();
include '../config.php'; // Correct path

// --- Admin access check ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// --- Get material ID ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage-materials.php");
    exit;
}

$id = intval($_GET['id']);
$message = "";

// --- Fetch current material info ---
$stmt = $conn->prepare("SELECT * FROM materials WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manage-materials.php");
    exit;
}

$material = $result->fetch_assoc();
$stmt->close();

// --- Handle Update Form Submission ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $icon = $conn->real_escape_string($_POST['icon']);

    $stmt = $conn->prepare("UPDATE materials SET name=?, icon=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $icon, $id);

    if ($stmt->execute()) {
        $message = "✅ Material updated successfully!";
        // Refresh material info
        $material['name'] = $name;
        $material['icon'] = $icon;
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Material | Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">Edit Material</h1>
    <div class="flex items-center space-x-4">
        <a href="manage-materials.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Back</a>
        <a href="admin-dashboard.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Dashboard</a>
        <a href="logout.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Logout</a>
    </div>
</header>

<main class="flex-grow p-6 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Edit Material</h1>

    <?php if ($message): ?>
        <div class="mb-6 text-center text-lg font-medium text-green-600"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow-md rounded-xl p-8 space-y-6 border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Material Name</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($material['name']) ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Icon Name (feather-icons)</label>
            <input type="text" name="icon" placeholder="Optional, e.g., box" value="<?= htmlspecialchars($material['icon']) ?>" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">Update Material</button>
    </form>
</main>

<footer class="bg-gray-800 text-gray-300 text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Kanchva Brass Components — Admin Panel
</footer>

<script>feather.replace();</script>
</body>
</html>
