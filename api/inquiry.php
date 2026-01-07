<?php
include 'header.php';
include 'config.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
?>

<section class="pt-32 pb-16 px-4 sm:px-6 lg:px-8 hero-gradient relative overflow-hidden">
  <div class="max-w-4xl mx-auto text-center">
    <h1 class="text-4xl font-bold mb-4 text-industrial-50">Inquiry Form</h1>
    <p class="text-industrial-200 mb-8">Request more details or a quote for this product.</p>
  </div>

  <form action="inquiry_submit.php" method="POST" class="max-w-2xl mx-auto bg-industrial-700/80 rounded-xl p-8 shadow-lg border border-industrial-600/50 space-y-6">
    <input type="hidden" name="product_id" value="<?= $product_id ?>">
    <div>
      <label class="block text-industrial-200 mb-2">Your Name</label>
      <input type="text" name="name" required class="w-full px-4 py-2 rounded-md bg-industrial-900 text-industrial-50 border border-industrial-600">
    </div>
    <div>
      <label class="block text-industrial-200 mb-2">Email</label>
      <input type="email" name="email" required class="w-full px-4 py-2 rounded-md bg-industrial-900 text-industrial-50 border border-industrial-600">
    </div>
    <div>
      <label class="block text-industrial-200 mb-2">Message</label>
      <textarea name="message" rows="4" class="w-full px-4 py-2 rounded-md bg-industrial-900 text-industrial-50 border border-industrial-600" placeholder="Your message"></textarea>
    </div>
    <button type="submit" class="bg-molten-500 hover:bg-molten-600 text-white px-6 py-3 rounded-md font-medium transition duration-300">Send Inquiry</button>
  </form>
</section>

<?php include 'footer.php'; ?>

