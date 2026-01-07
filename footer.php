<?php
include 'config.php';

// Fetch footer settings from database
$sql = "SELECT * FROM footer_settings LIMIT 1";
$result = $conn->query($sql);
$footer = $result->fetch_assoc();
?>

<footer class="relative bg-gray-900 border-t border-gray-800">
  <div id="vanta-bg" class="absolute inset-0 -z-10"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

      <!-- Company Info -->
      <div>
        <h3 class="text-xl font-bold text-orange-500 mb-4">
          <?= htmlspecialchars($footer['company_name']) ?>
        </h3>
        <p class="text-gray-400 text-sm">
          <?= htmlspecialchars($footer['description']) ?>
        </p>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="index.php" class="text-gray-400 hover:text-orange-500 transition-colors text-sm">Home</a></li>
          <li><a href="products.php" class="text-gray-400 hover:text-orange-500 transition-colors text-sm">Materials</a></li>
          <li><a href="products.php" class="text-gray-400 hover:text-orange-500 transition-colors text-sm">Industries</a></li>
          <li><a href="capabilities.php" class="text-gray-400 hover:text-orange-500 transition-colors text-sm">Capabilities</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Contact</h4>
        <ul class="space-y-2 text-gray-400 text-sm">
          <li><?= htmlspecialchars($footer['address']) ?></li>
          <li>Phone: <?= htmlspecialchars($footer['phone1']) ?></li>
          <li>Phone: <?= htmlspecialchars($footer['phone2']) ?></li>
          <li>Email: 
            <a href="mailto:<?= htmlspecialchars($footer['email']) ?>" class="hover:text-orange-500 transition-colors">
              <?= htmlspecialchars($footer['email']) ?>
            </a>
          </li>
        </ul>
      </div>

      <!-- Social & Certifications -->
      <div>
        <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Follow Us</h4>
        <div class="flex space-x-4 mb-6">
          <a href="<?= htmlspecialchars($footer['facebook']) ?>" target="_blank" class="text-gray-400 hover:text-orange-500 transition-colors"><i data-feather="facebook" class="w-5 h-5"></i></a>
          <a href="<?= htmlspecialchars($footer['linkedin']) ?>" target="_blank" class="text-gray-400 hover:text-orange-500 transition-colors"><i data-feather="linkedin" class="w-5 h-5"></i></a>
          <a href="<?= htmlspecialchars($footer['instagram']) ?>" target="_blank" class="text-gray-400 hover:text-orange-500 transition-colors"><i data-feather="instagram" class="w-5 h-5"></i></a>
        </div>

        <h4 class="text-sm font-semibold text-gray-300 uppercase tracking-wider mb-4">Certifications</h4>
        <div class="flex space-x-2">
          <div class="bg-gray-800 rounded p-2 hover:bg-orange-600 transition-colors"><i data-feather="award" class="text-orange-500 w-5 h-5"></i></div>
          <div class="bg-gray-800 rounded p-2 hover:bg-orange-600 transition-colors"><i data-feather="check-circle" class="text-orange-500 w-5 h-5"></i></div>
          <div class="bg-gray-800 rounded p-2 hover:bg-orange-600 transition-colors"><i data-feather="shield" class="text-orange-500 w-5 h-5"></i></div>
        </div>
      </div>

    </div>

    <div class="mt-12 pt-8 border-t border-gray-800 text-center">
      <p class="text-gray-500 text-xs">
        &copy; <?= date('Y') ?> <?= htmlspecialchars($footer['company_name']) ?>. All rights reserved. | Precision Metal Components Manufacturer
      </p>
    </div>
  </div>

  <script>
    feather.replace();
  </script>
</footer>
