<?php
// header.php
$current_page = basename($_SERVER['PHP_SELF']);
$current_page = htmlspecialchars($current_page, ENT_QUOTES, 'UTF-8'); // Security sanitization

// Security headers (optional — use only if this is the main entry point)
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Kanchava Brass Components | Precision Brass Components</title>
  <meta name="description" content="Kanchava Brass Components manufactures high-quality precision brass parts for industrial, automotive, and electrical applications.">
  <meta name="keywords" content="brass components, brass fittings, precision brass, Kanchava, metalcraft, CNC turning, brass bushes">
  <meta name="robots" content="index, follow">

  <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/feather-icons"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            industrial: {
              50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',
              500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'
            },
            molten: {
              50:'#fff7ed',100:'#ffedd5',200:'#fed7aa',300:'#fdba74',400:'#fb923c',
              500:'#f97316',600:'#ea580c',700:'#c2410c',800:'#9a3412',900:'#7c2d12'
            }
          }
        }
      }
    };
  </script>

  <style>
    body { font-family: 'Montserrat', sans-serif; overflow-x: hidden; scroll-behavior: smooth; }
    .hover-scale { transition: transform 0.3s ease; }
    .hover-scale:hover { transform: scale(1.03); }

    @keyframes floating { 0%,100% { transform: translateY(0px);} 50% {transform: translateY(-10px);} }
    .floating { animation: floating 6s ease-in-out infinite; }

    .fade-up { opacity: 0; transform: translateY(20px); transition: all 0.8s ease; }
    .fade-up.show { opacity: 1; transform: translateY(0); }

    #nav-links a, #mobile-menu a {
      font-size: 1.1rem;
      font-weight: 500;
      letter-spacing: 0.5px;
    }
    
    /* * **CRITICAL RESPONSIVENESS FIX:** * Scale down the logo section on very small screens (phones) to prevent it 
     * from overlapping the mobile menu button positioned on the far right.
     */
    @media (max-width: 420px) {
        #logo-section .h-16 {
            height: 3.25rem; /* Reduce logo image height */
        }
        #logo-section .text-2xl {
            font-size: 1.15rem; /* Reduce main title size */
        }
        #logo-section .text-lg {
            font-size: 0.85rem; /* Reduce subtitle size */
        }
        /* Shift logo left slightly to accommodate space */
        #logo-section {
            left: 0.5rem; 
        }
        /* Shift menu button left slightly to accommodate space */
        .md\:hidden.absolute.right-4 {
            right: 0.5rem;
        }
    }
  </style>
</head>

<body class="bg-industrial-900 text-industrial-50 relative">
  <div id="vanta-bg" class="fixed inset-0 -z-10"></div>

  <nav id="navbar" class="bg-industrial-900/80 backdrop-blur-md border-b border-industrial-700 fixed w-full z-50">
    
    <div class="relative h-20 flex items-center justify-center max-w-7xl mx-auto">

      <div id="logo-section" class="absolute top-2 left-0 flex items-center space-x-3 pl-3 fade-up">
        <a href="index.php" aria-label="Kanchava Brass Components Home">
          <img src="uploads\kbclogo.png" alt="Kanchava Brass Components Logo" class="h-16 w-auto">
        </a>
        <div class="flex flex-col leading-tight">
          <a href="index.php" class="text-2xl font-bold text-molten-400 tracking-wide">KANCHAVA</a>
          <span class="text-lg font-semibold text-molten-400">BRASS COMPONENTS</span>
        </div>
      </div>

      <div id="nav-links" class="hidden md:flex items-center space-x-8 fade-up">
        <a href="index.php" class="<?= $current_page=='index.php' ? 'text-molten-400 border-b-2 border-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Home</a>
        <a href="about.php" class="<?= $current_page=='about.php' ? 'text-molten-400 border-b-2 border-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">About</a>
        <a href="products.php" class="<?= $current_page=='products.php' ? 'text-molten-400 border-b-2 border-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Products</a>
        <a href="capabilities.php" class="<?= $current_page=='capabilities.php' ? 'text-molten-400 border-b-2 border-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Capabilities</a>
        <a href="contact.php" class="<?= $current_page=='contact.php' ? 'text-molten-400 border-b-2 border-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Contact</a>
      </div>

      <div id="flag-section" class="hidden md:flex items-center absolute top-2 right-4 fade-up">
        <img src="uploads\giphy.gif" alt="India Flag" class="h-14 w-auto floating ml-4">
      </div>

      <div class="md:hidden absolute right-4 fade-up">
        <button id="mobile-menu-btn" aria-label="Toggle mobile menu" class="text-industrial-100 hover:text-molten-400 focus:outline-none">
          <i data-feather="menu"></i>
        </button>
      </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-industrial-900/95 border-t border-industrial-700 transition-all duration-500 ease-in-out opacity-0 translate-y-[-10px]">
      <a href="index.php" class="block px-4 py-3 <?= $current_page=='index.php' ? 'text-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Home</a>
      <a href="about.php" class="block px-4 py-3 <?= $current_page=='about.php' ? 'text-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">About</a>
      <a href="products.php" class="block px-4 py-3 <?= $current_page=='products.php' ? 'text-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Products</a>
      <a href="capabilities.php" class="block px-4 py-3 <?= $current_page=='capabilities.php' ? 'text-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Capabilities</a>
      <a href="contact.php" class="block px-4 py-3 <?= $current_page=='contact.php' ? 'text-molten-400' : 'text-industrial-100 hover:text-molten-400' ?>">Contact</a>
    </div>
  </nav>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      feather.replace();

      // Fade animations
      document.querySelectorAll('.fade-up').forEach((el, i) => {
        setTimeout(() => el.classList.add('show'), i * 120);
      });

      anime({
        targets: '#navbar',
        opacity: [0, 1],
        translateY: [-20, 0],
        duration: 800,
        easing: 'easeOutExpo'
      });

      // Mobile menu animation
      const menuBtn = document.getElementById('mobile-menu-btn');
      const mobileMenu = document.getElementById('mobile-menu');
      let open = false;

      menuBtn.addEventListener('click', () => {
        open = !open;
        if (open) {
          mobileMenu.classList.remove('hidden');
          anime({ targets: '#mobile-menu', opacity: [0, 1], scale: [0.95, 1], duration: 400, easing: 'easeOutExpo' });
        } else {
          anime({
            targets: '#mobile-menu', opacity: [1, 0], scale: [1, 0.95],
            duration: 300, easing: 'easeInExpo',
            complete: () => mobileMenu.classList.add('hidden')
          });
        }
      });

      // Vanta background
      if (window.VANTA) {
        VANTA.WAVES({
          el: "#vanta-bg",
          mouseControls: true,
          touchControls: true,
          gyroControls: false,
          minHeight: 200.00,
          minWidth: 200.00,
          scale: 1.00,
          scaleMobile: 1.00,
          color: 0x1e293b,
          shininess: 55.00,
          waveHeight: 15.00,
          waveSpeed: 0.50,
          zoom: 0.75
        });
      }
    });
  </script>
</body>
</html>