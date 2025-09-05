<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($inventory->item_name) ?></h1>
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

<!-- Item Details Section -->
<div>
    <!-- Stock Status Alert -->
    <?php
    $stockStatus = '';
    $alertClass = '';
    if ($inventory->quantity <= 0) {
        $stockStatus = 'Out of Stock';
        $alertClass = 'bg-red-50 border-red-200 text-red-800';
    } elseif ($inventory->quantity <= $inventory->restock_threshold) {
        $stockStatus = 'Low Stock - Restock Needed';
        $alertClass = 'bg-yellow-50 border-yellow-200 text-yellow-800';
    } else {
        $stockStatus = 'In Stock';
        $alertClass = 'bg-green-50 border-green-200 text-green-800';
    }
    ?>

    <div class="<?= $alertClass ?> border rounded-lg p-4 mb-8">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <?php if ($inventory->quantity <= 0): ?>
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                <?php elseif ($inventory->quantity <= $inventory->restock_threshold): ?>
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                <?php else: ?>
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                <?php endif; ?>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium"><?= $stockStatus ?></h3>
                <div class="mt-1 text-sm">
                    <p>Current stock: <?= $inventory->quantity ?> units</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 2-Column Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Left Column -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>

            <!-- ID -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Item ID</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    #<?= str_pad($inventory->id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <!-- Supplier Name -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Supplier Name</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= htmlspecialchars($inventory->supplier_name) ?>
                </div>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 font-semibold">
                    <?= htmlspecialchars($inventory->item_name) ?>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 min-h-[100px]">
                    <?= htmlspecialchars($inventory->description ?? 'No description provided') ?>
                </div>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= htmlspecialchars($inventory->category) ?>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 gap-4">
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created At</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 text-sm">
                        <?= date('M d, Y \a\t g:i A', strtotime($inventory->created_at)) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 text-sm">
                        <?= date('M d, Y \a\t g:i A', strtotime($inventory->updated_at)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Pricing & Stock</h3>

            <!-- Unit Price -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 font-bold">
                    ₱<?= number_format($inventory->unit_price, 2) ?>
                </div>
            </div>

            <!-- Stock Information -->
            <div class="grid grid-cols-2 gap-4">
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Stock</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 font-semibold text-center">
                        <?= htmlspecialchars($inventory->quantity) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Restock Level</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 font-semibold text-center">
                        <?= htmlspecialchars($inventory->restock_threshold) ?>
                    </div>
                </div>
            </div>

            <!-- Item Images Gallery -->
            <?php
            $images = [];
            if (!empty($inventory->item_image)) $images[] = $inventory->item_image;
            if (!empty($inventory->item_image_2)) $images[] = $inventory->item_image_2;
            if (!empty($inventory->item_image_3)) $images[] = $inventory->item_image_3;
            ?>

            <?php if (!empty($images)): ?>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Item Images (<?= count($images) ?> image<?= count($images) > 1 ? 's' : '' ?>)
                    </label>

                    <!-- Main Image Display -->
                    <div class="w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm mb-4 p-2">
                        <img id="mainImage" src="/storage/items-img/<?= htmlspecialchars($images[0]) ?>" alt="<?= htmlspecialchars($inventory->item_name) ?>"
                            class="w-full max-h-96 object-contain">
                    </div>

                    <!-- Thumbnail Gallery (only show if more than 1 image) -->
                    <?php if (count($images) > 1): ?>
                        <div class="flex space-x-2 overflow-x-auto">
                            <?php foreach ($images as $index => $image): ?>
                                <button type="button" onclick="selectImage(<?= $index ?>)"
                                    class="thumbnail-btn flex-shrink-0 border-2 rounded-lg overflow-hidden transition-all <?= $index === 0 ? 'border-[#815331]' : 'border-gray-200 hover:border-gray-300' ?>">
                                    <img src="/storage/items-img/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($inventory->item_name) ?> - Image <?= $index + 1 ?>"
                                        class="w-16 h-16 object-cover">
                                </button>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Item Images</label>
                    <div class="w-full px-4 py-16 bg-gray-50 border border-gray-200 rounded-lg text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>No images available</p>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 pt-6 border-t border-gray-200">
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