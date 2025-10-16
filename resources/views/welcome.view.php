<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABG Prime Builders Supplies Inc.</title>
    <link rel="icon" type="image/png" href="/assets/img/abg-logo.png">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</head>

<body>
    <!-- Page Loading Overlay -->
    <div id="page-loader">
        <div class="loader-spinner"></div>
    </div>
    
    <header class="w-full sticky top-0 bg-[#fff] z-50">
        <div class="container px-4 py-4 mx-auto lg:px-8">
            <div class="flex items-center justify-between">
                <div class="logo-container">
                    <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" class="w-auto h-10 sm:h-12">
                    <div class="company-text">
                        <img src="/assets/img/abg-company-name.svg" alt="ABG Company Name" class="w-auto h-4 mt-1 sm:h-5">
                        <img src="/assets/img/abg-company-subtitle.svg" alt="ABG Company Subtitle" class="w-auto h-3 mt-1 sm:h-4">
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex">
                    <ul class="flex space-x-8 navbar-links">
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#team">Team</a></li>
                    </ul>
                </nav>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-700 hover:text-[#815331] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation Menu -->
            <nav id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <ul class="flex flex-col space-y-3">
                    <li><a href="#hero" class="block py-2 px-4 text-gray-700 hover:bg-[#ece5df] hover:text-[#815331] rounded-lg transition">Home</a></li>
                    <li><a href="#about" class="block py-2 px-4 text-gray-700 hover:bg-[#ece5df] hover:text-[#815331] rounded-lg transition">About</a></li>
                    <li><a href="#products" class="block py-2 px-4 text-gray-700 hover:bg-[#ece5df] hover:text-[#815331] rounded-lg transition">Products</a></li>
                    <li><a href="#team" class="block py-2 px-4 text-gray-700 hover:bg-[#ece5df] hover:text-[#815331] rounded-lg transition">Team</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero-banner-section" id="hero">
        <div class="px-4 hero-banner-container lg:px-8">
            <div class="max-w-xl hero-details-container px-4 sm:px-6 md:px-0">
                <h1 class="mb-5 text-3xl font-bold leading-tight md:text-4xl md:mb-6 lg:text-5xl">Build smarter with ABG Prime Builders</h1>
                <p class="mb-6 text-lg leading-relaxed md:text-xl md:mb-8">Shop high-quality tools and materials at unbeatable prices</p>
                <div class="flex flex-col w-full gap-3 sm:flex-row sm:gap-3 sm:w-auto">
                    <div class="shop-now-button w-full sm:w-auto">
                        <a href="/login" class="block w-full px-6 py-3 text-base font-medium text-center sm:px-8 md:text-lg">Start shopping</a>
                    </div>
                    <div class="get-started-button w-full sm:w-auto">
                        <a href="/register" class="block w-full px-6 py-3 text-base font-medium text-center sm:px-8 md:text-lg">Join free</a>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center hero-image-container px-4 sm:px-6 md:px-0">
                <img src="assets/img/tools.png" alt="Tools" class="w-full max-w-xs sm:max-w-sm md:max-w-md" />
            </div>
        </div>
    </section>

    <section class="py-16 about-section" id="about">
        <div class="container px-4 mx-auto about-container lg:px-8">
            <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
                <div class="space-y-6 description-container">
                    <div class="title-container">
                        <p class="mb-4 text-3xl font-bold md:text-4xl">About Us</p>
                    </div>
                    <div class="motto-container">
                        <p class="text-lg md:text-xl">
                            Powering efficiency, accuracy, and smooth operations-one order at a
                            time.
                        </p>
                    </div>
                    <div class="space-y-4 about-details-container">
                        <p class="text-base leading-relaxed md:text-lg">
                            Built to simplify and speed up daily operations at ABG Prime
                            Builders - from real-time stock tracking to fast, accurate order
                            processing, all in one reliable online platform:
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="mr-2">🖥️</span>
                                Monitor inventory to avoid overstock and stockouts.
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">⚙️</span>
                                Process walk-in and bulk orders with speed and accuracy.
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">📝</span>
                                Generate clear, detailed sales and inventory reports.
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">🔐</span>
                                Secure, easy to access, and available anytime, anywhere.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex justify-center about-image-container lg:justify-end">
                    <img src="assets/img/about.jpg" alt="ABG Shop" />
                </div>
            </div>
        </div>
    </section>

    <section class="px-4 py-12 cards-section lg:px-8" id="products">
        <div class="container mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div class="deals-container">
                    <p>Hot Deals 🔥</p>
                </div>
                <a href="/login" class="font-bold text-blue-700 cursor-pointer hover:text-blue-300">See more</a>
            </div>
            <div class="container mx-auto swiper">
                <!-- Additional required wrapper -->
                <div class="gap-5 swiper-wrapper">
                    <!-- Slides -->
                    <div class="card swiper-slide ">
                        <img src="assets/img/products/magnetic_lever.png" alt="" />
                        <div class="price-container">
                            <p>PHP 418.00</p>
                        </div>
                        <p>Wokin Magnetic Lever Bar</p>
                        <div class="sold-container">
                            <p>98 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/finishing_sander.png" alt="" />
                        <div class="price-container">
                            <p>PHP 1,450.00</p>
                        </div>
                        <p>Wokin Finishing Sander 1/3"</p>
                        <div class="sold-container">
                            <p>98 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/rotary_hammer.png" alt="" />
                        <div class="price-container">
                            <p>PHP 4,560.00</p>
                        </div>
                        <p>Wokin Rotary Hammer</p>
                        <div class="sold-container">
                            <p>21 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/coco_lumber.png" alt="" />
                        <div class="price-container">
                            <p>PHP 86.00 - 250.00</p>
                        </div>
                        <p>Coco Lumber</p>
                        <div class="sold-container">
                            <p>147 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/tubular.png" alt="" />
                        <div class="price-container">
                            <p>PHP 254.00 - 2,247.00</p>
                        </div>
                        <p>Tubular Bar GI</p>
                        <div class="sold-container">
                            <p>76 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/grinder.png" alt="" />
                        <div class="price-container">
                            <p>PHP 2,150.00</p>
                        </div>
                        <p>Wokin Cordless Drill</p>
                        <div class="sold-container">
                            <p>158 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/drill.png" alt="" />
                        <div class="price-container">
                            <p>PHP 3,450.00</p>
                        </div>
                        <p>Wokin Angle Grinder</p>
                        <div class="sold-container">
                            <p>198 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/wrench.png" alt="" />
                        <div class="price-container">
                            <p>PHP 650.00</p>
                        </div>
                        <p>Adjustable Wrench Set</p>
                        <div class="sold-container">
                            <p>136 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/precision_screwdriver.png" alt="" />
                        <div class="price-container">
                            <p>PHP 420.00</p>
                        </div>
                        <p>Precision Screwdriver Set</p>
                        <div class="sold-container">
                            <p>325 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/digital_caliper.png" alt="" />
                        <div class="price-container">
                            <p>PHP 1,280.00</p>
                        </div>
                        <p>Digital Vernier Caliper</p>
                        <div class="sold-container">
                            <p>325 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/pipe.png" alt="" />
                        <div class="price-container">
                            <p>PHP 90.00</p>
                        </div>
                        <p>Electrical Conduit Pipe</p>
                        <div class="sold-container">
                            <p>215 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/nails.png" alt="" />
                        <div class="price-container">
                            <p>PHP 120.00</p>
                        </div>
                        <p>Roofing Nails</p>
                        <div class="sold-container">
                            <p>55 sold</p>
                        </div>
                    </div>
                </div>

                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- If we need scrollbar -->
                <!-- <div class="swiper-scrollbar"></div> -->
            </div>

            <div class="container flex justify-between mx-auto">
                <div class="deals-container">
                    <p>Top Products 🏆</p>
                </div>
                <a href="/login" class="font-bold text-blue-700 cursor-pointer hover:text-blue-300">See more</a>
            </div>
            <div class="container mx-auto swiper">
                <!-- Additional required wrapper -->
                <div class="gap-5 swiper-wrapper">
                    <!-- Slides -->
                    <div class="card swiper-slide">
                        <img src="assets/img/products/pvc.png" alt="" />
                        <div class="price-container">
                            <p>PHP 418.00</p>
                        </div>
                        <p>Neltex Waterline PVC Pipe</p>
                        <div class="sold-container">
                            <p>223 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/plywood.png" alt="" />
                        <div class="price-container">
                            <p>PHP 400.00 - 1,150.00</p>
                        </div>
                        <p>Marine Plywood</p>
                        <div class="sold-container">
                            <p>128 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/sack.png" alt="" />
                        <div class="price-container">
                            <p>PHP 29.00 - 42.00</p>
                        </div>
                        <p>Sakolin Blue Sack</p>
                        <div class="sold-container">
                            <p>53 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/tubular.png" alt="" />
                        <div class="price-container">
                            <p>PHP 86.00 - 250.00</p>
                        </div>
                        <p>Deformed Bar G33</p>
                        <div class="sold-container">
                            <p>554 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/cement.png" alt="" />
                        <div class="price-container">
                            <p>PHP 225.00</p>
                        </div>
                        <p>Eagle Cement</p>
                        <div class="sold-container">
                            <p>248 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/coco_lumber.png" alt="" />
                        <div class="price-container">
                            <p>PHP 1,450.00</p>
                        </div>
                        <p>Wokin Rotary Hammer</p>
                        <div class="sold-container">
                            <p>98 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/drill.png" alt="" />
                        <div class="price-container">
                            <p>PHP 4,200.00</p>
                        </div>
                        <p>Wokin Circular Saw</p>
                        <div class="sold-container">
                            <p>228 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/bolt_cutter.png" alt="" />
                        <div class="price-container">
                            <p>PHP 1,750.00</p>
                        </div>
                        <p>Heavy Duty Bolt Cutter</p>
                        <div class="sold-container">
                            <p>115 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/hollow_blocks.png" alt="" />
                        <div class="price-container">
                            <p>PHP 18.00</p>
                        </div>
                        <p>Hollow Blocks</p>
                        <div class="sold-container">
                            <p>300 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/steel_bar.png" alt="" />
                        <div class="price-container">
                            <p>PHP 350.00</p>
                        </div>
                        <p>Reinforcing Steel Bar</p>
                        <div class="sold-container">
                            <p>200 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/tile.png" alt="" />
                        <div class="price-container">
                            <p>PHP 750.00</p>
                        </div>
                        <p>Ceramic Floor Tiles</p>
                        <div class="sold-container">
                            <p>328 sold</p>
                        </div>
                    </div>
                    <div class="card swiper-slide">
                        <img src="assets/img/products/paint.png" alt="" />
                        <div class="price-container">
                            <p>PHP 1,150.00</p>
                        </div>
                        <p>Waterproofing Paint</p>
                        <div class="sold-container">
                            <p>58 sold</p>
                        </div>
                    </div>
                </div>

                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- If we need scrollbar -->
                <!-- <div class="swiper-scrollbar"></div> -->
            </div>
        </div>
    </section>

    <section class="py-12 team-section sm:py-16" id="team">
        <div class="container px-4 mx-auto lg:px-8">
            <div class="max-w-4xl mx-auto mb-10 text-center team-description sm:mb-12 md:mb-16">
                <div class="mb-4 team-description-title sm:mb-6">
                    <p class="text-2xl font-bold sm:text-3xl md:text-4xl text-[#815331]">Team</p>
                </div>
                <p class="text-sm leading-relaxed sm:text-base md:text-lg">
                    Behind ABG Prime Builders is a dedicated team of individuals who share one goal: to serve the
                    Filipino builder with excellence, innovation, and heart.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-6 team-cards-container sm:grid-cols-2 sm:gap-8 lg:grid-cols-4 justify-items-center">
                <div class="team-card w-full max-w-[200px] sm:max-w-[220px]">
                    <img src="assets/img/team/dingdong.png" alt="Ray Lance Gregorio" class="w-24 h-24 sm:w-28 sm:h-28">
                    <div class="team-name">
                        <p class="text-sm sm:text-base">Ray Lance Gregorio</p>
                    </div>
                    <p class="text-xs sm:text-sm">Leader</p>
                </div>
                <div class="team-card w-full max-w-[200px] sm:max-w-[220px]">
                    <img src="assets/img/team/ryan.png" alt="Ryan Lester Lacdang" class="w-24 h-24 sm:w-28 sm:h-28">
                    <div class="team-name">
                        <p class="text-sm sm:text-base">Ryan Lester Lacdang</p>
                    </div>
                    <p class="text-xs sm:text-sm">Sidekick</p>
                </div>
                <div class="team-card w-full max-w-[200px] sm:max-w-[220px]">
                    <img src="assets/img/team/zanjoe.png" alt="Zanjoe Lanze Manuel" class="w-24 h-24 sm:w-28 sm:h-28">
                    <div class="team-name">
                        <p class="text-sm sm:text-base">Zanjoe Lanze Manuel</p>
                    </div>
                    <p class="text-xs sm:text-sm">The Ultimate Weapon</p>
                </div>
                <div class="team-card w-full max-w-[200px] sm:max-w-[220px]">
                    <img src="assets/img/team/kian.png" alt="Kian John Morenencia" class="w-24 h-24 sm:w-28 sm:h-28">
                    <div class="team-name">
                        <p class="text-sm sm:text-base">Kian John Morenencia</p>
                    </div>
                    <p class="text-xs sm:text-sm">Idea Master</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="w-full">
        <div class="container px-6 py-10 mx-auto sm:py-12 lg:px-8">
            <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Company Info -->
                <div class="space-y-3">
                    <div>
                        <p class="text-xl font-bold sm:text-2xl md:text-3xl">ABG Prime</p>
                        <p class="text-base font-bold sm:text-lg md:text-xl">Builders Supplies Inc.</p>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Your one-stop shop for tools, materials, and construction essentials. Prime
                        Builders is built to serve every Filipino builder - fast, reliable, and trusted by professionals
                        and DIYers alike.
                    </p>
                </div>

                <!-- Useful Links -->
                <div class="space-y-3">
                    <p class="text-base font-bold sm:text-lg">Useful Links</p>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#hero" class="hover:text-[#815331] transition inline-flex items-center">
                            <span class="mr-2">→</span>Home
                        </a></li>
                        <li><a href="#about" class="hover:text-[#815331] transition inline-flex items-center">
                            <span class="mr-2">→</span>About Us
                        </a></li>
                        <li><a href="#products" class="hover:text-[#815331] transition inline-flex items-center">
                            <span class="mr-2">→</span>Hot Deals
                        </a></li>
                        <li><a href="#products" class="hover:text-[#815331] transition inline-flex items-center">
                            <span class="mr-2">→</span>Top Products
                        </a></li>
                        <li><a href="#team" class="hover:text-[#815331] transition inline-flex items-center">
                            <span class="mr-2">→</span>Team
                        </a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="space-y-3 sm:col-span-2 lg:col-span-1">
                    <p class="text-base font-bold sm:text-lg">Contact Us</p>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-2">
                            <svg class="flex-shrink-0 w-4 h-4 mt-1 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="leading-relaxed">AICS Bldg., Commonwealth Ave., Holy Spirit Drive, Brgy. Don Antonio Dr, Quezon City</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="flex-shrink-0 w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <p>+63 923 456 7890</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="flex-shrink-0 w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="break-all">buildwithzanjoe@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 text-center bg-white">
            <p class="text-xs sm:text-sm">&copy; 2025 <span class="abg-footer">ABG Prime Builders Supplies Inc.</span> - Powered by ABG. Building Better, Together.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper(".swiper", {
                // Optional parameters
                spaceBetween: 20,
                slidesPerView: 2,
                loop: true, // Enable infinite loop
                loopAdditionalSlides: 3, // Add extra slides for smooth looping
                autoplay: {
                    delay: 5000, // time in ms between swipes
                    disableOnInteraction: false, // keep autoplay after user interaction
                },

                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 480px
                    480: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    },
                    // when window width is >= 640px
                    640: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    },
                    // when window width is >= 768px
                    768: {
                        slidesPerView: 5,
                        spaceBetween: 20
                    },
                    // when window width is >= 1024px
                    1024: {
                        slidesPerView: 6,
                        spaceBetween: 20
                    },
                    // when window width is >= 1280px
                    1280: {
                        slidesPerView: 7,
                        spaceBetween: 20
                    }
                },

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    dynamicBullets: true,
                },

                // Navigation arrows
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },

                // And if we need scrollbar
                scrollbar: {
                    el: ".swiper-scrollbar",
                },
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });

                // Close mobile menu when clicking on a link
                const mobileLinks = mobileMenu.querySelectorAll('a');
                mobileLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                    });
                });
            }

            const locationChecked = sessionStorage.getItem("locationChecked");

            // If not checked yet, do the geolocation validation
            if (!locationChecked) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
                } else {
                    alert("Geolocation is not supported by this browser");
                    window.location.href = "/not-allowed";
                }
            }

            function successCallback(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Coordinates for L28, Block 11, km 17 Commonwealth Ave, Quezon City
                const storeLat = 14.6997;
                const storeLng = 121.0916;
                const maxDistance = 5; // Accepts users within 5 km radius

                const distance = getDistanceInKm(userLat, userLng, storeLat, storeLng);

                // Debug information (remove in production)
                // console.log('User coordinates:', userLat, userLng);
                // console.log('Store coordinates:', storeLat, storeLng);
                // console.log('Distance:', distance.toFixed(3), 'km');
                // console.log('Max allowed distance:', maxDistance, 'km');

                if (distance > maxDistance) {
                    alert(`Sorry! You are ${distance.toFixed(2)}km away. We currently deliver only within ${maxDistance}km of our store in Quezon City.`);
                    window.location.href = "/not-allowed";
                } else {
                    console.log('Location check passed!');
                    sessionStorage.setItem("locationChecked", "true");
                    // Set session variable for server-side validation
                    fetch('/set-location-session', {
                        method: 'POST',
                        credentials: 'include'
                    });
                }
            }

            function errorCallback(error) {
                alert("We need your location to continue. Please allow access.");
                window.location.href = "/not-allowed";
            }

            function getDistanceInKm(lat1, lon1, lat2, lon2) {
                const R = 6371;
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

                return R * c;
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }
        });
    </script>
</body>

</html>