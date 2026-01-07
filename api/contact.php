<?php
include 'config.php'; 
include 'header.php'; 
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | MetalCraft Masters</title>
    <link rel="icon" type="image/x-icon" href="<?php echo BASE_PATH; ?>/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'industrial': { 50:'#f9fafb',200:'#e5e7eb',300:'#d1d5db',700:'#374151',800:'#1f2937',900:'#111827' },
                        'molten': { 400:'#f07e15',500:'#e86d00',600:'#d96200',700:'#c75a00',900:'#8a3c00' },
                    },
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Montserrat', sans-serif; scroll-behavior: smooth; }

        .hero-industrial {
            background: url('uploads/contact.jpeg') center center / cover no-repeat;
            border-bottom: 4px solid #e86d00;
            position: relative;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
        }
        .fade { transition: opacity 0.6s ease; }

        /* --- Smooth Entrance Animations --- */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeSlideUp {
            opacity: 0;
            animation: fadeSlideUp 1s ease forwards;
        }

        /* Sequential delay for elements */
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
        .delay-4 { animation-delay: 0.8s; }
    </style>
</head>

<main class="pt-24">

    <!-- Hero Section -->
    <section class="relative hero-industrial text-white flex items-center justify-center h-[300px] overflow-hidden">
        <div class="hero-overlay"></div>
        <div class="text-center px-6 relative z-10 animate-fadeSlideUp delay-1">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-molten-400">Forge Your Partnership</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto text-industrial-200">
                Get in touch with our engineering specialists for inquiries, quotes, or project discussions.
            </p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-industrial-800">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
            
            <!-- Contact Form -->
            <div class="lg:col-span-2 bg-industrial-900 p-8 rounded-xl shadow-2xl border border-industrial-700 animate-fadeSlideUp delay-2">
                <h2 class="text-3xl font-bold mb-8 text-industrial-50">Send Us a Message</h2>

                <form id="contactForm" class="space-y-6">
                    <input type="hidden" name="access_key" value="2c8d8b05-775e-49b8-900b-c0fa19080548">

                    <div>
                        <label for="name" class="block text-sm font-medium text-industrial-300 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-3 bg-industrial-700 rounded-lg focus:ring-molten-500 focus:border-molten-500 text-industrial-50 border border-industrial-700 transition duration-300 focus:scale-[1.02]">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-industrial-300 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-3 bg-industrial-700 rounded-lg focus:ring-molten-500 focus:border-molten-500 text-industrial-50 border border-industrial-700 transition duration-300 focus:scale-[1.02]">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-industrial-300 mb-2">Subject</label>
                        <input type="text" name="subject" id="subject" required class="w-full px-4 py-3 bg-industrial-700 rounded-lg focus:ring-molten-500 focus:border-molten-500 text-industrial-50 border border-industrial-700 transition duration-300 focus:scale-[1.02]">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-industrial-300 mb-2">Your Project Details</label>
                        <textarea name="message" id="message" rows="4" required class="w-full px-4 py-3 bg-industrial-700 rounded-lg focus:ring-molten-500 focus:border-molten-500 text-industrial-50 border border-industrial-700 transition duration-300 focus:scale-[1.02]"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-molten-500 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-molten-400 hover:scale-[1.03] transition duration-300 flex items-center justify-center">
                        Submit Inquiry <i data-feather="send" class="ml-2 w-5 h-5"></i>
                    </button>

                    <div id="formStatus" class="hidden mt-6 text-center p-4 rounded-lg fade"></div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-12 animate-fadeSlideUp delay-3">
                <div>
                    <h2 class="text-2xl font-bold text-industrial-50 mb-4 flex items-center"><i data-feather="map-pin" class="w-6 h-6 mr-2 text-molten-400"></i> Our Office</h2>
                    <p class="text-industrial-300 mb-2"><strong>Address:</strong> Shivam Park 4, Plot No. 7/3, Dared, Jamnagar, Gujarat, India</p>
                    <p class="text-industrial-300 mb-2"><strong>Phone:</strong> <a href="tel:+919428051768" class="hover:text-molten-400 transition">+91 9428051768</a></p>
                    <p class="text-industrial-300 mb-2"><strong>Phone:</strong> <a href="tel:+918488951635" class="hover:text-molten-400 transition">+91 8488951635</a></p>
                    <p class="text-industrial-300 mb-2"><strong>Email:</strong> <a href="mailto:kanchavabrasscomponents@gmail.com" class="hover:text-molten-400 transition">kanchavabrasscomponents@gmail.com</a></p>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-industrial-50 mb-4 flex items-center"><i data-feather="users" class="w-6 h-6 mr-2 text-molten-400"></i> Follow Us</h2>
                    <div class="flex space-x-6">
                        <a href="http://facebook.com/people/Mital-Engineering/100075935785838/?mibextid=ZbWKwL" class="text-industrial-300 hover:text-molten-400 hover:scale-110 transition-transform duration-300" aria-label="Facebook"><i data-feather="facebook" class="w-7 h-7"></i></a>
                        <a href="https://www.linkedin.com/in/mital-engineering/" class="text-industrial-300 hover:text-molten-400 hover:scale-110 transition-transform duration-300" aria-label="LinkedIn"><i data-feather="linkedin" class="w-7 h-7"></i></a>
                        <a href="https://www.instagram.com/mital.engineering/#" class="text-industrial-300 hover:text-molten-400 hover:scale-110 transition-transform duration-300" aria-label="Instagram"><i data-feather="instagram" class="w-7 h-7"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-industrial-900 animate-fadeSlideUp delay-4">
        <h2 class="text-3xl font-bold text-industrial-50 mb-8 text-center">Find Our Fabrication Unit</h2>
        <div class="max-w-7xl mx-auto rounded-xl overflow-hidden shadow-2xl border-4 border-industrial-700 hover:scale-[1.01] transition duration-500">
            <iframe 
                src="https://maps.google.com/maps?q=Shivam+Park+4,+Plot+No.+7/3,+Dared,+Jamnagar,+Gujarat,+India&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                width="100%" height="450" style="border:0;" allowfullscreen loading="lazy"></iframe>
        </div>
    </section>
</main>

<script>
feather.replace();

const form = document.getElementById("contactForm");
const statusDiv = document.getElementById("formStatus");

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(form);

  statusDiv.classList.remove("hidden");
  statusDiv.textContent = "Sending your message...";
  statusDiv.className = "mt-6 text-center p-4 bg-blue-700/60 border border-blue-500 text-white rounded-lg fade animate-fadeSlideUp";

  try {
    const res = await fetch("https://api.web3forms.com/submit", { method: "POST", body: formData });
    const data = await res.json();

    if (data.success) {
      statusDiv.textContent = "✅ Your message has been sent successfully.";
      statusDiv.className = "mt-6 text-center p-4 bg-green-700/70 border border-green-500 text-white rounded-lg fade animate-fadeSlideUp";
      form.reset();
    } else {
      throw new Error(data.message);
    }
  } catch (err) {
    statusDiv.textContent = "❌ Failed to send message. Please try again.";
    statusDiv.className = "mt-6 text-center p-4 bg-red-700/70 border border-red-500 text-white rounded-lg fade animate-fadeSlideUp";
  }

  setTimeout(() => {
    statusDiv.style.opacity = "0";
    setTimeout(() => statusDiv.classList.add("hidden"), 800);
  }, 4000);
});
</script>

<?php include 'footer.php'; ?>
