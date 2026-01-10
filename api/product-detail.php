<?php
include 'config.php'; // Database connection

// Check if product ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = intval($_GET['id']);

// Fetch product details
$stmt = $conn->prepare("SELECT p.*, m.name AS material_name, i.name AS industry_name
                        FROM products p
                        LEFT JOIN materials m ON p.material_id = m.id
                        LEFT JOIN industries i ON p.industry_id = i.id
                        WHERE p.id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if(!$product) {
    echo "Product not found!";
    exit;
}
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($product['name']) ?> | MetalCraft Masters</title>
<link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap');
body { 
    font-family: 'Montserrat', sans-serif; 
    background-color: #1f2937; 
    color: #f9fafb; 
    overflow-x: hidden;
}

/* Buttons */
.btn {
    display: inline-block;
    background-color: #f97316;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
    text-decoration: none;
}
.btn:hover {
    background-color: #ea580c;
    transform: translateY(-3px) scale(1.03);
}

/* Tags */
.product-tags span {
    background-color: #374151;
    color: #f97316;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}
.product-tags span:hover {
    background-color: #4b5563;
    transform: translateY(-2px);
}

/* Scroll animations */
.fade-up {
  opacity: 0;
  transform: translateY(40px);
  transition: all 0.8s ease-out;
}
.fade-up.show {
  opacity: 1;
  transform: translateY(0);
}
</style>
</head>
<body class="overflow-x-hidden">



<!-- Product Detail Hero Section -->
<section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 hero-gradient relative overflow-hidden">
  <div class="max-w-6xl mx-auto bg-industrial-800 rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-700 hover:shadow-3xl hover:scale-[1.01]">
    <div class="md:flex md:space-x-8">

      <!-- Product Image -->
      <div class="md:w-1/2 w-full fade-up">
        <img src="<?= htmlspecialchars($product['image_url']) ?>" 
             alt="<?= htmlspecialchars($product['name']) ?>" 
             class="w-full h-full object-cover rounded-t-2xl md:rounded-l-2xl md:rounded-tr-none transition-transform duration-700 ease-out hover:scale-105">
      </div>

      <!-- Product Info -->
      <div class="md:w-1/2 w-full p-8 flex flex-col justify-between fade-up delay-200">
        <div>
          <h1 class="text-4xl md:text-5xl font-bold text-molten-400 mb-4"><?= htmlspecialchars($product['name']) ?></h1>
          <p class="text-industrial-200 mb-6 leading-relaxed"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

          <!-- Product Details -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-industrial-200 mb-6 fade-up delay-300">
            <?php if(!empty($product['price'])): ?>
              <div><span class="font-semibold">Price:</span> <?= htmlspecialchars($product['price']) ?></div>
            <?php endif; ?>
            <?php if(!empty($product['material_name'])): ?>
              <div><span class="font-semibold">Material:</span> <?= htmlspecialchars($product['material_name']) ?></div>
            <?php endif; ?>
            <?php if(!empty($product['industry_name'])): ?>
              <div><span class="font-semibold">Industry:</span> <?= htmlspecialchars($product['industry_name']) ?></div>
            <?php endif; ?>
          </div>

          <!-- Tags -->
          <div class="product-tags flex flex-wrap gap-2 mb-6 fade-up delay-400">
            <?php if(!empty($product['material_name'])): ?><span><?= htmlspecialchars($product['material_name']) ?></span><?php endif; ?>
            <?php if(!empty($product['industry_name'])): ?><span><?= htmlspecialchars($product['industry_name']) ?></span><?php endif; ?>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex flex-wrap gap-4 fade-up delay-500">
          <a href="products.php" class="btn bg-industrial-700 hover:bg-industrial-600">Back to Products</a>
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=kanchavabrasscomponents@gmail.com&su=Product Inquiry: <?= urlencode($product['name']); ?>" target="_blank" class="btn">Request Inquiry</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<script>
feather.replace();

// Scroll animation observer
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.15 });

document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>
</body>
</html>
