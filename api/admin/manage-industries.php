<?php
require_once __DIR__ . '/../config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Admin check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// Initialize variables
$id = $name = $icon = $description = "";
$name_err = "";

// Add/Edit submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = !empty($_POST['id']) ? intval($_POST['id']) : 0;
    $name = trim($_POST['name']);
    $icon = !empty(trim($_POST['icon'])) ? trim($_POST['icon']) : NULL;
    $description = !empty(trim($_POST['description'])) ? trim($_POST['description']) : NULL;

    if (empty($name)) $name_err = "Please enter industry name.";

    if (empty($name_err)) {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE industries SET name=?, icon=?, description=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $icon, $description, $id);
            $stmt->execute();
            $stmt->close();
            $msg = "Industry updated successfully.";
        } else {
            $stmt = $conn->prepare("INSERT INTO industries (name, icon, description, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $name, $icon, $description);
            $stmt->execute();
            $stmt->close();
            $msg = "Industry added successfully.";
        }
        $id = $name = $icon = $description = "";
    }
}

// Delete industry
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM industries WHERE id=?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    $msg = "Industry deleted successfully.";
}

// Edit pre-fill
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM industries WHERE id=?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $icon = $row['icon'];
        $description = $row['description'];
    }
    $stmt->close();
}

// Fetch all industries
$result = $conn->query("SELECT * FROM industries ORDER BY created_at DESC");

// Count totals for dashboard cards
$industryCount = $conn->query("SELECT COUNT(*) as total FROM industries")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Industries | Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-50">
  <h1 class="text-2xl font-bold tracking-wide">Admin Dashboard</h1>
  <div class="flex items-center space-x-4">
    <a href="add-product.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">+ Add Product</a>
    <a href="manage-industries.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Manage Industries</a>
    <a href="admin-dashboard.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Dashboard</a>
    <a href="logout.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Logout</a>
  </div>
</header>

<main class="flex-grow p-6 max-w-7xl mx-auto">

  <!-- Stats Card -->
  <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow text-center">
      <i data-feather="briefcase" class="text-orange-500 w-10 h-10 mx-auto mb-2"></i>
      <h3 class="text-3xl font-bold"><?= $industryCount ?></h3>
      <p class="text-gray-600">Total Industries</p>
    </div>
  </div>

  <!-- Add/Edit Form -->
  <div class="bg-white p-8 rounded-xl shadow mb-10">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="plus-square" class="text-orange-500 w-6 h-6 mr-2"></i>
      <?= $id > 0 ? "Edit Industry" : "Add New Industry" ?>
    </h2>

    <?php if(isset($msg)) echo "<div class='text-green-600 mb-4'>{$msg}</div>"; ?>

    <form action="" method="post" class="space-y-4">
      <input type="hidden" name="id" value="<?= $id ?>">
      
      <div>
        <label class="block font-medium mb-1">Industry Name *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        <span class="text-red-600 text-sm"><?= $name_err ?></span>
      </div>

      <div>
        <label class="block font-medium mb-1">Icon (filename, e.g., car.svg)</label>
        <input type="text" name="icon" value="<?= htmlspecialchars($icon) ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      </div>

      <div>
        <label class="block font-medium mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"><?= htmlspecialchars($description) ?></textarea>
      </div>

      <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-orange-700 transition"><?= $id > 0 ? "Update Industry" : "Add Industry" ?></button>
    </form>
  </div>

  <!-- Industries Table -->
  <div class="bg-white p-8 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="briefcase" class="text-orange-500 w-6 h-6 mr-2"></i> All Industries
    </h2>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-orange-50">
          <tr>
            <th class="px-6 py-3 text-left font-semibold text-gray-700 border-b">ID</th>
            <th class="px-6 py-3 text-left font-semibold text-gray-700 border-b">Name</th>
            <th class="px-6 py-3 text-left font-semibold text-gray-700 border-b">Icon</th>
            <th class="px-6 py-3 text-left font-semibold text-gray-700 border-b">Description</th>
            <th class="px-6 py-3 text-left font-semibold text-gray-700 border-b">Created At</th>
            <th class="px-6 py-3 text-center font-semibold text-gray-700 border-b">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-orange-50">
                <td class="px-6 py-3"><?= $row['id'] ?></td>
                <td class="px-6 py-3 font-medium text-gray-800"><?= htmlspecialchars($row['name']) ?></td>
                <td class="px-6 py-3 text-gray-600"><?= $row['icon'] ?: '-' ?></td>
                <td class="px-6 py-3 text-gray-600"><?= $row['description'] ?: '-' ?></td>
                <td class="px-6 py-3 text-gray-600"><?= $row['created_at'] ?></td>
                <td class="px-6 py-3 text-center">
                  <a href="?edit_id=<?= $row['id'] ?>" class="text-orange-600 font-semibold mr-3 hover:text-orange-800">Edit</a>
                  <a href="?delete_id=<?= $row['id'] ?>" class="text-red-600 font-semibold hover:text-red-800" onclick="return confirm('Are you sure to delete?')">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="text-center py-6 text-gray-500">No industries found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>

<script>
  feather.replace()
</script>
</body>
</html>
