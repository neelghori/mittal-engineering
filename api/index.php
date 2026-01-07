<?php
include 'header.php';
include 'config.php';

/**
 * Fetches items from a given table in a secure way.
 *
 * @param mysqli $conn The database connection object.
 * @param string $tableName The name of the table to fetch from.
 * @return array An array of items.
 */
function getItems($conn, $tableName) {
    $items = [];
    // SECURITY IMPROVEMENT: Using a prepared statement for the table name is NOT possible with standard MySQLi,
    // as table names cannot be bound as parameters. However, ensuring the $tableName is validated
    // against a whitelist of expected names (e.g., 'materials', 'industries', 'testimonials')
    // in a real application is crucial to prevent SQL injection.
    $valid_tables = ['materials', 'industries', 'testimonials'];
    if (!in_array($tableName, $valid_tables)) {
        error_log("Attempt to access invalid table: " . $tableName);
        return $items; // Return empty array for safety
    }
    
    // The original code is kept, but with the necessary security note above.
    $stmt = $conn->prepare("SELECT * FROM $tableName ORDER BY id ASC");
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $items = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare statement for table: " . $tableName);
    }
    return $items;
}

// Fetch data
$materials = getItems($conn, 'materials');
$industries = getItems($conn, 'industries');
$testimonials = getItems($conn, 'testimonials'); 
?>

<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<style>
  html {
    scroll-behavior: smooth;
  }
</style>
<section class="relative min-h-[90vh] flex items-center justify-center text-center text-white px-6 overflow-hidden" data-aos="fade-up">
  <div class="absolute inset-0">
    <img src="uploads/10.png" 
          alt="Precision machined brass, copper, and stainless steel components" 
          class="w-full h-full object-cover opacity-40">
    <div class="absolute inset-0 bg-gradient-to-br from-industrial-950/90 via-industrial-900/85 to-industrial-800/80"></div>
  </div>

  <div class="relative z-10 max-w-5xl mx-auto space-y-10" data-aos="zoom-in">
    <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
      <span class="block text-molten-400">Precision Metal</span>
      <span class="block text-white">Components Forged</span>
      <span class="block text-molten-400">To Perfection</span>
    </h1>
    <p class="text-lg md:text-xl text-industrial-200 max-w-2xl mx-auto">
      Crafting excellence in copper, brass, aluminum, stainless steel and more for industries that demand uncompromising quality.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="mailto:kanchavabrasscomponents@gmail.com?subject=Request%20Quote&body=Hello%20Team%20Kanchva" 
          target="_blank"
          class="bg-molten-500 hover:bg-molten-600 text-white px-10 py-5 rounded-lg font-semibold shadow-lg shadow-molten-500/40 transition-transform transform hover:scale-105 inline-flex items-center"
          aria-label="Request a custom quote for metal components">
        Request Quote <i data-feather="arrow-right" class="ml-2 w-6 h-6"></i>
      </a>
      <a href="#materials" 
          class="border border-molten-400 text-molten-400 hover:bg-molten-500/10 px-10 py-5 rounded-lg font-semibold transition-transform transform hover:scale-105 inline-flex items-center"
          aria-label="View our specialty materials list">
        Our Materials <i data-feather="layers" class="ml-2 w-6 h-6"></i>
      </a>
    </div>
  </div>
</section>

<section id="materials" class="py-24 px-6 bg-industrial-800 relative overflow-hidden" data-aos="fade-up">
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/metal-texture.png')] opacity-10"></div>
  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold text-white mb-4">Our Specialty Materials</h2>
      <p class="text-industrial-300 max-w-2xl mx-auto">
        We work with a wide range of metals to meet your exact specifications and industry requirements.
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8">
      <?php foreach ($materials as $key => $mat): 
          $name = strtolower(trim($mat['name']));
          $icon = match($name) {
              'brass' => 'settings',
              'copper' => 'zap',
              'aluminum' => 'wind',
              'stainless steel' => 'shield',
              'mild steel' => 'tool',
              'titanium' => 'cpu',
              default => 'box'
          };
      ?>
      <div 
        data-aos="fade-up" 
        data-aos-delay="<?= ($key + 1) * 100 ?>" 
        class="group bg-industrial-700/60 hover:bg-industrial-700 rounded-2xl p-8 text-center transition-all duration-500 border border-industrial-600/40 hover:border-molten-500/50 hover:shadow-lg hover:shadow-molten-500/20 hover:-translate-y-2 flex flex-col items-center justify-between min-h-[260px]"
      >
        <div class="flex flex-col items-center">
          <div class="w-20 h-20 bg-molten-900/20 rounded-full flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-500">
            <i data-feather="<?= $icon ?>" class="text-molten-400 w-10 h-10" aria-hidden="true"></i>
          </div>
          <h3 class="text-lg font-semibold text-molten-400 mb-2"><?= htmlspecialchars($mat['name']) ?></h3>
          <p class="text-sm text-industrial-300 leading-relaxed">
            <?= htmlspecialchars($mat['description']) ?>
          </p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section id="why-us" class="py-24 px-6 bg-industrial-950 text-white" data-aos="fade-up">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold mb-4">Why Choose Kanchava Brass Components?</h2>
      <p class="text-industrial-300 max-w-2xl mx-auto">
        Trusted by global industries for precision, reliability, and unmatched craftsmanship.
      </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
      <?php 
      $features = [
        ['icon'=>'award','title'=>'Unmatched Quality','desc'=>'We adhere to strict inspection and testing protocols to ensure every part meets international standards.'],
        ['icon'=>'settings','title'=>'Custom Manufacturing','desc'=>'Tailor-made solutions crafted exactly to your technical drawings, material specs, and tolerance levels.'],
        ['icon'=>'clock','title'=>'Timely Delivery','desc'=>'Our streamlined production and logistics ensure your orders are always delivered on schedule.'],
        ['icon'=>'globe','title'=>'Global Expertise','desc'=>'Serving clients across industries and continents with proven engineering precision and experience.']
      ];
      foreach ($features as $i => $f): ?>
      <div data-aos="fade-up" data-aos-delay="<?= ($i+1)*100 ?>" class="bg-industrial-800 p-8 rounded-xl border border-industrial-700 hover:border-molten-500/40 hover:shadow-lg hover:shadow-molten-500/20 transition-all duration-500">
        <div class="bg-molten-500/10 p-3 rounded-lg inline-block mb-4">
          <i data-feather="<?= $f['icon'] ?>" class="text-molten-400 w-8 h-8" aria-hidden="true"></i>
        </div>
        <h3 class="text-xl font-semibold mb-2"><?= $f['title'] ?></h3>
        <p class="text-industrial-300"><?= $f['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<section id="industries" class="py-24 px-6 bg-industrial-900 relative" data-aos="fade-up">
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/brushed-metal.png')] opacity-10"></div>
  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold text-white mb-4">Serving Diverse Industries</h2>
      <p class="text-industrial-300 max-w-2xl mx-auto">
        Our precision components power innovation across multiple sectors.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php foreach ($industries as $key => $ind): ?>
      <div data-aos="fade-up" data-aos-delay="<?= ($key + 1) * 100 ?>" class="bg-industrial-800/70 backdrop-blur-sm rounded-2xl p-8 border border-industrial-700/50 hover:border-molten-500/50 transition-all duration-500 hover:shadow-lg hover:shadow-molten-500/20 hover:scale-105">
        <div class="flex items-center mb-4">
          <div class="bg-molten-500/10 p-3 rounded-lg mr-4">
            <i data-feather="<?= htmlspecialchars($ind['icon']) ?>" class="text-molten-400 w-6 h-6" aria-hidden="true"></i>
          </div>
          <h3 class="text-xl font-semibold text-white"><?= htmlspecialchars($ind['name']) ?></h3>
        </div>
        <p class="text-industrial-300 leading-relaxed">
          <?php 
            $shortDesc = htmlspecialchars($ind['description'] ?: '-');
            if(strlen($shortDesc) > 70) $shortDesc = substr($shortDesc,0,70).'…';
            echo $shortDesc;
          ?>
        </p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php if (!empty($testimonials)): ?>
<section id="testimonials" class="py-24 px-6 bg-industrial-800 relative overflow-hidden" data-aos="fade-up">
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/metal-texture.png')] opacity-10"></div>
  <div class="max-w-5xl mx-auto relative z-10">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold text-white mb-4">What Our Clients Say</h2>
      <p class="text-industrial-300 max-w-2xl mx-auto">
        Building long-term partnerships through reliability and excellence.
      </p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <?php foreach ($testimonials as $testimonial): ?>
      <div class="bg-industrial-700/60 p-8 rounded-lg border border-industrial-600/40 relative transition-all duration-500 hover:shadow-lg hover:shadow-molten-500/20 hover:scale-[1.02]" data-aos="fade-up">
        <i data-feather="message-circle" class="text-molten-500/30 w-16 h-16 absolute top-4 right-4 -z-1" aria-hidden="true"></i>
        <blockquote class="text-industrial-200 mb-4 italic">
          "<?= htmlspecialchars($testimonial['quote']) ?>"
        </blockquote>
        <div class="font-semibold text-molten-400"><?= htmlspecialchars($testimonial['author']) ?></div>
        <div class="text-sm text-industrial-400"><?= htmlspecialchars($testimonial['company']) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>
<section id="brochure" class="py-24 px-6 bg-industrial-950 text-white relative overflow-hidden" data-aos="fade-up">
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/brushed-metal.png')] opacity-10"></div>
  <div class="max-w-7xl mx-auto relative z-10">
    <div class="text-center mb-16" data-aos="zoom-in">
      <h2 class="text-4xl font-bold text-white mb-4">Download Our Brochure</h2>
      <p class="text-industrial-300 max-w-2xl mx-auto">
        Explore our full range of precision metal components, materials, and services.
      </p>
    </div>
    <div class="flex flex-col md:flex-row justify-center items-center gap-8">
      <div class="bg-industrial-800/70 p-8 rounded-2xl border border-industrial-700/50 backdrop-blur-sm hover:shadow-lg hover:shadow-molten-500/20 hover:scale-105 transition-all duration-500 text-center w-full md:w-1/3" data-aos="fade-up">
        <i data-feather="file-text" class="text-molten-400 w-12 h-12 mx-auto mb-4" aria-hidden="true"></i>
        <h3 class="text-xl font-semibold text-white mb-2">Product Brochure</h3>
        <p class="text-industrial-300 mb-4">Comprehensive guide to our materials and services.</p>
        <a href="uploads/KBC Brochure.pdf" target="_blank" class="bg-molten-500 hover:bg-molten-600 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center transition-transform transform hover:scale-105">
          Download PDF <i data-feather="download" class="ml-2 w-5 h-5"></i>
        </a>
      </div>
    </div>
  </div>
</section>
<section class="py-24 px-6 bg-gradient-to-r from-molten-500 via-molten-600 to-molten-700 text-center relative overflow-hidden" data-aos="zoom-in">
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/metal-grid.png')] opacity-10"></div>
  <div class="max-w-4xl mx-auto relative z-10">
    <h2 class="text-4xl font-bold text-white mb-6">Ready to Start Your Project?</h2>
    <p class="text-white/90 mb-10 text-lg max-w-2xl mx-auto">
      Our team of experts is ready to bring your vision to life with precision craftsmanship and competitive pricing.
    </p>
    <div class="flex flex-wrap justify-center gap-4">
      <a href="mailto:kanchavabrasscomponents@gmail.com?subject=Request%20a%20Free%20Quote"
          class="bg-industrial-900 hover:bg-industrial-800 text-white px-10 py-4 rounded-xl font-semibold shadow-lg shadow-industrial-900/30 transition-transform transform hover:scale-105 inline-flex items-center"
          aria-label="Request a free custom manufacturing quote">
        Request a Free Quote <i data-feather="message-square" class="ml-3 w-5 h-5"></i>
      </a>
      <a href="tel:+91 9428051768" 
          class="bg-white hover:bg-industrial-50 text-industrial-900 px-10 py-4 rounded-xl font-semibold transition-transform transform hover:scale-105 inline-flex items-center"
          aria-label="Call Kanchava Brass Components experts">
        Call Our Experts <i data-feather="phone" class="ml-3 w-5 h-5"></i>
      </a>
    </div>
  </div>
</section>

<script src="https://unpkg.com/feather-icons"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  feather.replace();
  AOS.init({
    duration: 1000,
    easing: 'ease-in-out',
    once: true,
    offset: 100
  });
</script>

<?php include 'footer.php'; ?>