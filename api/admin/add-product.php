<?php
session_start();
include '../config.php'; // ✅ Correct path to config.php

// --- Admin access check ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// Fetch Materials and Industries for dropdowns
$materials = [];
$matResult = $conn->query("SELECT * FROM materials ORDER BY name ASC");
while ($row = $matResult->fetch_assoc()) {
    $materials[] = $row;
}

$industries = [];
$indResult = $conn->query("SELECT * FROM industries ORDER BY name ASC");
while ($row = $indResult->fetch_assoc()) {
    $industries[] = $row;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $material_id = intval($_POST['material_id']);
    $industry_id = intval($_POST['industry_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $image_url = "";

    // --- Handle image upload ---
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = "uploads/" . $file_name; // store relative path
        }
    }

    // --- Insert into database ---
    $stmt = $conn->prepare("INSERT INTO products (name, material_id, industry_id, description, image_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiss", $name, $material_id, $industry_id, $description, $image_url);

    if ($stmt->execute()) {
        $message = "✅ Product added successfully!";
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
<title>Add Product | Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">Admin Panel</h1>
    <a href="admin-dashboard.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Dashboard</a>
</header>

<section class="pt-10 pb-16 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Add New Product</h1>

    <?php if ($message): ?>
        <div class="mb-6 text-center text-lg font-medium text-green-600"><?= $message ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-xl p-8 space-y-6 border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
            <input type="text" name="name" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Material</label>
            <select name="material_id"  class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
                <option value="">Select Material</option>
                <?php foreach ($materials as $mat): ?>
                    <option value="<?= $mat['id'] ?>"><?= $mat['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Industry</label>
            <select name="industry_id"  class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
                <option value="">Select Industry</option>
                <?php foreach ($industries as $ind): ?>
                    <option value="<?= $ind['id'] ?>"><?= $ind['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="4" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500"></textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Upload Image</label>
            <input type="file" name="image" accept="image/*" required class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">Add Product</button>
    </form>
</section>

<footer class="bg-gray-800 text-gray-300 text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Kanchva Brass Components — Admin Panel
</footer>

<script>feather.replace();</script>
</body>
</html>
