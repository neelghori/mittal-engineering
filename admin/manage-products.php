<?php
session_start();
include '../config.php'; // Correct path

// --- Admin access check ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// --- Handle Delete Action ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Optional: delete image file from server
    $imgResult = $conn->query("SELECT image_url FROM products WHERE id=$id");
    if ($imgResult && $imgResult->num_rows > 0) {
        $imgRow = $imgResult->fetch_assoc();
        if ($imgRow['image_url'] && file_exists("../".$imgRow['image_url'])) {
            unlink("../".$imgRow['image_url']);
        }
    }

    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: manage-products.php");
    exit;
}

// --- Fetch all products ---
$result = $conn->query("
    SELECT p.id, p.name, p.image_url, m.name AS material_name, i.name AS industry_name
    FROM products p
    LEFT JOIN materials m ON p.material_id = m.id
    LEFT JOIN industries i ON p.industry_id = i.id
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Products | Admin Panel</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md">
    <h1 class="text-2xl font-bold">Manage Products</h1>
    <div class="flex items-center space-x-4">
        <a href="add-product.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Add Product</a>
        <a href="admin-dashboard.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Dashboard</a>
        <a href="logout.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Logout</a>
    </div>
</header>

<main class="flex-grow p-6 max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">All Products</h1>

    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-orange-50">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Image</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Name</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Material</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Industry</th>
                    <th class="px-6 py-3 text-center text-gray-700 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-orange-50">
                            <td class="px-6 py-3">
                                <?php if($row['image_url']): ?>
                                    <img src="../<?= $row['image_url'] ?>" alt="<?= $row['name'] ?>" class="w-16 h-16 object-cover rounded-lg border">
                                <?php else: ?>
                                    <span class="text-gray-400">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-3 font-medium text-gray-800"><?= $row['name'] ?></td>
                            <td class="px-6 py-3 text-gray-600"><?= $row['material_name'] ?: '-' ?></td>
                            <td class="px-6 py-3 text-gray-600"><?= $row['industry_name'] ?: '-' ?></td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <a href="edit-product.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 font-semibold">Edit</a>
                                <a href="manage-products.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-6 text-gray-500">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<footer class="bg-gray-800 text-gray-300 text-center py-4 mt-auto">
    &copy; <?= date('Y') ?> Kanchva Brass Components — Admin Panel
</footer>

<script>feather.replace();</script>
</body>
</html>
