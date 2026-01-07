<?php
include 'header.php';
?>

<!-- AOS Animations -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
  html { scroll-behavior: smooth; }
  .glow-text {
    text-shadow: 0 0 10px rgba(255, 159, 28, 0.6);
  }
</style>

<main class="pt-20 bg-industrial-950 text-white">

  <!-- Hero Section -->
  <section class="relative flex items-center justify-center h-[550px] overflow-hidden" data-aos="fade-up">
    <img src="uploads\aboutus.png" 
         alt="Precision metalwork background"
         class="absolute inset-0 w-full h-full object-cover opacity-40" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-br from-industrial-950/80 via-industrial-900/75 to-industrial-800/70"></div>

    <div class="relative z-10 text-center px-6" data-aos="zoom-in" data-aos-delay="200">
      <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight tracking-tighter glow-text">
        <span class="block text-molten-400">Forged by Heritage,</span>
        <span class="block text-white">Driven by Precision</span>
      </h1>
      <p class="text-xl md:text-2xl max-w-3xl mx-auto text-industrial-200 font-light tracking-wide">
        Since 1991, Kanchava Brass Components has blended <span class="text-molten-400 font-medium">craftsmanship</span>
        with <span class="text-molten-400 font-medium">cutting-edge engineering</span> to redefine precision.
      </p>
    </div>
  </section>

  <!-- Journey Section -->
  <section class="py-24 px-6 lg:px-8 max-w-7xl mx-auto" data-aos="fade-up">
    <div class="grid md:grid-cols-2 gap-16 items-center">
      <div class="relative" data-aos="fade-right" data-aos-delay="100">
        <img src="uploads\about.jpeg"
             alt="Fusion of heritage and modern engineering"
             loading="lazy"
             class="rounded-xl shadow-2xl w-full h-auto object-cover border border-industrial-700/60 transform rotate-1 hover:rotate-0 transition-transform duration-500">
        <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-molten-500/40 rounded-lg -z-10 blur-sm"></div>
      </div>
      <div data-aos="fade-left" data-aos-delay="200">
        <span class="text-molten-400 text-sm font-semibold uppercase tracking-widest mb-2 block">Our Foundation</span>
        <h2 class="text-4xl font-bold mb-6 tracking-tight">Our Journey Since 1991</h2>
        <p class="text-industrial-300 mb-6 leading-relaxed text-lg tracking-wide">
          From a small workshop in Jamnagar to a global supplier of precision metal parts, we’ve grown through relentless 
          <span class="text-molten-400 font-medium">innovation</span> and a deep respect for <span class="text-molten-400 font-medium">craftsmanship</span>.
        </p>
        <p class="text-industrial-300 leading-relaxed text-lg tracking-wide">
          Each component tells a story — of accuracy, reliability, and decades of trust from industries worldwide.
        </p>
        <a href="#timeline"
           class="mt-8 inline-flex items-center text-molten-400 hover:text-molten-300 font-semibold transition duration-300 tracking-wide">
          Explore Our Journey <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- Company Timeline -->
  <section id="timeline" class="py-24 px-6 bg-industrial-900" data-aos="fade-up">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold mb-4">Milestones of Excellence</h2>
      <p class="text-industrial-300 max-w-3xl mx-auto">Our timeline reflects a legacy of precision, innovation, and growth.</p>
    </div>
    <div class="relative border-l border-industrial-700 max-w-3xl mx-auto space-y-12">
      <?php
      $timeline = [
        ['year' => '1991', 'text' => 'Kanchava Brass Components was founded with a focus on custom brass fittings.'],
        ['year' => '2000', 'text' => 'Expanded production with semi-automated machining and quality inspection.'],
        ['year' => '2010', 'text' => 'Introduced full CNC automation and export partnerships across Asia & Europe.'],
        ['year' => '2020', 'text' => 'Became a global supplier of multi-metal precision components for diverse industries.']
      ];
      foreach ($timeline as $i => $event): ?>
        <div class="relative pl-10" data-aos="fade-right" data-aos-delay="<?= ($i+1)*100 ?>">
          <div class="absolute left-0 top-1.5 w-4 h-4 bg-molten-400 rounded-full"></div>
          <h3 class="text-2xl font-semibold text-white"><?= $event['year'] ?></h3>
          <p class="text-industrial-300"><?= $event['text'] ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Mission & Values -->
  <section id="mission-values" class="py-24 px-6 bg-industrial-950" data-aos="fade-up">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold mb-4">Our Core Values</h2>
      <p class="text-industrial-300 max-w-3xl mx-auto">
        Every weld, every cut, and every decision is driven by our principles of precision and partnership.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
      <?php
      $values = [
        ['icon'=>'award', 'title'=>'Quality Excellence', 'desc'=>'We hold every component to the highest precision and durability standards.'],
        ['icon'=>'cpu', 'title'=>'Technological Edge', 'desc'=>'Investing continuously in advanced CNC and automation systems.'],
        ['icon'=>'users', 'title'=>'Partnership & Trust', 'desc'=>'We work alongside clients as long-term engineering allies.']
      ];
      foreach ($values as $i => $v): ?>
      <div class="text-center p-8 rounded-xl bg-industrial-900/60 border border-industrial-800 hover:border-molten-400/40 hover:shadow-lg hover:shadow-molten-500/20 transition-transform duration-500 hover:scale-105" data-aos="fade-up" data-aos-delay="<?= ($i+1)*150 ?>">
        <div class="bg-molten-500/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5">
          <i data-feather="<?= $v['icon'] ?>" class="text-molten-400 w-8 h-8"></i>
        </div>
        <h3 class="text-xl font-semibold mb-3"><?= $v['title'] ?></h3>
        <p class="text-industrial-300"><?= $v['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-24 px-6 bg-industrial-900 text-center" data-aos="zoom-in">
    <h2 class="text-4xl font-bold mb-10">Our Global Impact</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-10 max-w-5xl mx-auto">
      <?php
      $stats = [
        ['num'=>'10+', 'label'=>'Years of Experience'],
        ['num'=>'50+', 'label'=>'Satisfied Clients'],
        ['num'=>'1M+', 'label'=>'Precision Components Delivered'],
        ['num'=>'7+', 'label'=>'Industries Served']
      ];
      foreach ($stats as $s): ?>
      <div class="bg-industrial-800/70 rounded-xl p-6 border border-industrial-700 hover:scale-105 transition-transform duration-500">
        <div class="text-4xl font-extrabold text-molten-400 mb-2"><?= $s['num'] ?></div>
        <div class="text-industrial-300 font-medium"><?= $s['label'] ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-24 px-6 bg-gradient-to-r from-molten-500 via-molten-600 to-molten-700 text-center relative overflow-hidden" data-aos="zoom-in">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/metal-grid.png')] opacity-10"></div>
    <div class="max-w-4xl mx-auto relative z-10">
      <h2 class="text-4xl font-bold mb-6 text-white">Let’s Build the Future of Precision Together</h2>
      <p class="text-white/90 mb-10 text-lg max-w-2xl mx-auto">
        Partner with Kanchava Brass Components to engineer the next generation of high-performance solutions.
      </p>
      <a href="contact.php"
         class="bg-industrial-900 hover:bg-industrial-800 text-white px-10 py-4 rounded-xl font-semibold shadow-lg shadow-industrial-900/30 transition-transform transform hover:scale-105 inline-flex items-center">
        Start a Conversation <i data-feather="send" class="ml-3 w-5 h-5"></i>
      </a>
    </div>
  </section>

  <!-- Internal Footer -->
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
          <li><a href="admin\admin-dashboard.php" class="text-gray-400 hover:text-orange-500 transition-colors text-sm">Employee Login</a></li>
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


</main>

<!-- Scripts -->
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  feather.replace();
  AOS.init({
    duration: 1000,
    easing: 'ease-in-out',
    once: true,
    offset: 100
  });
});
</script>
