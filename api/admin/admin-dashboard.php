<?php
session_start();
require_once __DIR__ . '/../config.php';

// ✅ Admin access check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// ✅ Fetch Dashboard Data
$productCount  = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
$materialCount = $conn->query("SELECT COUNT(*) as total FROM materials")->fetch_assoc()['total'];
$industryCount = $conn->query("SELECT COUNT(*) as total FROM industries")->fetch_assoc()['total'];

// ✅ Fetch latest 5 products
$recentProducts = $conn->query("
    SELECT p.id, p.name, m.name AS material_name, i.name AS industry_name, p.image_url
    FROM products p
    LEFT JOIN materials m ON p.material_id = m.id
    LEFT JOIN industries i ON p.industry_id = i.id
    ORDER BY p.id DESC LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | Kanchva Brass Components</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-50">
  <h1 class="text-2xl font-bold tracking-wide">Admin Dashboard</h1>
  <div class="flex items-center space-x-4">
    <a href="add-product.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">+ Add Product</a>
    <a href="footer-settings.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Footer Settings</a>
    <a href="manage-industries.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Manage Industries</a>
    <a href="logout.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Logout</a>
  </div>
</header>

<main class="flex-grow p-6 max-w-7xl mx-auto">

  <!-- Stats Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
      <i data-feather="box" class="text-orange-500 w-10 h-10 mx-auto mb-2"></i>
      <h3 class="text-3xl font-bold"><?= $productCount ?></h3>
      <p class="text-gray-600">Total Products</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
      <i data-feather="layers" class="text-orange-500 w-10 h-10 mx-auto mb-2"></i>
      <h3 class="text-3xl font-bold"><?= $materialCount ?></h3>
      <p class="text-gray-600">Total Materials</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
      <i data-feather="briefcase" class="text-orange-500 w-10 h-10 mx-auto mb-2"></i>
      <h3 class="text-3xl font-bold"><?= $industryCount ?></h3>
      <p class="text-gray-600">Total Industries</p>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-white p-8 rounded-xl shadow mb-10">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="settings" class="text-orange-500 w-6 h-6 mr-2"></i> Quick Actions
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
      <a href="add-product.php" class="flex flex-col items-center justify-center p-6 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition">
        <i data-feather="plus-square" class="text-orange-500 w-10 h-10 mb-2"></i>
        <span class="font-medium text-gray-700">Add Product</span>
      </a>

      <a href="manage-products.php" class="flex flex-col items-center justify-center p-6 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition">
        <i data-feather="edit" class="text-orange-500 w-10 h-10 mb-2"></i>
        <span class="font-medium text-gray-700">Manage Products</span>
      </a>

      <a href="manage-materials.php" class="flex flex-col items-center justify-center p-6 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition">
        <i data-feather="layers" class="text-orange-500 w-10 h-10 mb-2"></i>
        <span class="font-medium text-gray-700">Manage Materials</span>
      </a>

      <a href="manage-industries.php" class="flex flex-col items-center justify-center p-6 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition">
        <i data-feather="briefcase" class="text-orange-500 w-10 h-10 mb-2"></i>
        <span class="font-medium text-gray-700">Manage Industries</span>
      </a>

      <a href="footer-settings.php" class="flex flex-col items-center justify-center p-6 bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg transition">
        <i data-feather="edit-3" class="text-orange-500 w-10 h-10 mb-2"></i>
        <span class="font-medium text-gray-700">Footer Settings</span>
      </a>
    </div>
  </div>

  <!-- Recent Products -->
  <div class="bg-white p-8 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="clock" class="text-orange-500 w-6 h-6 mr-2"></i> Recent Products
    </h2>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-orange-50">
          <tr>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Image</th>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Name</th>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Material</th>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Industry</th>
            <th class="px-6 py-3 text-center text-gray-700 font-semibold border-b">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if ($recentProducts->num_rows > 0): ?>
            <?php while($product = $recentProducts->fetch_assoc()): ?>
              <tr class="hover:bg-orange-50">
                <td class="px-6 py-3">
                  <img src="../<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-16 h-16 object-cover rounded-lg border">
                </td>
                <td class="px-6 py-3 font-medium text-gray-800"><?= htmlspecialchars($product['name']) ?></td>
                <td class="px-6 py-3 text-gray-600"><?= htmlspecialchars($product['material_name'] ?: '-') ?></td>
                <td class="px-6 py-3 text-gray-600"><?= htmlspecialchars($product['industry_name'] ?: '-') ?></td>
                <td class="px-6 py-3 text-center">
                  <a href="edit-product.php?id=<?= $product['id'] ?>" class="text-orange-600 hover:text-orange-800 font-semibold">Edit</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center py-6 text-gray-500">No products found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>

<!-- Footer -->
<footer class="bg-gray-800 text-gray-300 text-center py-4 mt
