<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="icon" type="image/png" href="/assets/img/abg-logo.png">
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- List.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

    <script src="/assets/js/script.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Page Loading Overlay -->
    <div id="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Header -->
    <header class="w-full bg-[#ECE5DF] shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 lg:px-8 py-4">
            <div class="flex items-center justify-between gap-6">
                <!-- Logo Section -->
                <a href="/customer/home" class="flex-shrink-0">
                    <div class="logo-container">
                        <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" class="w-auto h-10 sm:h-12">
                        <div class="company-text">
                            <img src="/assets/img/abg-company-name.svg" alt="ABG Company Name" class="w-auto h-4 mt-1 sm:h-5">
                            <img src="/assets/img/abg-company-subtitle.svg" alt="ABG Company Subtitle" class="w-auto h-3 mt-1 sm:h-4">
                        </div>
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="search-container hidden md:block">
                    <div class="relative">
                        <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" class="search-input" placeholder="Search Item" id="searchInput">
                    </div>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <!-- Mobile Menu Button (Hamburger) -->
                    <div class="relative sm:hidden">
                        <button id="mobile-menu-toggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Mobile Dropdown Menu -->
                        <div id="mobile-menu-dropdown" class="hidden absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="/customer/profile" class="flex items-center gap-3 px-3 py-3 mx-2 rounded-md hover:bg-gray-50 transition-colors" data-route="/customer/profile">
                                <svg class="w-5 h-5 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="text-sm text-gray-700">Profile</span>
                            </a>

                            <a href="/customer/my-cart" class="flex items-center gap-3 px-3 py-3 mx-2 rounded-md hover:bg-gray-50 transition-colors relative" data-route="/customer/my-cart">
                                <div class="relative">
                                    <svg class="w-5 h-5 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                                    </svg>
                                    <?php
                                    if (auth()) {
                                        $cartItems = \app\models\Cart::whereMany(['user_id' => auth()->id]);
                                        $cartCount = count($cartItems);
                                        if ($cartCount > 0) {
                                            echo '<span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold">' . $cartCount . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <span class="text-sm text-gray-700">My Cart</span>
                            </a>

                            <a href="/customer/my-orders" class="flex items-center gap-3 px-3 py-3 mx-2 rounded-md hover:bg-gray-50 transition-colors relative" data-route="/customer/my-orders">
                                <div class="relative">
                                    <svg class="w-5 h-5 text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                                    </svg>
                                    <?php
                                    if (auth()) {
                                        $pendingOrders = \app\models\Orders::whereMany(['user_id' => auth()->id]);
                                        $activeOrderCount = 0;
                                        foreach ($pendingOrders as $order) {
                                            if (in_array($order->status, ['pending', 'confirmed', 'assembled', 'shipped', 'delivered'])) {
                                                $activeOrderCount++;
                                            }
                                        }
                                        if ($activeOrderCount > 0) {
                                            echo '<span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold">' . $activeOrderCount . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <span class="text-sm text-gray-700">Orders</span>
                            </a>
                        </div>
                    </div>

                    <!-- Desktop Icons (Hidden on Mobile) -->
                    <div class="hidden sm:flex items-center gap-2">
                        <!-- Profile Icon -->
                        <a href="/customer/profile" class="header-icon" data-route="/customer/profile">
                            <svg class="w-6 h-6 text-gray-700 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span class="text-xs text-gray-600">Profile</span>
                        </a>

                        <!-- Cart Icon with Badge -->
                        <a href="/customer/my-cart" class="header-icon" data-route="/customer/my-cart">
                            <div class="relative">
                                <svg class="w-6 h-6 text-gray-700 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                                </svg>
                                <?php
                                if (auth()) {
                                    $cartItems = \app\models\Cart::whereMany(['user_id' => auth()->id]);
                                    $cartCount = count($cartItems);
                                    if ($cartCount > 0) {
                                        echo '<span class="my-badge" id="cartBadge">' . $cartCount . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            <span class="text-xs text-gray-600">My Cart</span>
                        </a>

                        <!-- Orders Icon -->
                        <a href="/customer/my-orders" class="header-icon" data-route="/customer/my-orders">
                            <div class="relative">
                                <svg class="w-6 h-6 text-gray-700 mb-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                                </svg>
                                <?php
                                if (auth()) {
                                    $pendingOrders = \app\models\Orders::whereMany(['user_id' => auth()->id]);
                                    $activeOrderCount = 0;
                                    foreach ($pendingOrders as $order) {
                                        if (in_array($order->status, ['pending', 'confirmed', 'assembled', 'shipped', 'delivered'])) {
                                            $activeOrderCount++;
                                        }
                                    }
                                    if ($activeOrderCount > 0) {
                                        echo '<span class="my-badge" id="orderBadge">' . $activeOrderCount . '</span>';
                                    }
                                }
                                ?>
                            </div>
                            <span class="text-xs text-gray-600">Orders</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="md:hidden bg-white border-b border-gray-200">
            <div class="container mx-auto px-4 py-2">
                <div class="relative">
                    <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" class="search-input" placeholder="Search Item" id="mobileSearchInput">
                </div>
            </div>
        </div>

        <!-- Breadcrumb Navigation -->
        <div class="bg-white">
            <div class="container mx-auto px-4 lg:px-8 py-3">
                <div class="flex items-center flex-wrap gap-1 text-xs sm:text-sm text-gray-500">
                    <a href="/customer/home" class="flex items-center text-gray-600 hover:text-[#815331] transition-colors duration-200">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Home
                    </a>
                    <?php
                    // Extract the main title part
                    $breadcrumbTitle = preg_replace('/^ABG Prime Builders Supplies Inc\. \| /', '', $title);

                    // Check if this is a category page
                    if (strpos($breadcrumbTitle, 'Category: ') === 0) {
                        $categoryName = str_replace('Category: ', '', $breadcrumbTitle);
                    ?>
                        <span class="text-gray-400">/</span>
                        <span class="text-gray-800 font-medium truncate max-w-xs sm:max-w-md"><?= htmlspecialchars($categoryName) ?></span>
                    <?php
                    }
                    // Check if this is a product page (has an item object)
                    elseif (isset($items) && is_object($items) && isset($items->category) && isset($items->item_name)) {
                    ?>
                        <span class="text-gray-400">/</span>
                        <a href="/customer/home/category/<?= urlencode($items->category) ?>" class="text-gray-600 hover:text-[#815331] transition-colors duration-200 truncate max-w-[120px] sm:max-w-[200px]">
                            <?= htmlspecialchars($items->category) ?>
                        </a>
                        <span class="text-gray-400">/</span>
                        <span class="text-gray-800 font-medium truncate max-w-[150px] sm:max-w-sm"><?= htmlspecialchars($items->item_name) ?></span>
                    <?php
                    }
                    // Check if this is a profile or other specific page
                    elseif ($breadcrumbTitle && $breadcrumbTitle !== 'Customer Dashboard') {
                    ?>
                        <span class="text-gray-400">/</span>
                        <span class="text-gray-800 font-medium truncate max-w-xs sm:max-w-md"><?= htmlspecialchars($breadcrumbTitle) ?></span>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </header>

    <div class="py-4 my-5">
        <div class="max-w-7xl mx-auto px-4">