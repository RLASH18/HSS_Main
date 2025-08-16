<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</head>

<body>
    <header class="container mx-auto grid grid-cols-2">
        <div class="header-logo-container flex align-center py-1">
            <img src="/assets/img/abg_logo1.png" alt="">
            <div class="brand-icon">
                <img src="/assets/img/abg_logo2.svg" alt="">
                <img src="/assets/img/abg_logo3.svg" alt="">
            </div>

        </div>
        <nav class="flex align-center justify-center">
            <ul class="navbar-links">
                <li><a href="#hero">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#team">Team</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero-banner-section" id="hero">
        <div class="hero-banner-container">
            <div class="hero-details-container mx-auto">
                <h1>Build smarter with ABG Prime Builders</h1>
                <p>Shop high-quality tools and materials at unbeatable prices</p>
                <div class="shop-now-button">
                    <a href="/login">Shop now</a>
                </div>

            </div>
            <div class="hero-image-container mx-auto">
                <img src="assets/img/tools.png" alt="" />
            </div>
        </div>
    </section>

    <section class="about-section" id="about">
        <div class="about-container container my-5 mx-auto grid grid-cols-2 place-items-center gap-5">
            <div class="description-container max-w-150">
                <div class="title-container">
                    <p>About Us</p>
                </div>
                <div class="motto-container">
                    <p>
                        Powering efficiency, accuracy, and smooth operations-one order at a
                        time.
                    </p>
                </div>
                <div class="about-details-container">
                    <p>
                        Built to simplify and speed up daily operations at ABG Prime
                        Builders - from real-time stock tracking to fast, accurate order
                        processing, all in one reliable online platform.
                    </p>
                    <ul>
                        <li>
                            Monitor inventory in real-time to avoid overstock and stockouts
                        </li>
                        <li>Process walk-in and bulk orders with speed and accuracy</li>
                        <li>Generate clear, detailed sales and inventory reports</li>
                        <li>Secure, easy to access, and available anytime, anywhere.</li>
                    </ul>
                </div>
            </div>
            <div class="about-image-container flex justify-center">
                <img src="assets/img/about.jpg" class="max-w-md mt-2" alt="" />
            </div>
        </div>
    </section>

    <section class="cards-section p-5" id="products">
        <div class="container mx-auto flex justify-between">
            <div class="deals-container">
                <p>Hot Deals</p>
            </div>
            <p>See more</p>
        </div>
        <div class="swiper container mx-auto">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper gap-5">
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
                    <img src="assets/img/products/coco_lumber.png" alt="" />
                    <div class="price-container">
                        <p>PHP 1,450.00</p>
                    </div>
                    <p>Wokin Rotary Hammer</p>
                    <div class="sold-container">
                        <p>98 sold</p>
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

        <div class="container mx-auto flex justify-between">
            <div class="deals-container">
                <p>Top Products</p>
            </div>
            <p>See more</p>
        </div>
        <div class="swiper container mx-auto">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper gap-5">
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
                    <img src="assets/img/products/rotary_hammer.png" alt="" />
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
            </div>

            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- If we need scrollbar -->
            <!-- <div class="swiper-scrollbar"></div> -->
        </div>


    </section>

    <section class="team-section" id="team">
        <div class="container mx-auto p-5 mb-5">
            <div class="team-description mb-10 p-5">
                <div class="team-description-title">
                    <p class="text-center">Team</p>
                </div>
                <p>Behind ABG Prime Builders is a dedicated team of individuals who share one goal: to serve the
                    Filipino builder with excellence, innovation, and heart.</p>
            </div>
            <div class="team-cards-container flex justify-center gap-10">
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
        <div class="container w-full mx-auto grid grid-cols-3 p-2 py-4">
            <div>
                <p class="text-4xl font-bold">ABG Prime</p>
                <p class="text-2xl mb-3 font-bold">Builders Supplies Inc.</p>
                <p class="text-sm">Your one-stop shop for tools, materials, and construction essentials. Prime
                    Builders is built to
                    serve every Filipino builder - fast, reliable, and trusted by professionals and DIYers alike.</p>
            </div>
            <div class="mx-auto">
                <p class="text-2xl mb-3 font-bold">Useful Links</p>
                <ul>
                    <li>Home</li>
                    <li>Categories</li>
                    <li>Hot Deals</li>
                    <li>Top Products</li>
                    <li>Team</li>
                </ul>
            </div>
            <div>
                <p class="text-2xl mb-3 font-bold">Contact Us</p>
                <p class="mb-3">AICS Bldg., Commonwealth Ave., Holy Spirit Drive, Brgy. Don Antonio Dr, Quezon City </p>
                <div>
                    <div class="flex">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                        </svg>
                        <p>Phone: +63 923 456 7890</p>
                    </div>
                    <div class="flex">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                        </svg>
                        <p>Email: buildwithzanjoe@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center bg-white p-2">
            <p>&copy; 2025 <span class="abg-footer">ABG Prime Builders Supplies Inc.</span> - Powered by ABG. Building
                Better, Together.
            </p>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper(".swiper", {
                // Optional parameters
                //spaceBetween: 20,
                slidesPerView: 5,
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
</body>

</html>