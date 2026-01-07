<?php
include 'config.php';
include 'header.php';
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Capabilities | MetalCraft Masters</title>
  <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>/static/favicon.ico">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Smooth fade + slide animation */
    .fade-section {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 1s ease, transform 1s ease;
    }

    .fade-section.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* Hero parallax effect */
    .parallax {
      background-attachment: fixed;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* Smooth scroll */
    html {
      scroll-behavior: smooth;
    }

    /* Card hover animation */
    .capability-card {
      transition: all 0.5s ease;
    }

    .capability-card:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 10px 25px rgba(255, 166, 0, 0.15);
    }
  </style>
</head>

<body class="bg-industrial-900 text-industrial-100 overflow-x-hidden">

  <!-- Hero Section -->
  <section 
    class="relative flex items-center justify-center text-center text-white overflow-hidden fade-section min-h-[80vh] px-6 bg-industrial-900 parallax"
    style="background-image: url('<?php echo BASE_PATH; ?>/uploads/capabilities.png');">
    
    <div class="absolute inset-0 bg-industrial-900/70 backdrop-blur-sm"></div>

    <div class="relative z-10 max-w-5xl mx-auto hero-title transition-all duration-1000 ease-out">
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-4">
        <span class="block text-industrial-50">Our Core</span>
        <span class="block text-molten-400">Precision Capabilities</span>
      </h1>
      <p class="text-xl text-industrial-300 max-w-3xl mx-auto">
        We leverage state-of-the-art technology and deep engineering expertise to deliver superior metal components for any complex application.
      </p>
    </div>
  </section>

  <!-- Capabilities Section -->
  <section class="py-20 bg-industrial-950 fade-section">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-4xl font-bold text-molten-400 mb-12 transition duration-1000 ease-in-out">Our Manufacturing Capabilities</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <?php
        $capabilities = [
          ["CNC Machining", "High-precision turning, milling, and drilling with advanced CNC machines ensuring exact tolerances for every product."],
          ["Metal Forging", "Robust forging processes that produce durable, uniform, and stress-resistant components for all industrial needs."],
          ["Precision Casting", "Investment casting and die-casting for complex geometries with high dimensional accuracy and superior surface finish."],
          ["Surface Finishing", "High-quality electroplating, polishing, and coating processes that enhance corrosion resistance and aesthetic appeal."],
          ["Tool Design & Development", "In-house tool and die development for custom requirements, ensuring precision from design to final product."],
          ["Quality Inspection", "Stringent quality checks with CMM and advanced measuring systems ensuring every product meets ISO standards."]
        ];

        foreach ($capabilities as $cap) {
          echo "
          <div class='p-8 bg-industrial-800 rounded-2xl shadow-lg capability-card fade-section'>
            <h3 class='text-2xl font-semibold mb-4 text-industrial-50'>{$cap[0]}</h3>
            <p class='text-industrial-300'>{$cap[1]}</p>
          </div>";
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Fade-in + Parallax JS -->
  <script>
    // Fade-in animation
    const fadeSections = document.querySelectorAll('.fade-section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    fadeSections.forEach(section => observer.observe(section));

    // Parallax subtle zoom effect
    window.addEventListener('scroll', () => {
      const hero = document.querySelector('.parallax');
      const scrollPos = window.scrollY;
      hero.style.backgroundPositionY = `${scrollPos * 0.4}px`;
    });
  </script>

</body>

<?php include 'footer.php'; ?>
