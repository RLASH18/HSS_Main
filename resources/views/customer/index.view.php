<?php layout('customer/header') ?>

<div class="w-full bg-white border border-gray-100 rounded-lg shadow-sm" id="categories-section">
    <div class="container w-[90%] mx-auto p-6">
        <div class="flex justify-between items-center mb-2">
            <h1 class="text-3xl font-bold">Categories</h1>
            <?php if (!empty($selectedCategory)): ?>
                <div class="flex items-center">
                    <a href="/customer/home"
                        class="inline-flex items-center text-base text-[#815331] hover:underline font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        View All Items
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
    <div class="w-[80%] mx-auto p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mx-auto container">
            <?php foreach ($categories as $category): ?>
                <?php
                $categorySlug = strtolower(str_replace([' ', '&'], '_', $category));
                $imageName = $categorySlug . '.png';
                $isSelected = ($selectedCategory === $category);
                ?>
                <div class="flex items-center justify-center flex-col gap-2 m-2 <?= $isSelected ? 'border-2 border-[#815331] rounded-lg p-2' : '' ?>">
                    <a href="/customer/home/category/<?= urlencode($category) ?>">
                        <img src="/assets/img/customer_page_categories/<?= $imageName ?>" alt="<?= $category ?>" class="transition-transform duration-300 hover:scale-95">
                    </a>
                    <p class="<?= $isSelected ? 'text-[#815331] font-semibold' : 'text-gray-700 font-medium' ?>">
                        <?= $category ?>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<div class="w-full bg-white border border-gray-100 rounded-lg shadow-sm mt-8">
    <div id="item-list" class="container mx-auto p-6">
        <div class="grid list grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($items as $item): ?>
                <a href="/customer/item/<?= $item->id ?>" class="block-group">
                    <div class="border border-gray-300 rounded-md overflow-hidden shadow-sm hover:shadow-md transition">
                        <!-- product image -->
                        <img src="/storage/items-img/<?= $item->item_image ?>" alt="<?= $item->item_name ?>"
                            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">

                        <div class="p-4">
                            <!-- Price -->
                            <h5 class="item-price text-green-600 font-bold text-lg">
                                PHP <?= number_format($item->unit_price, 2) ?>
                            </h5>

                            <!-- Name -->
                            <p class="item-name text-gray-800 font-medium truncate">
                                <?= $item->item_name ?>
                            </p>

                            <!-- Quantity -->
                            <p class="text-sm text-gray-500 text-right">
                                Qty: <?= $item->quantity  ?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach ?>
        </div>

        <!-- Pagination -->
        <div class="pagination mt-6 flex justify-center"></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            valueNames: ['item-name', 'item-price'],
            page: 8, // Items per page
            pagination: true,
        }

        window.itemList = new List('item-list', options);
    });
</script>
<?php layout('customer/footer') ?>