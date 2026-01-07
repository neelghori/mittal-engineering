<?php
session_start();
include '../config.php'; // ✅ Correct path

// --- Admin access check ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// --- Validate Product ID ---
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: admin-dashboard.php");
    exit;
}

$product_id = intval($_GET['id']);

// --- Fetch Materials and Industries ---
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

// --- Fetch existing product ---
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    $message = "❌ Product not found!";
}

// --- Update logic ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $material_id = intval($_POST['material_id']);
    $industry_id = intval($_POST['industry_id']);
    $description = $conn->real_escape_string($_POST['description']);
    $image_url = $product['image_url']; // keep old image by default

    // --- Handle new image upload ---
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = "uploads/" . $file_name;

            // Delete old image file if it exists
            if (!empty($product['image_url']) && file_exists("../" . $product['image_url'])) {
                unlink("../" . $product['image_url']);
            }
        }
    }

    // --- Update query ---
    $stmt = $conn->prepare("UPDATE products SET name=?, material_id=?, industry_id=?, description=?, image_url=? WHERE id=?");
    $stmt->bind_param("siissi", $name, $material_id, $industry_id, $description, $image_url, $product_id);

    if ($stmt->execute()) {
        $message = "✅ Product updated successfully!";
        $stmt->close();

        // 🔁 Refresh product data using a new statement
        $stmt2 = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt2->bind_param("i", $product_id);
        $stmt2->execute();
        $product = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();
    } else {
        $message = "❌ Error: " . $stmt->error;
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product | Admin Panel</title>
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
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Product</h1>
        <a href="manage-products.php" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg font-semibold transition">← Back</a>
    </div>

    <?php if ($message): ?>
        <div class="mb-6 text-center text-lg font-medium text-green-600"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($product): ?>
    <form action="" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-xl p-8 space-y-6 border border-gray-200">
        <div>
            <label class="block text-gray-700 font-semibold mb-2">Product Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Material</label>
            <select name="material_id" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
                <option value="">Select Material</option>
                <?php foreach ($materials as $mat): ?>
                    <option value="<?= $mat['id'] ?>" <?= $mat['id'] == $product['material_id'] ? 'selected' : '' ?>><?= $mat['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Industry</label>
            <select name="industry_id" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500">
                <option value="">Select Industry</option>
                <?php foreach ($industries as $ind): ?>
                    <option value="<?= $ind['id'] ?>" <?= $ind['id'] == $product['industry_id'] ? 'selected' : '' ?>><?= $ind['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" rows="4" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Current Image</label>
            <?php if (!empty($product['image_url'])): ?>
                <img src="../<?= $product['image_url'] ?>" alt="Product Image" class="h-32 rounded-lg border mb-3">
            <?php else: ?>
                <p class="text-gray-500 italic mb-3">No image uploaded</p>
            <?php endif; ?>
            <input type="file" name="image" accept="image/*" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-orange-500">
        </div>

        <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition">Update Product</button>
    </form>
    <?php endif; ?>
</section>

<footer class="bg-gray-800 text-gray-300 text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Kanchva Brass Components — Admin Panel
</footer>

<script>feather.replace();</script>
</body>
</html>
