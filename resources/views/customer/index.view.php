<?php layout('customer/header') ?>

<div class="w-full bg-white border border-gray-100 rounded-lg shadow-sm" id="categories-section">
    <div class="container w-[90%] mx-auto p-4 sm:p-6">
        <div class="flex items-center justify-between -mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold">Categories</h1>
            <?php if (!empty($selectedCategory)): ?>
                <div class="flex items-center">
                    <a href="/customer/home"
                        class="inline-flex items-center text-sm sm:text-base text-[#815331] hover:underline font-medium">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        View All Items
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="w-[90%] sm:w-[80%] mx-auto p-4 sm:p-6">
        <div class="container grid grid-cols-2 mx-auto sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-4">
            <?php foreach ($categories as $category): ?>
                <?php
                $categorySlug = strtolower(str_replace([' ', '&'], '_', $category));
                $imageName = $categorySlug . '.png';
                $isSelected = ($selectedCategory === $category);
                ?>
                <div class="flex items-center justify-center flex-col gap-1 sm:gap-2 p-2 <?= $isSelected ? 'border-2 border-[#815331] rounded-lg' : '' ?>">
                    <a href="/customer/home/category/<?= urlencode($category) ?>">
                        <img data-src="/assets/img/customer_page_categories/<?= $imageName ?>" 
                            alt="<?= $category ?>"
                            class="lazy-image transition-transform duration-300 hover:scale-95 w-full opacity-0">
                    </a>
                    <p class="text-xs sm:text-sm text-center <?= $isSelected ? 'text-[#815331] font-semibold' : 'text-gray-700 font-medium' ?>">
                        <?= $category ?>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div class="w-full mt-4 sm:mt-8 bg-white border border-gray-100 rounded-lg shadow-sm">
    <div class="container p-4 sm:p-6 mx-auto">
        <!-- Mobile Filter Toggle Button -->
        <button id="mobile-filter-toggle" class="lg:hidden w-full mb-4 px-4 py-2 bg-[#815331] text-white rounded-lg flex items-center justify-center gap-2 hover:bg-[#6d4429] transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            <span class="font-medium">Filters</span>
        </button>

        <div class="flex gap-4 lg:gap-6">
            <!-- Filter Sidebar -->
            <div id="filter-sidebar" class="hidden lg:block flex-shrink-0 w-full lg:w-64 bg-gray-100 border border-gray-100 rounded-lg fixed lg:relative inset-0 lg:inset-auto z-40 lg:z-auto overflow-y-auto">
                <!-- Mobile Close Button -->
                <div class="lg:hidden flex justify-between items-center p-4 border-b border-gray-200 bg-white sticky top-0">
                    <h2 class="text-lg font-bold text-gray-800">Filters</h2>
                    <button id="close-filter" class="p-2 hover:bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-4">
                    <!-- Availability Filter -->
                    <div class="mb-6 sm:mb-8">
                        <h3 class="mb-2 sm:mb-3 font-semibold text-gray-800 text-sm sm:text-base">Availability</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 rounded-full focus:ring-[#815331] availability-filter" value="in-stock"
                                    style="accent-color: #000;">
                                <span class="ml-1 text-sm text-gray-700">In stock</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="w-4 h-4 rounded-full availability-filter" value="out-of-stock"
                                    style="accent-color: red;">
                                <span class="ml-1 text-sm text-gray-700">Out of stock</span>
                            </label>
                        </div>
                    </div>

                    <!-- Price Filter -->
                    <div class="mb-6 sm:mb-8">
                        <h3 class="flex items-center justify-between mb-2 sm:mb-3 font-semibold text-gray-800 text-sm sm:text-base">Price</h3>
                        <div class="space-y-3">
                            <p class="text-sm text-gray-600">The highest price is <span class="text-[#815331] font-bold">₱</span><span class="text-[#815331] font-bold" id="max-price"><?= number_format($maxPrice ?? 0, 2) ?></span></p>
                            <div class="relative">
                                <input type="range" id="price-range"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer" min="0"
                                    max="<?= $maxPrice ?? 0 ?>" value="<?= $maxPrice ?? 0 ?>" step="1">
                            </div>
                            <div class="flex justify-between mt-2 text-center">
                                <span class="text-sm font-medium text-gray-700">
                                    Min: ₱
                                    <input type="number" id="current-min-price"
                                        class="w-20 text-sm border border-gray-300 focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-all rounded px-2 py-1 ml-1 mt-1"
                                        value="0" min="0" max="<?= $maxPrice ?? 0 ?>">
                                </span>
                                <div class="flex flex-col items-center justify-center mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mt-4" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">
                                    Max: ₱
                                    <input type="number" id="current-max-price"
                                        class="w-20 text-sm border border-gray-300 focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-all rounded px-2 py-1 mt-1"
                                        value="<?= $maxPrice ?? 0 ?>" min="0" max="<?= $maxPrice ?? 0 ?>">
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Brand Filter -->
                    <div class="mb-6 sm:mb-8">
                        <h3 class="flex items-center justify-between mb-2 sm:mb-3 font-semibold text-gray-800 text-sm sm:text-base">Brand</h3>
                        <div class="space-y-2" id="brand-filters">
                            <!-- Brands will be populated dynamically -->
                        </div>
                        <button class="mt-2 text-sm text-blue-600 hover:underline" id="show-more-brands">Show more</button>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="flex-1" id="item-list">
                <div class="grid grid-cols-2 gap-4 list sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <?php foreach ($items as $item): ?>
                        <a href="/customer/item/<?= $item->id ?>" class="block-group">
                            <div class="overflow-hidden transition-all duration-300 bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-lg hover:-translate-y-1">
                                <!-- Product Image Container -->
                                <div class="flex items-center justify-center h-40 sm:h-48 p-2 bg-gray-100 relative overflow-hidden">
                                    <!-- Shimmer Loading Placeholder -->
                                    <div class="lazy-placeholder absolute inset-0 bg-gradient-to-r from-gray-200 via-gray-300 to-gray-200 animate-shimmer"></div>
                                    
                                    <!-- Lazy Loaded Image -->
                                    <img data-src="/storage/items-img/<?= $item->item_image_1 ?>" 
                                        alt="<?= $item->item_name ?>"
                                        class="lazy-image object-contain max-w-full max-h-full transition-all duration-500 opacity-0 group-hover:scale-105">
                                </div>

                                <div class="p-3 sm:p-4 space-y-2">
                                    <!-- Name -->
                                    <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate item-name line-clamp-2">
                                        <?= $item->item_name ?>
                                    </h3>

                                    <!-- Price -->
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="item-price text-[#815331] font-bold text-sm sm:text-base" data-price="<?= $item->unit_price ?>">
                                            ₱<?= number_format($item->unit_price, 2) ?>
                                        </span>

                                        <!-- Stock status badge -->
                                        <?php if ($item->quantity > 0): ?>
                                            <span class="px-1.5 py-0.5 text-[10px] sm:text-xs font-medium text-white bg-green-600 rounded-full whitespace-nowrap">
                                                In Stock
                                            </span>
                                        <?php else: ?>
                                            <span class="px-1.5 py-0.5 text-[10px] sm:text-xs font-medium text-white bg-red-600 rounded-full whitespace-nowrap">
                                                Out of Stock
                                            </span>
                                        <?php endif ?>
                                    </div>

                                    <!-- Brand (hidden for filtering) -->
                                    <span class="hidden item-brand" data-brand="<?= $item->brand_name ?>">
                                        <?= $item->brand_name ?>
                                    </span>

                                    <!-- Availability (hidden for filtering) -->
                                    <span class="hidden item-availability" data-availability="<?= $item->quantity > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                        <?= $item->quantity > 0 ? 'in-stock' : 'out-of-stock' ?>
                                    </span>

                                    <!-- Stock Quantity -->
                                    <div class="flex justify-end text-xs sm:text-sm text-gray-500">
                                        <span class="text-right">(<?= $item->quantity ?>) available</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-6 pagination"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile filter toggle functionality
        const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
        const filterSidebar = document.getElementById('filter-sidebar');
        const closeFilter = document.getElementById('close-filter');

        if (mobileFilterToggle && filterSidebar) {
            mobileFilterToggle.addEventListener('click', function() {
                filterSidebar.classList.remove('hidden');
                filterSidebar.classList.add('block');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });

            if (closeFilter) {
                closeFilter.addEventListener('click', function() {
                    filterSidebar.classList.add('hidden');
                    filterSidebar.classList.remove('block');
                    document.body.style.overflow = ''; // Restore scrolling
                });
            }

            // Close filter when clicking outside on mobile
            filterSidebar.addEventListener('click', function(e) {
                if (e.target === filterSidebar) {
                    filterSidebar.classList.add('hidden');
                    filterSidebar.classList.remove('block');
                    document.body.style.overflow = '';
                }
            });
        }

        // Initialize List.js WITHOUT pagination (we'll handle it manually)
        var options = {
            valueNames: [
                'item-name',
                'item-price',
                {
                    name: 'price',
                    attr: 'data-price'
                },
                {
                    name: 'brand',
                    attr: 'data-brand'
                },
                {
                    name: 'availability',
                    attr: 'data-availability'
                }
            ],
            page: 16, // Items per page
            pagination: false, // Disable List.js pagination
        }

        window.itemList = new List('item-list', options);

        // Custom pagination with URL query parameters
        function setupCustomPagination() {
            const itemsPerPage = 16;
            const totalItems = itemList.matchingItems.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            
            // Get current page from URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = parseInt(urlParams.get('page')) || 1;
            
            // Show items for current page
            itemList.show((currentPage - 1) * itemsPerPage + 1, itemsPerPage);
            
            // Generate pagination HTML
            const paginationContainer = document.querySelector('.pagination');
            if (!paginationContainer) return;
            
            let paginationHTML = '';
            
            // Previous button
            if (currentPage > 1) {
                const prevPage = currentPage - 1;
                const prevUrl = prevPage === 1 ? window.location.pathname : `?page=${prevPage}`;
                paginationHTML += `<a href="${prevUrl}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>`;
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHTML += `<span class="px-3 py-2 text-sm font-medium text-white bg-[#815331] border border-[#815331] rounded-md">${i}</span>`;
                } else {
                    // For page 1, use clean URL without query parameter
                    const pageUrl = i === 1 ? window.location.pathname : `?page=${i}`;
                    paginationHTML += `<a href="${pageUrl}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">${i}</a>`;
                }
            }
            
            // Next button
            if (currentPage < totalPages) {
                paginationHTML += `<a href="?page=${currentPage + 1}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>`;
            }
            
            paginationContainer.innerHTML = paginationHTML;
        }
        
        // Initial pagination setup
        setupCustomPagination();

        // Get unique brands from items - wait for List.js to initialize
        setTimeout(() => {
            const items = document.querySelectorAll('.list .block-group');
            const brands = new Set();

            items.forEach(item => {
                const brand = item.querySelector('.item-brand')?.dataset.brand;
                if (brand) brands.add(brand);
            });

            // Populate brand filters
            const brandContainer = document.getElementById('brand-filters');
            let brandCount = 0;
            brands.forEach(brand => {
                const isVisible = brandCount < 5;
                brandContainer.innerHTML += `
                    <label class="flex items-center ${!isVisible ? 'hidden brand-extra' : ''}">
                        <input type="checkbox" class="w-4 h-4 rounded-full focus:ring-[#815331] brand-filter" value="${brand}" checked>
                        <span class="ml-1 text-sm text-gray-700">${brand}</span>
                    </label>
                `;
                brandCount++;
            });

            // Attach event listeners after populating filters
            attachFilterListeners();
        }, 100);


        document.getElementById('show-more-brands').addEventListener('click', function() {
            const hiddenBrands = document.querySelectorAll('.brand-extra');
            hiddenBrands.forEach(brand => brand.classList.toggle('hidden'));
            this.textContent = this.textContent === 'Show less' ? 'Show more' : 'Show less';
        });

        // Filter function - completely rewritten for better compatibility
        function applyFilters() {
            const availabilityFilters = Array.from(document.querySelectorAll('.availability-filter:checked')).map(cb => cb.value);
            const brandFilters = Array.from(document.querySelectorAll('.brand-filter:checked')).map(cb => cb.value);
            const minPriceValue = parseFloat(document.getElementById('current-min-price').value) || 0;
            const maxPriceValue = parseFloat(document.getElementById('current-max-price').value) || 999999;

            // Get all product items directly
            const allItems = document.querySelectorAll('.list .block-group');

            allItems.forEach(item => {
                const itemPrice = parseFloat(item.querySelector('.item-price')?.dataset.price || 0);
                const itemBrand = item.querySelector('.item-brand')?.dataset.brand || '';
                const itemAvailability = item.querySelector('.item-availability')?.dataset.availability ||
                    '';

                const priceMatch = itemPrice >= minPriceValue && itemPrice <= maxPriceValue;
                const brandMatch = brandFilters.length === 0 || brandFilters.includes(itemBrand);
                const availabilityMatch = availabilityFilters.length === 0 || availabilityFilters.includes(
                    itemAvailability);

                const shouldShow = priceMatch && brandMatch && availabilityMatch;

                // Show/hide items directly
                if (shouldShow) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Update pagination after filtering
            setupCustomPagination();
        }

        // Price range inputs
        const currentMinPrice = document.getElementById('current-min-price');
        const currentMaxPrice = document.getElementById('current-max-price');

        currentMinPrice.addEventListener('input', function() {
            applyFilters();
        });

        currentMaxPrice.addEventListener('input', function() {
            applyFilters();
        });

        // Event listeners for filters (after dynamic population)
        function attachFilterListeners() {
            document.querySelectorAll('.availability-filter, .brand-filter').forEach(checkbox => {
                checkbox.addEventListener('change', applyFilters);
            });
        }

        // Price range slider
        const priceRange = document.getElementById('price-range');

        priceRange.addEventListener('input', function() {
            // Update the price input field
            document.getElementById('current-max-price').value = this.value;
            applyFilters();
        });

        // ============================================
        // LAZY LOADING SYSTEM - Simple & Effective
        // ============================================
        
        // Wait for pagination to be set up, then initialize lazy loading
        setTimeout(() => {
            const lazyImages = document.querySelectorAll('.lazy-image');
            
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        
                        // Check if the image's parent container is actually visible (not hidden by pagination)
                        const parentCard = img.closest('.block-group');
                        if (parentCard && window.getComputedStyle(parentCard).display === 'none') {
                            return; // Skip loading if parent is hidden
                        }
                        
                        const placeholder = img.previousElementSibling;
                        
                        // Load the image
                        img.src = img.dataset.src;
                        
                        // When image loads successfully
                        img.onload = () => {
                            // Remove shimmer placeholder
                            if (placeholder && placeholder.classList.contains('lazy-placeholder')) {
                                placeholder.style.opacity = '0';
                                setTimeout(() => placeholder.remove(), 300);
                            }
                            
                            // Fade in the image with cool effect
                            img.style.opacity = '1';
                            img.classList.add('loaded');
                        };
                        
                        // Handle image load errors
                        img.onerror = () => {
                            if (placeholder && placeholder.classList.contains('lazy-placeholder')) {
                                placeholder.remove();
                            }
                            img.style.opacity = '0.5';
                            img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"%3E%3Crect fill="%23f0f0f0" width="100" height="100"/%3E%3Ctext x="50" y="50" font-family="Arial" font-size="14" fill="%23999" text-anchor="middle" dy=".3em"%3ENo Image%3C/text%3E%3C/svg%3E';
                        };
                        
                        // Stop observing this image
                        observer.unobserve(img);
                    }
                });
            }, {
                // Load images 200px before they enter viewport
                rootMargin: '200px',
                threshold: 0.01
            });
            
            // Start observing all lazy images
            lazyImages.forEach(img => imageObserver.observe(img));
            
            // Fallback for browsers without Intersection Observer
            if (!('IntersectionObserver' in window)) {
                lazyImages.forEach(img => {
                    img.src = img.dataset.src;
                    img.style.opacity = '1';
                    const placeholder = img.previousElementSibling;
                    if (placeholder && placeholder.classList.contains('lazy-placeholder')) {
                        placeholder.remove();
                    }
                });
            }
        }, 200); // Wait 200ms for pagination to complete
    });
</script>

<?php layout('customer/footer') ?>