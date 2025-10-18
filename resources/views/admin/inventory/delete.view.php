<?= layout('admin/header') ?>

<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold text-gray-900">Delete Inventory Item</h1>
        <p class="text-gray-600">Are you sure you want to delete this item? This action cannot be undone.</p>
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
    <!-- Warning Alert -->
    <div class="p-4 mb-8 border border-red-200 rounded-lg bg-red-50">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Warning</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>This action will permanently delete the item and cannot be undone. Please review the details below before confirming.</p>
                </div>
            </div>
        </div>
    </div>

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
                <label class="block mb-2 text-sm font-medium text-gray-700">Brand Name</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->brand_name ?>
                </div>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Item Name</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->item_name ?>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 min-h-[100px]">
                    <?= $inventory->description ?? 'No description provided' ?>
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
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    ₱<?= number_format($inventory->unit_price, 2) ?>
                </div>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Current Quantity</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->quantity ?> units
                </div>
            </div>

            <!-- Restock Threshold -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Restock Threshold</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $inventory->restock_threshold ?> units
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
                    
                    <!-- Images Grid -->
                    <div class="grid grid-cols-1 <?= count($images) > 1 ? 'sm:grid-cols-2' : '' ?> <?= count($images) > 2 ? 'lg:grid-cols-3' : '' ?> gap-3">
                        <?php foreach ($images as $index => $image): ?>
                            <div class="relative">
                                <img src="/storage/items-img/<?= $image ?>" alt="<?= $inventory->item_name ?> - Image <?= $index + 1 ?>"
                                     class="object-contain w-full h-32 border border-gray-200 rounded-lg">
                                <div class="absolute px-2 py-1 text-xs text-white bg-black rounded bottom-2 left-2 bg-opacity-60">
                                    Image <?= $index + 1 ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Item Images</label>
                    <div class="w-full px-4 py-12 text-center text-gray-500 border border-gray-200 rounded-lg bg-gray-50">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        No images available
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-6 mt-8 border-t border-gray-200">
        <div class="flex items-center justify-end space-x-4">
            <a href="/admin/inventory"
                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                Cancel
            </a>
            <form action="/admin/inventory/destroy/<?= $inventory->id ?>" method="post" class="inline">
                <?= csrf_token() ?>
                <button type="submit" class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition-colors bg-red-600 border border-transparent rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Item
                </button>
            </form>
        </div>
    </div>
</div>

<?= layout('admin/footer') ?>