<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABG Prime Builders Supplies Inc.</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body>
    <header class="container px-4 py-4 mx-auto lg:px-8">
        <div class="flex items-center justify-between">
            <div class="logo-container">
                <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" class="w-auto h-12">
                <div class="company-text">
                    <img src="/assets/img/abg-company-name.svg" alt="ABG Company Name" class="w-auto h-5 mt-1">
                    <img src="/assets/img/abg-company-subtitle.svg" alt="ABG Company Subtitle" class="w-auto h-4 mt-1">
                </div>
            </div>

            <nav class="hidden md:flex">
                <ul class="flex space-x-8 navbar-links">
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#team">Team</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero-banner-section" id="hero">
        <div class="px-4 hero-banner-container lg:px-8">
            <div class="max-w-xl hero-details-container">
                <h1 class="mb-6 text-4xl font-bold leading-tight md:text-4xl">Build smarter with ABG Prime Builders</h1>
                <p class="mb-8 text-lg md:text-xl">Shop high-quality tools and materials at unbeatable prices</p>
                <div class="inline-block shop-now-button">
                    <a href="/login" class="px-8 py-3 text-lg">Start shopping</a>
                </div>
                <div class="inline-block get-started-button">
                    <a href="/register" class="px-8 py-3 text-lg">Join free</a>
                </div>
            </div>
            <div class="flex items-center justify-center hero-image-container">
                <img src="assets/img/tools.png" alt="Tools" />
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

    <section class="py-16 team-section" id="team">
        <div class="container px-4 mx-auto lg:px-8">
            <div class="max-w-4xl mx-auto mb-16 text-center team-description">
                <div class="mb-6 team-description-title">
                    <p class="text-3xl md:text-4xl font-bold text-[#815331]">Team</p>
                </div>
                <p class="text-base leading-relaxed md:text-lg">
                    Behind ABG Prime Builders is a dedicated team of individuals who share one goal: to serve the
                    Filipino builder with excellence, innovation, and heart.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-8 team-cards-container sm:grid-cols-2 lg:grid-cols-4 justify-items-center">
                <div class="team-card">
                    <img src="assets/img/team/dingdong.png" alt="">
                    <div class="team-name">
                        <p>Ray Lance Gregorio</p>
                    </div>
                    <p>Leader</p>
                </div>
                <div class="team-card">
                    <img src="assets/img/team/ryan.png" alt="">
                    <div class="team-name">
                        <p>Ryan Lester Lacdang</p>
                    </div>
                    <p>Sidekick</p>
                </div>
                <div class="team-card">
                    <img src="assets/img/team/zanjoe.png" alt="">
                    <div class="team-name">
                        <p>Zanjoe Lanze Manuel</p>
                    </div>
                    <p>The Ultimate Weapon</p>
                </div>
                <div class="team-card">
                    <img src="assets/img/team/kian.png" alt="">
                    <div class="team-name">
                        <p>Kian John Morenencia</p>
                    </div>
                    <p>Idea Master</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="w-full">
        <div class="container px-4 py-12 mx-auto lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <div class="space-y-4">
                    <p class="text-3xl font-bold md:text-4xl">ABG Prime</p>
                    <p class="text-xl font-bold md:text-2xl">Builders Supplies Inc.</p>
                    <p class="text-sm">
                        Your one-stop shop for tools, materials, and construction essentials. Prime
                        Builders is built to serve every Filipino builder - fast, reliable, and trusted by professionals
                        and DIYers alike.
                    </p>
                </div>

                <div class="ml-10 space-y-4">
                    <p class="mb-3 text-xl font-bold">Useful Links</p>
                    <ul class="space-y-2">
                        <li>Home</li>
                        <li>About Us</li>
                        <li>Hot Deals</li>
                        <li>Top Products</li>
                        <li>Team</li>
                    </ul>
                </div>
                <div class="space-y-4">
                    <p class="mb-3 text-xl font-bold">Contact Us</p>
                    <p class="mb-3 text-sm">AICS Bldg., Commonwealth Ave., Holy Spirit Drive, Brgy. Don Antonio Dr,
                        Quezon City </p>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-600" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                            </svg>
                            <p class="text-sm md:text-base">Phone: +63 923 456 7890</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-600" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                            </svg>
                            <p class="text-sm md:text-base">Email: buildwithzanjoe@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-2 text-center bg-white">
            <p>&copy; 2025 <span class="abg-footer">ABG Prime Builders Supplies Inc.</span> - Powered by ABG. Building
                Better, Together.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper(".swiper", {
                // Optional parameters
                spaceBetween: 20,
                slidesPerView: 7,
                loop: true, // Enable infinite loop
                loopAdditionalSlides: 3, // Add extra slides for smooth looping
                autoplay: {
                    delay: 5000, // time in ms between swipes
                    disableOnInteraction: false, // keep autoplay after user interaction
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