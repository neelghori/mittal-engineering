<?php
session_start();
include '../config.php';

// ✅ Admin access check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin-login.php");
    exit;
}

// Handle Add Material
if (isset($_POST['add_material'])) {
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO materials (name, icon, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $icon, $description);
    $stmt->execute();
    $stmt->close();

    header("Location: manage-materials.php");
    exit;
}

// Handle Edit Material
if (isset($_POST['edit_material'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE materials SET name=?, icon=?, description=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $icon, $description, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage-materials.php");
    exit;
}

// Handle Delete Material
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM materials WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage-materials.php");
    exit;
}

// Fetch all materials
$result = $conn->query("SELECT * FROM materials ORDER BY id DESC");
$materialCount = $conn->query("SELECT COUNT(*) as total FROM materials")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Materials | Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-orange-600 text-white px-6 py-4 flex justify-between items-center shadow-md sticky top-0 z-50">
  <h1 class="text-2xl font-bold tracking-wide">Manage Materials</h1>
  <div class="flex items-center space-x-4">
    <a href="dashboard.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Dashboard</a>
    <a href="logout.php" class="bg-white text-orange-600 px-4 py-2 rounded-lg font-semibold hover:bg-orange-50 transition">Logout</a>
  </div>
</header>

<main class="flex-grow p-6 max-w-7xl mx-auto">

  <!-- Stats Card -->
  <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition text-center">
      <i data-feather="layers" class="text-orange-500 w-10 h-10 mx-auto mb-2"></i>
      <h3 class="text-3xl font-bold"><?= $materialCount ?></h3>
      <p class="text-gray-600">Total Materials</p>
    </div>
  </div>

  <!-- Add Material Form -->
  <div class="bg-white p-8 rounded-xl shadow mb-10">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="plus-square" class="text-orange-500 w-6 h-6 mr-2"></i> Add New Material
    </h2>
    <form method="post" class="space-y-4">
      <input type="text" name="name" placeholder="Material Name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      <input type="text" name="icon" placeholder="Icon (filename or URL)" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      <textarea name="description" placeholder="Description" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
      <button type="submit" name="add_material" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">Add Material</button>
    </form>
  </div>

  <!-- Materials Table -->
  <div class="bg-white p-8 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="layers" class="text-orange-500 w-6 h-6 mr-2"></i> All Materials
    </h2>

    <div class="overflow-x-auto">
      <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
        <thead class="bg-orange-50">
          <tr>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">ID</th>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Name</th>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Icon</th>
            <th class="px-6 py-3 text-left text-gray-700 font-semibold border-b">Description</th>
            <th class="px-6 py-3 text-center text-gray-700 font-semibold border-b">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php if ($result->num_rows > 0): ?>
            <?php while($material = $result->fetch_assoc()): ?>
              <tr class="hover:bg-orange-50">
                <td class="px-6 py-3"><?= $material['id'] ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($material['name']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($material['icon']) ?></td>
                <td class="px-6 py-3"><?= htmlspecialchars($material['description']) ?></td>
                <td class="px-6 py-3 text-center space-x-2">
                  <button onclick="editMaterial(<?= $material['id'] ?>, '<?= htmlspecialchars(addslashes($material['name'])) ?>', '<?= htmlspecialchars(addslashes($material['icon'])) ?>', '<?= htmlspecialchars(addslashes($material['description'])) ?>')" class="text-orange-600 hover:text-orange-800 font-semibold">Edit</button>
                  <a href="?delete=<?= $material['id'] ?>" onclick="return confirm('Delete this material?')" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center py-6 text-gray-500">No materials found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Edit Material Form -->
  <div class="bg-white p-8 rounded-xl shadow mt-10 mb-10">
    <h2 class="text-xl font-bold mb-6 flex items-center">
      <i data-feather="edit" class="text-orange-500 w-6 h-6 mr-2"></i> Edit Material
    </h2>
    <form method="post" id="editForm" class="space-y-4">
      <input type="hidden" name="id" id="edit_id">
      <input type="text" name="name" id="edit_name" placeholder="Material Name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400" required>
      <input type="text" name="icon" id="edit_icon" placeholder="Icon (filename or URL)" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
      <textarea name="description" id="edit_description" placeholder="Description" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
      <button type="submit" name="edit_material" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">Update Material</button>
    </form>
  </div>

</main>

<!-- Footer -->
<footer class="bg-gray-800 text-gray-300 text-center py-4 mt-10">
  &copy; <?= date('Y') ?> Kanchva Brass Components. All rights reserved.
</footer>

<script>
  feather.replace();

  function editMaterial(id, name, icon, description) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_icon').value = icon;
    document.getElementById('edit_description').value = description;
    window.scrollTo({ top: document.getElementById('editForm').offsetTop - 20, behavior: 'smooth' });
  }
</script>

</body>
</html>
