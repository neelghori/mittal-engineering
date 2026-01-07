<?php
include 'config.php';
include 'header.php';

// Secure helper for queries
function safeQuery($conn, $sql) {
    $result = $conn->query($sql);
    if (!$result) {
        error_log("SQL Error: " . $conn->error);
        return [];
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Fetch Materials
$materials = safeQuery($conn, "SELECT * FROM materials ORDER BY name ASC");

// Fetch Industries
$industries = safeQuery($conn, "SELECT * FROM industries ORDER BY name ASC");

// Move 'Agriculture' to end if exists
foreach ($industries as $key => $industry) {
    if (strtolower(trim($industry['name'])) === 'agriculture') {
        $agricultureIndustry = $industry;
        unset($industries[$key]);
        $industries[] = $agricultureIndustry;
        break;
    }
}

// Fetch Products by Material
$productsByMaterial = [];
$result = $conn->query("SELECT * FROM products WHERE material_id IS NOT NULL ORDER BY name ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $productsByMaterial[$row['material_id']][] = $row;
    }
}

// Fetch Products by Industry
$productsByIndustry = [];
$result = $conn->query("SELECT * FROM products WHERE industry_id IS NOT NULL ORDER BY name ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $productsByIndustry[$row['industry_id']][] = $row;
    }
}

// Fetch all products
$allProducts = safeQuery($conn, "SELECT id, name, description, image_url FROM products ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MetalCraft Marvels | Industrial Metal Solutions</title>
<link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap');
body { font-family: 'Montserrat', sans-serif; background-color: #0a0a0a; color: #f9fafb; scroll-behavior: smooth; }

/* Custom Colors */
.bg-primary-900 { background-color: #1a1a1a; }
.bg-primary-800 { background-color: #2d2d2d; }
.bg-primary-700 { background-color: #404040; }
.bg-secondary-500 { background-color: #f97316; }
.bg-secondary-600 { background-color: #ea580c; }
.text-primary-50 { color: #f9fafb; }
.text-primary-300 { color: #d1d5db; }
.text-secondary-400 { color: #fb923c; }
.text-secondary-500 { color: #f97316; }

/* Hero Section */
.hero-gradient {
    position: relative;
    overflow: hidden;
    border-bottom: 3px solid #f97316;
    background: 
        linear-gradient(135deg, rgba(26, 26, 26, 0.8), rgba(10, 10, 10, 0.9)),
        url('uploads/products.jpeg') center/cover no-repeat;
}
.hero-content { 
    position: relative; 
    z-index: 10; 
    opacity: 0; 
    transform: translateY(40px); 
    animation: fadeUp 1s ease-out forwards; 
}

/* Animations */
@keyframes fadeUp { 0% {opacity: 0; transform: translateY(40px);} 100% {opacity: 1; transform: translateY(0);} }
@keyframes fadeIn { 0% {opacity: 0;} 100% {opacity: 1;} }
@keyframes slideIn { 0% {opacity: 0; transform: translateY(40px);} 100% {opacity: 1; transform: translateY(0);} }

.fade-in { animation: fadeIn 1s ease-in-out; }
.fade-up { animation: fadeUp 0.9s ease-out forwards; }
.slide-up { animation: slideIn 1s ease-out forwards; }

/* Product Cards */
.product-card { transition: all 0.4s ease; cursor: pointer; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.3); min-height: 20rem; background-color: #2d2d2d; border: 1px solid #404040; opacity: 0; transform: translateY(30px); }
.product-card.visible { opacity: 1; transform: translateY(0); transition: all 0.8s ease-out; }
.product-card:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 15px 35px -5px rgba(251,146,60,0.35); border-color: #fb923c; }

/* Tabs */
.tab-active:after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background: #f97316; transition: all 0.3s ease; }

/* Vanta Globe */
#vanta-globe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; opacity: 0.2; }

/* Sparkle Animation */
@keyframes sparkle { 0% {opacity:0;transform:scale(0.5);}50%{opacity:1;transform:scale(1.2);}100%{opacity:0;transform:scale(0.5);} }
.sparkle { position:absolute; background: rgba(251,146,60,0.8); border-radius:50%; pointer-events:none; animation: sparkle 1s ease-out forwards; }
</style>
</head>
<body class="bg-primary-900 text-primary-50">
<div id="vanta-globe"></div>

<!-- Hero -->
<section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 hero-gradient relative">
<div class="max-w-7xl mx-auto text-center hero-content">
<h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight">
<span class="block text-primary-50 text-3xl sm:text-4xl lg:text-5xl fade-up">Precision Engineered</span>
<span class="block text-secondary-400 mt-2 text-4xl sm:text-5xl lg:text-6xl fade-up" style="animation-delay:0.3s;">METAL SOLUTIONS</span>
</h1>
<p class="text-lg sm:text-xl text-primary-300 mb-8 max-w-4xl mx-auto font-light fade-up" style="animation-delay:0.6s;">
Forged from the finest alloys to meet the most demanding industrial applications. Explore our catalog of premium metal components.
</p>
</div>
</section>

<!-- Tabs -->
<div class="bg-primary-800 sticky top-0 z-40 shadow-lg border-b border-primary-700 transition-all duration-500">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex overflow-x-auto">
    <button id="all-tab" class="tab-active px-6 py-4 text-lg text-secondary-500 whitespace-nowrap font-medium transition duration-300 hover:bg-primary-700/50 relative"><i data-feather="grid" class="inline mr-2 w-5 h-5"></i> All Products</button>
    <button id="material-tab" class="px-6 py-4 text-lg text-primary-300 hover:text-secondary-500 whitespace-nowrap font-medium transition duration-300 hover:bg-primary-700/50 relative"><i data-feather="layers" class="inline mr-2 w-5 h-5"></i> Browse by Material</button>
    <button id="industry-tab" class="px-6 py-4 text-lg text-primary-300 hover:text-secondary-500 whitespace-nowrap font-medium transition duration-300 hover:bg-primary-700/50 relative"><i data-feather="briefcase" class="inline mr-2 w-5 h-5"></i> Browse by Industry</button>
</div>
</div>
</div>

<!-- Material Section -->
<section id="material-products" class="py-16 px-4 sm:px-6 lg:px-8 fade-in hidden">
<div class="max-w-7xl mx-auto">
<?php foreach ($materials as $material): ?>
<div class="mb-20 fade-up">
<div class="flex items-center mb-8 pb-4 border-b border-primary-700/30">
<div class="bg-secondary-500 p-3 rounded-md mr-4 flex-shrink-0 shadow-lg">
<i data-feather="<?= htmlspecialchars($material['icon'] ?: 'layers') ?>" class="text-primary-900 w-6 h-6"></i>
</div>
<h2 class="text-3xl font-bold text-primary-50 tracking-wide"><?= htmlspecialchars($material['name']) ?> Components</h2>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
<?php if (isset($productsByMaterial[$material['id']])): ?>
<?php foreach ($productsByMaterial[$material['id']] as $product): ?>
<div onclick="window.location.href='product-detail.php?id=<?= intval($product['id']) ?>'" class="product-card rounded-xl p-6 flex flex-col justify-between">
<div class="flex flex-col">
<img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-48 object-cover object-center rounded-lg mb-4 border border-primary-700/30">
<h3 class="text-lg font-bold text-secondary-400 mb-2 leading-snug"><?= htmlspecialchars($product['name']) ?></h3>
<p class="text-primary-300 text-sm mt-2 flex-grow"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
</div>
<button class="mt-4 text-sm font-semibold text-secondary-400 hover:text-secondary-500 flex items-center transition duration-300 self-start">
Learn More <i data-feather="chevrons-right" class="ml-1 h-4 w-4"></i>
</button>
</div>
<?php endforeach; ?>
<?php else: ?>
<p class="text-primary-300 italic col-span-full">No products listed for <?= htmlspecialchars($material['name']) ?>.</p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</section>

<!-- Industry Section -->
<section id="industry-products" class="py-16 px-4 sm:px-6 lg:px-8 bg-primary-900 hidden fade-in">
<div class="max-w-7xl mx-auto">
<?php foreach ($industries as $industry): ?>
<div class="mb-20 fade-up">
<div class="flex items-center mb-8 pb-4 border-b border-primary-700/30">
<div class="bg-secondary-500 p-3 rounded-md mr-4 flex-shrink-0 shadow-lg">
<i data-feather="<?= htmlspecialchars($industry['icon'] ?: 'briefcase') ?>" class="text-primary-900 w-6 h-6"></i>
</div>
<h2 class="text-3xl font-bold text-primary-50 tracking-wide"><?= htmlspecialchars($industry['name']) ?> Solutions</h2>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
<?php if (isset($productsByIndustry[$industry['id']])): ?>
<?php foreach ($productsByIndustry[$industry['id']] as $product): ?>
<div onclick="window.location.href='product-detail.php?id=<?= intval($product['id']) ?>'" class="product-card rounded-xl p-6 flex flex-col justify-between">
<div class="flex flex-col">
<img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-48 object-cover object-center rounded-lg mb-4 border border-primary-700/30">
<h3 class="text-lg font-bold text-secondary-400 mb-2 leading-snug"><?= htmlspecialchars($product['name']) ?></h3>
<p class="text-primary-300 text-sm mt-2 flex-grow"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
</div>
<button class="mt-4 text-sm font-semibold text-secondary-400 hover:text-secondary-500 flex items-center transition duration-300 self-start">
Learn More <i data-feather="chevrons-right" class="ml-1 h-4 w-4"></i>
</button>
</div>
<?php endforeach; ?>
<?php else: ?>
<p class="text-primary-300 italic col-span-full">No products listed for <?= htmlspecialchars($industry['name']) ?>.</p>
<?php endif; ?>
</div>
</div>
<?php endforeach; ?>
</div>
</section>

<!-- All Products Section -->
<section id="all-products" class="py-16 px-4 sm:px-6 lg:px-8 bg-primary-900 fade-in">
<div class="max-w-7xl mx-auto">
<div class="flex items-center mb-8 pb-4 border-b border-primary-700/30">
<div class="bg-secondary-500 p-3 rounded-md mr-4 flex-shrink-0 shadow-lg">
<i data-feather="grid" class="text-primary-900 w-6 h-6"></i>
</div>
<h2 class="text-3xl font-bold text-primary-50 tracking-wide">All Products</h2>
</div>
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
<?php if (!empty($allProducts)): ?>
<?php foreach ($allProducts as $product): ?>
<div onclick="window.location.href='product-detail.php?id=<?= intval($product['id']) ?>'" class="product-card rounded-xl overflow-hidden">
<img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-48 object-cover object-center">
<div class="p-4 text-center bg-primary-800">
<h3 class="text-sm sm:text-base font-semibold text-secondary-400 truncate"><?= htmlspecialchars($product['name']) ?></h3>
</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<p class="text-primary-300 italic col-span-full text-center">No products available.</p>
<?php endif; ?>
</div>
</div>
</section>

<?php include 'footer.php'; ?>

<script>
feather.replace();

// VANTA Globe
VANTA.GLOBE({
    el: "#vanta-globe",
    mouseControls: true,
    touchControls: true,
    gyroControls: false,
    scale: 1.00,
    scaleMobile: 1.00,
    color: 0xf97316,
    backgroundColor: 0x0,
    size: 0.8
});

// Tabs
const materialTab = document.getElementById('material-tab');
const industryTab = document.getElementById('industry-tab');
const allTab = document.getElementById('all-tab');
const materialProducts = document.getElementById('material-products');
const industryProducts = document.getElementById('industry-products');
const allProducts = document.getElementById('all-products');

function activateTab(tab, section) {
    [materialTab, industryTab, allTab].forEach(t => t.classList.remove('tab-active','text-secondary-500'));
    [materialProducts, industryProducts, allProducts].forEach(s => s.classList.add('hidden'));
    tab.classList.add('tab-active','text-secondary-500');
    section.classList.remove('hidden');
    section.classList.add('fade-in');
}

materialTab.addEventListener('click', () => activateTab(materialTab, materialProducts));
industryTab.addEventListener('click', () => activateTab(industryTab, industryProducts));
allTab.addEventListener('click', () => activateTab(allTab, allProducts));

// Fade in cards on scroll
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
    });
});
document.querySelectorAll('.product-card').forEach(card => observer.observe(card));

// Sparkle click effect
document.addEventListener('click', e => {
    const sparkle = document.createElement('div');
    sparkle.className = 'sparkle';
    sparkle.style.left = `${e.clientX}px`;
    sparkle.style.top = `${e.clientY}px`;
    document.body.appendChild(sparkle);
    setTimeout(() => sparkle.remove(), 1000);
});
</script>
</body>
</html>
