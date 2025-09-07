<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">

    <!-- List.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js"></script>

    <script src="/assets/js/script.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="w-full bg-[#ECE5DF] shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 lg:px-8 py-4">
            <div class="flex items-center justify-between gap-6">
                <!-- Logo Section -->
                <a href="/customer/home">
                    <div class="logo-container">
                        <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" class="h-12 w-auto">
                        <div class="company-text">
                            <img src="/assets/img/abg-company-name.svg" alt="ABG Company Name" class="h-5 w-auto mt-1">
                            <img src="/assets/img/abg-company-subtitle.svg" alt="ABG Company Subtitle" class="h-4 w-auto mt-1">
                        </div>
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="search-container">
                    <div class="relative">
                        <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" class="search-input" placeholder="Search Item" id="searchInput">
                    </div>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center gap-2 flex-shrink-0">
                    <!-- Profile Icon -->
                    <a href="/customer/profile" class="header-icon">
                        <svg class="w-6 h-6 text-gray-700 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-xs text-gray-600">Profile</span>
                    </a>

                    <!-- Cart Icon with Badge -->
                    <a href="/customer/my-cart" class="header-icon">
                        <div class="relative">
                            <svg class="w-6 h-6 text-gray-700 mb-1 mr-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                            <span class="my-badge" id="cartBadge">
                                <?php
                                if (auth()) {
                                    $cartCount = \app\models\Cart::whereMany(['user_id' => auth()->id]);
                                    echo count($cartCount);
                                } else {
                                    echo '0';
                                }
                                ?>
                            </span>
                        </div>
                        <span class="text-xs text-gray-600">My Cart</span>
                    </a>

                    <!-- Orders Icon -->
                    <a href="/customer/my-orders" class="header-icon">
                        <div class="relative">
                            <svg class="w-6 h-6 text-gray-700 mb-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311L4.5 7.65311ZM12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM6.49896 9.97065L11 12.5765V17.625H13V12.5765L17.501 9.97066L16.499 8.2398L12 10.8445L7.50104 8.2398L6.49896 9.97065Z" />
                            </svg>
                            <span class="my-badge" id="cartBadge">
                                <?php
                                if (auth()) {
                                    $cartCount = \app\models\Orders::whereMany(['user_id' => auth()->id]);
                                    echo count($cartCount);
                                } else {
                                    echo '0';
                                }
                                ?>
                            </span>
                        </div>
                        <span class="text-xs text-gray-600">Orders</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    <nav class="bg-white border-b border-gray-200 py-3">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="/customer/home" class="flex items-center text-gray-600 hover:text-[#815331] transition-colors duration-200">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
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
                    <span class="text-gray-800 font-medium"><?= htmlspecialchars($categoryName) ?></span>
                <?php
                }
                // Check if this is a product page (has an item object)
                elseif (isset($items) && is_object($items) && isset($items->category) && isset($items->item_name)) {
                ?>
                    <span class="text-gray-400">/</span>
                    <a href="/customer/home/category/<?= urlencode($items->category) ?>" class="text-gray-600 hover:text-[#815331] transition-colors duration-200">
                        <?= htmlspecialchars($items->category) ?>
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-medium"><?= htmlspecialchars($items->item_name) ?></span>
                <?php
                }
                // Check if this is a profile or other specific page
                elseif ($breadcrumbTitle && $breadcrumbTitle !== 'Customer Dashboard') {
                ?>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-medium"><?= htmlspecialchars($breadcrumbTitle) ?></span>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="py-4 my-5">
        <div class="max-w-7xl mx-auto px-4">