<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/script.js"></script>
    <style>
    .search-container {
        position: relative;
        flex-grow: 1;
        max-width: 500px;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 45px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }

    .search-input:focus {
        border-color: #815331;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .header-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 6px;
        transition: background-color 0.2s;
        text-decoration: none;
        color: inherit;
        min-width: 60px;
    }

    .header-icon:hover {
        background-color: #f3f4f6;
    }

    .cart-badge {
        position: absolute;
        top: -8px;
        right: -7px;
        background-color: #ef4444;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: bold;
    }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Modern E-commerce Header -->
    <header class="w-full bg-[#ECE5DF] shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4 lg:px-8 py-4">
            <div class="flex items-center justify-between gap-6">
                <!-- Logo Section -->
                <div class="logo-container">
                    <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" class="h-12 w-auto">
                    <div class="company-text">
                        <img src="/assets/img/abg-company-name.svg" alt="ABG Company Name" class="h-5 w-auto mt-1">
                        <img src="/assets/img/abg-company-subtitle.svg" alt="ABG Company Subtitle"
                            class="h-4 w-auto mt-1">
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-container">
                    <div class="relative">
                        <svg class="search-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" class="search-input" placeholder="Search Item" id="searchInput">
                    </div>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center gap-2 flex-shrink-0">
                    <!-- Profile Icon -->
                    <a href="/customer/profile" class="header-icon">
                        <svg class="w-6 h-6 text-gray-700 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
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
                            <span class="cart-badge" id="cartBadge">
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
                        <span class="text-xs text-gray-600">Your Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="py-4 my-5">
        <div class="max-w-6xl mx-auto px-4">