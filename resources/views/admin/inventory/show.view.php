<?php layout('admin/header') ?>

<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold text-gray-900">Inventory Item Details</h1>
        <p class="text-gray-600">View detailed information about this inventory item</p>
    </div>
    <div class="flex space-x-3">
        <a href="/admin/inventory"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Inventory
        </a>
    </div>
</div>

<div>
    <?php if ($inventory->quantity <= 0): ?>
        <!-- Out of Stock Alert -->
        <div class="bg-red-50 border-red-200 text-red-800 border rounded-lg p-4 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Out of Stock</h3>
                    <div class="mt-1 text-sm">
                        <p>Current stock: <?= $inventory->quantity ?> units</p>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($inventory->quantity <= $inventory->restock_threshold): ?>
        <!-- Low Stock Alert -->
        <div class="bg-yellow-50 border-yellow-200 text-yellow-800 border rounded-lg p-4 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Low Stock - Restock Needed</h3>
                    <div class="mt-1 text-sm">
                        <p>Current stock: <?= $inventory->quantity ?> units</p>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- In Stock Alert -->
        <div class="bg-green-50 border-green-200 text-green-800 border rounded-lg p-4 mb-8">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">In Stock</h3>
                    <div class="mt-1 text-sm">
                        <p>Current stock: <?= $inventory->quantity ?> units</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <!-- 2-Column Grid Layout -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

        <!-- Left Column -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Basic Information</h3>

            <!-- ID -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Item ID</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    #<?= str_pad($inventory->id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <!-- Brand Name -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">brand Name</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->brand_name ?>
                </div>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Item Name</label>
                <div class="w-full px-4 py-3 text-[#815331] font-bold border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->item_name ?>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 min-h-[100px]">
                    <div class="[&_h1]:text-3xl [&_h1]:font-bold [&_h1]:mb-4 [&_h2]:text-xl [&_h2]:font-bold [&_h2]:mb-3 [&_ol]:list-decimal [&_ol]:ml-6 [&_ol]:mb-4 [&_ul]:list-disc [&_ul]:ml-6 [&_ul]:mb-4 [&_li]:mb-2 [&_strong]:font-bold [&_em]:italic [&_u]:underline [&_p]:mb-4">
                        <?= html_entity_decode($inventory->description ?? 'No description provided') ?>
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Category</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->category ?>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 gap-4">
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Created At</label>
                    <div class="w-full px-4 py-3 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50">
                        <?= date('M d, Y \a\t g:i A', strtotime($inventory->created_at)) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Last Updated</label>
                    <div class="w-full px-4 py-3 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50">
                        <?= date('M d, Y \a\t g:i A', strtotime($inventory->updated_at)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Pricing & Stock</h3>

            <!-- Unit Price -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Unit Price</label>
                <div class="w-full px-4 py-3 text-[#815331] font-bold border border-gray-200 rounded-lg bg-gray-50">
                    ₱<?= number_format($inventory->unit_price, 2) ?>
                </div>
            </div>

            <!-- Stock Information -->
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Current Stock</label>
                    <?php
                    // Decide stock status color
                    if ($inventory->quantity <= 0) {
                        $stockClass = "text-red-600";
                    } elseif ($inventory->quantity <= $inventory->restock_threshold) {
                        $stockClass = "text-orange-600";
                    } else {
                        $stockClass = "text-green-600";
                    }
                    ?>
                    <div class="w-full px-4 py-3 font-semibold text-center border rounded-lg <?= $stockClass ?>">
                        <?= $inventory->quantity ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Restock Level</label>
                    <div class="w-full px-4 py-3 font-semibold text-center text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                        <?= $inventory->restock_threshold ?>
                    </div>
                </div>
            </div>

            <!-- Item Images Gallery -->
            <?php
            $images = [];
            if (!empty($inventory->item_image_1)) $images[] = $inventory->item_image_1;
            if (!empty($inventory->item_image_2)) $images[] = $inventory->item_image_2;
            if (!empty($inventory->item_image_3)) $images[] = $inventory->item_image_3;
            ?>

            <?php if (!empty($images)): ?>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Item Images (<?= count($images) ?> image<?= count($images) > 1 ? 's' : '' ?>)
                    </label>

                    <!-- Main Image Display -->
                    <div class="w-full p-2 mb-4 overflow-hidden border border-gray-200 rounded-lg shadow-sm">
                        <img id="mainImage" src="/storage/items-img/<?= $images[0] ?>" alt="<?= $inventory->item_name ?>"
                            class="object-contain w-full max-h-96">
                    </div>

                    <!-- Thumbnail Gallery (only show if more than 1 image) -->
                    <?php if (count($images) > 1): ?>
                        <div class="flex space-x-2 overflow-x-auto">
                            <?php foreach ($images as $index => $image): ?>
                                <button type="button" onclick="selectImage(<?= $index ?>)"
                                    class="thumbnail-btn flex-shrink-0 border-2 rounded-lg overflow-hidden transition-all <?= $index === 0 ? 'border-[#815331]' : 'border-gray-200 hover:border-gray-300' ?>">
                                    <img src="/storage/items-img/<?= $image ?>" alt="<?= $inventory->item_name ?> - Image <?= $index + 1 ?>"
                                        class="object-cover w-16 h-16">
                                </button>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Item Images</label>
                    <div class="w-full px-4 py-16 text-center text-gray-500 border border-gray-200 rounded-lg bg-gray-50">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>No images available</p>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-6 mt-8 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <a href="/admin/inventory"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const images = <?= json_encode(array_map(function ($img) {
                        return '/storage/items-img/' . $img;
                    }, $images)) ?>;

    function selectImage(index) {
        const mainImg = document.getElementById('mainImage');
        mainImg.src = images[index];

        // Update thumbnail borders
        document.querySelectorAll('.thumbnail-btn').forEach((btn, i) => {
            if (i === index) {
                btn.classList.remove('border-gray-200', 'hover:border-gray-300');
                btn.classList.add('border-[#815331]');
            } else {
                btn.classList.remove('border-[#815331]');
                btn.classList.add('border-gray-200', 'hover:border-gray-300');
            }
        });
    }
</script>

<?php layout('admin/footer') ?>