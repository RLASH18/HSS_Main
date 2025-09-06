<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="mb-2 text-3xl font-bold text-black-900"><?= ucfirst($items->item_name) ?></h1>
            <p class="text-black-600">Check the details and choose quantity to buy</p>
        </div>
        <a href="/customer/home"
            class="inline-flex items-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<div class="w-full p-8 mt-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <!-- Product Layout -->
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
        <!-- Product Images Gallery -->
        <div class="space-y-4">
            <!-- Main Image Display -->
            <div class="relative p-8 bg-gray-50 rounded-2xl">
                <img id="mainImage" src="/storage/items-img/<?= $items->item_image_1 ?>" alt="<?= $items->item_name ?>"
                    class="object-contain w-full transition-transform cursor-pointer h-96 hover:scale-105">
            </div>

            <!-- Image Gallery Thumbnails -->
            <div class="flex space-x-3">
                <div class="flex items-center mr-4 text-sm text-gray-500">
                    <span id="currentImageIndex">1</span> / <span id="totalImages">3</span> images
                </div>
                <div class="flex space-x-2">
                    <button onclick="selectImage(0)" class="thumbnail-btn border-2 border-[#815331] rounded-lg overflow-hidden w-16 h-16">
                        <img src="/storage/items-img/<?= $items->item_image ?>" alt="Image 1" class="object-cover w-full h-full">
                    </button>
                    <button onclick="selectImage(1)" class="w-16 h-16 overflow-hidden border-2 border-gray-200 rounded-lg thumbnail-btn opacity-60">
                        <img src="/storage/items-img/<?= $items->item_image_2 ?>" alt="Image 2" class="object-cover w-full h-full">
                    </button>
                    <button onclick="selectImage(2)" class="w-16 h-16 overflow-hidden border-2 border-gray-200 rounded-lg thumbnail-btn opacity-40">
                        <img src="/storage/items-img/<?= $items->item_image_3 ?>" alt="Image 3" class="object-cover w-full h-full">
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <!-- Category Badge -->
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#815331] text-white">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <?= $items->category ?>
                </span>
            </div>

            <!-- Product Title -->
            <h1 class="text-3xl font-bold text-gray-900"><?= ucfirst($items->item_name) ?></h1>

            <!-- Supplier Info -->
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Supplied by: <span class="ml-1 font-medium"><?= $items->supplier_name ?></span>
            </div>

            <!-- Stock Status -->
            <div class="flex items-center space-x-2">
                <?php if ($items->quantity > 10): ?>
                    <div class="flex items-center text-green-600">
                        <div class="w-2 h-2 mr-2 bg-green-500 rounded-full"></div>
                        <span class="text-sm font-medium">In Stock (<?= $items->quantity ?> available)</span>
                    </div>
                <?php elseif ($items->quantity > 0): ?>
                    <div class="flex items-center text-orange-600">
                        <div class="w-2 h-2 mr-2 bg-orange-500 rounded-full"></div>
                        <span class="text-sm font-medium">Low Stock (<?= $items->quantity ?> left)</span>
                    </div>
                <?php else: ?>
                    <div class="flex items-center text-red-600">
                        <div class="w-2 h-2 mr-2 bg-red-500 rounded-full"></div>
                        <span class="text-sm font-medium">Out of Stock</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Price -->
            <div class="text-4xl font-bold text-[#815331]">
                ₱<?= number_format($items->unit_price, 2) ?>
                <span class="text-lg font-normal text-gray-500">per unit</span>
            </div>

            <!-- Form -->
            <form action="/customer/add-to-cart" method="post" class="space-y-6">
                <?= csrf_token() ?>
                <input type="hidden" name="item_id" value="<?= $items->id ?>">

                <!-- Quantity Selector -->
                <div class="space-y-3">
                    <label class="text-lg font-semibold text-gray-900">Quantity:</label>
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="decreaseQty()"
                            class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#815331] hover:text-[#815331] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>

                        <input type="number" id="qtyInput" value="1" min="1" max="<?= $items->quantity ?>" class="w-24 text-lg text-center font-semibold border-2 border-gray-300 rounded-lg py-2 focus:border-[#815331] focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                            onchange="updateQtyFromInput()" oninput="updateQtyFromInput()">

                        <button type="button" onclick="increaseQty()"
                            class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#815331] hover:text-[#815331] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" name="quantity" id="quantity" value="1">
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="button" onclick="buyNow()" id="buyNowBtn"
                        class="w-full bg-[#815331] text-white font-semibold py-4 px-6 rounded-lg hover:bg-[#6d4529] transition-colors flex items-center justify-center space-x-2 <?= $items->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                        <?= $items->quantity == 0 ? 'disabled' : '' ?>>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>Buy Now</span>
                    </button>

                    <button type="submit" id="addToCartBtn"
                        class="w-full bg-white border-2 border-[#815331] text-[#815331] font-semibold py-4 px-6 rounded-lg hover:bg-[#815331] hover:text-white transition-colors flex items-center justify-center space-x-2 <?= $items->quantity == 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                        <?= $items->quantity == 0 ? 'disabled' : '' ?>>
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z" />
                        </svg>
                        <span>Add to Cart</span>
                    </button>
                </div>
            </form>

            <!-- Product Features -->
            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Quality Assured</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Fast Delivery</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Secure Payment</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Return Policy</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Information Tabs -->
    <div class="pt-4 mt-12 border-t border-gray-200">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px space-x-8">
                <button onclick="showTab('description')" id="tab-description" class="tab-button border-transparent text-gray-500 hover:text-[#815331] hover:border-[#815331] whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm active">
                    Description
                </button>
                <button onclick="showTab('specifications')" id="tab-specifications" class="tab-button border-transparent text-gray-500 hover:text-[#815331] hover:border-[#815331] whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Specifications
                </button>
                <button onclick="showTab('delivery')" id="tab-delivery" class="tab-button border-transparent text-gray-500 hover:text-[#815331] hover:border-[#815331] whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Delivery Info
                </button>
            </nav>
        </div>

        <div class="mt-6">
            <!-- Description Tab -->
            <div id="content-description" class="tab-content">
                <div class="p-6 prose max-w-none">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900">Product Description</h3>
                    <p class="leading-relaxed text-gray-700"><?= $items->description ?></p>
                </div>
            </div>

            <!-- Specifications Tab -->
            <div id="content-specifications" class="hidden tab-content">
                <div class="space-y-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <div class="p-6 rounded-lg">
                            <h3 class="flex items-center mb-6 text-lg font-semibold text-gray-900">
                                <svg class="w-5 h-5 mr-2 text-[#815331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Product Details
                            </h3>
                            <dl class="space-y-4">
                                <div class="flex flex-col pb-3 border-b border-gray-200 sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Category:</dt>
                                    <dd class="text-sm font-medium text-gray-900"><?= $items->category ?></dd>
                                </div>
                                <div class="flex flex-col pb-3 border-b border-gray-200 sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Supplier:</dt>
                                    <dd class="text-sm font-medium text-gray-900"><?= $items->supplier_name ?></dd>
                                </div>
                                <div class="flex flex-col pb-3 border-b border-gray-200 sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Stock Available:</dt>
                                    <dd class="text-sm font-medium text-gray-900"><?= $items->quantity ?> units</dd>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Unit Price:</dt>
                                    <dd class="text-sm font-medium text-gray-900">₱<?= number_format($items->unit_price, 2) ?></dd>
                                </div>
                            </dl>
                        </div>
                        <div class="p-6 rounded-lg">
                            <h3 class="flex items-center mb-6 text-lg font-semibold text-gray-900">
                                <svg class="w-5 h-5 mr-2 text-[#815331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Additional Information
                            </h3>
                            <dl class="space-y-4">
                                <div class="flex flex-col pb-3 border-b border-gray-200 sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Warranty:</dt>
                                    <dd class="text-sm font-medium text-gray-900">Manufacturer Warranty</dd>
                                </div>
                                <div class="flex flex-col pb-3 border-b border-gray-200 sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Return Policy:</dt>
                                    <dd class="text-sm font-medium text-gray-900">7 days return</dd>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between">
                                    <dt class="mb-1 text-sm font-medium text-gray-600 sm:mb-0">Shipping:</dt>
                                    <dd class="text-sm font-medium text-gray-900">Standard delivery</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delivery Info Tab -->
            <div id="content-delivery" class="hidden tab-content">
                <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2">
                    <div>
                        <h3 class="flex items-center mb-6 text-lg font-semibold text-gray-900">
                            <svg class="w-5 h-5 mr-2 text-[#815331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Delivery Options
                        </h3>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-[#815331] rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 11.6458V21C21 21.5523 20.5523 22 20 22H4C3.44772 22 3 21.5523 3 21V11.6458C2.37764 10.9407 2 10.0144 2 9V3C2 2.44772 2.44772 2 3 2H21C21.5523 2 22 2.44772 22 3V9C22 10.0144 21.6224 10.9407 21 11.6458ZM19 12.874C18.6804 12.9562 18.3453 13 18 13C16.8053 13 15.7329 12.4762 15 11.6458C14.2671 12.4762 13.1947 13 12 13C10.8053 13 9.73294 12.4762 9 11.6458C8.26706 12.4762 7.19469 13 6 13C5.6547 13 5.31962 12.9562 5 12.874V20H19V12.874ZM14 9C14 8.44772 14.4477 8 15 8C15.5523 8 16 8.44772 16 9C16 10.1046 16.8954 11 18 11C19.1046 11 20 10.1046 20 9V4H4V9C4 10.1046 4.89543 11 6 11C7.10457 11 8 10.1046 8 9C8 8.44772 8.44772 8 9 8C9.55228 8 10 8.44772 10 9C10 10.1046 10.8954 11 12 11C13.1046 11 14 10.1046 14 9Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 m2-1">Store Pickup</p>
                                    <p class="mb-1 text-sm text-gray-600">Free pickup from our store location</p>
                                    <p class="text-xs text-gray-500">Available during business hours</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-[#815331] rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="mb-1 font-semibold text-gray-900">Home Delivery</p>
                                    <p class="mb-1 text-sm text-gray-600">Delivery to your doorstep within 2-3 business days</p>
                                    <p class="text-xs text-gray-500">Delivery fee may apply</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="flex items-center mb-6 text-lg font-semibold text-gray-900">
                            <svg class="w-5 h-5 mr-2 text-[#815331]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Payment Methods
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-green-100 rounded-full">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Cash on Delivery</span>
                                    <p class="text-xs text-gray-500">Pay when you receive your order</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-green-100 rounded-full">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">GCash Payment</span>
                                    <p class="text-xs text-gray-500">Secure digital wallet payment</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 bg-green-100 rounded-full">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Bank Transfer</span>
                                    <p class="text-xs text-gray-500">Direct bank account transfer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let qty = 1;
    let maxQty = <?= $items->quantity ?>;
    let qtyElement = document.getElementById("qtyInput");
    let qtyInput = document.getElementById("quantity");
    let addBtn = document.getElementById("addToCartBtn");
    let buyBtn = document.getElementById("buyNowBtn");

    // Image gallery functionality
    const images = [
        <?php if (!empty($items->item_image_1)): ?> "<?= '/storage/items-img/' . $items->item_image_1 ?>"<?php endif ?>
        <?php if (!empty($items->item_image_2)): ?><?= !empty($items->item_image_1) ? ',' : '' ?> "<?= '/storage/items-img/' . $items->item_image_2 ?>"<?php endif ?>
        <?php if (!empty($items->item_image_3)): ?><?= (!empty($items->item_image_1) || !empty($items->item_image_2)) ? ',' : '' ?> "<?= '/storage/items-img/' . $items->item_image_3 ?>"<?php endif ?>
    ].filter(Boolean); // Remove any empty values

    let currentImageIndex = 0;
    const totalImages = images.length;

    // Update total images display
    document.getElementById('totalImages').textContent = totalImages;

    // Hide thumbnails if less than 2 images
    if (totalImages < 2) {
        const thumbnailContainer = document.querySelector('.flex.space-x-3');
        if (thumbnailContainer) {
            thumbnailContainer.style.display = 'none';
        }
    } else {
        // Show only available thumbnails
        const thumbnailButtons = document.querySelectorAll('.thumbnail-btn');
        thumbnailButtons.forEach((btn, index) => {
            if (index >= totalImages) {
                btn.style.display = 'none';
            } else {
                // Update thumbnail image source
                const img = btn.querySelector('img');
                if (img && images[index]) {
                    img.src = images[index];
                }
            }
        });
    }

    function selectImage(index) {
        if (index >= totalImages) return;

        currentImageIndex = index;
        const mainImg = document.getElementById('mainImage');
        if (mainImg && images[index]) {
            mainImg.src = images[index];
        }
        document.getElementById('currentImageIndex').textContent = index + 1;

        // Update thumbnail borders
        document.querySelectorAll('.thumbnail-btn').forEach((btn, i) => {
            if (i < totalImages) {
                if (i === index) {
                    btn.classList.remove('border-gray-200', 'opacity-60', 'opacity-40');
                    btn.classList.add('border-[#815331]');
                } else {
                    btn.classList.remove('border-[#815331]');
                    btn.classList.add('border-gray-200');
                    if (i === 1) btn.classList.add('opacity-60');
                    if (i === 2) btn.classList.add('opacity-40');
                }
            }
        });
    }

    // Tab functionality
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active', 'border-[#815331]', 'text-[#815331]');
            button.classList.add('border-transparent', 'text-gray-500');
        });

        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');

        // Add active class to selected tab button
        const activeButton = document.getElementById('tab-' + tabName);
        activeButton.classList.remove('border-transparent', 'text-gray-500');
        activeButton.classList.add('active', 'border-[#815331]', 'text-[#815331]');
    }

    function updateBtnState() {
        const isOutOfStock = maxQty === 0;
        const isOverStock = qty > maxQty;

        addBtn.disabled = isOutOfStock || isOverStock;
        buyBtn.disabled = isOutOfStock || isOverStock;

        if (isOutOfStock) {
            addBtn.classList.add('opacity-50', 'cursor-not-allowed');
            buyBtn.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            buyBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    function increaseQty() {
        if (qty < maxQty) {
            qty++;
            qtyElement.value = qty;
            qtyInput.value = qty;
            updateBtnState();
        }
    }

    function decreaseQty() {
        if (qty > 1) {
            qty--;
            qtyElement.value = qty;
            qtyInput.value = qty;
            updateBtnState();
        }
    }

    function updateQtyFromInput() {
        let inputValue = parseInt(qtyElement.value);

        if (isNaN(inputValue) || inputValue < 1) {
            inputValue = 1;
        } else if (inputValue > maxQty) {
            inputValue = maxQty;
        }

        qty = inputValue;
        qtyElement.value = qty;
        qtyInput.value = qty;
        updateBtnState();
    }

    function buyNow() {
        if (maxQty === 0 || qty > maxQty) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/customer/buy-now';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '<?= $_SESSION["_csrf"] ?? "" ?>';
        form.appendChild(csrfInput);

        const itemIdInput = document.createElement('input');
        itemIdInput.type = 'hidden';
        itemIdInput.name = 'item_id';
        itemIdInput.value = '<?= $items->id ?>';
        form.appendChild(itemIdInput);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = qty;
        form.appendChild(quantityInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Initialize
    updateBtnState();
    showTab('description'); // Show description tab by default
</script>

<?php layout('customer/footer') ?>