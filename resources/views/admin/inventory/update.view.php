<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Edit Item</h1>
        <p class="text-gray-600 text-base font-normal">Update the details below to modify the item in your inventory</p>
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

<!-- Form Section -->
<form action="/admin/inventory/update/<?= $inventory->id ?>" method="post" enctype="multipart/form-data">
    <?= csrf_token() ?>

    <!-- 2-Column Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Left Column -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>

            <!-- Supplier Name -->
            <div class="form-group">
                <label for="supplier_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Supplier Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="supplier_name" id="supplier_name"
                    value="<?= htmlspecialchars($inventory->supplier_name) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('supplier_name') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter supplier name"
                    <?= isInvalid('supplier_name') ?>>
                <?php if (error('supplier_name')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('supplier_name') ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label for="item_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Item Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="item_name" id="item_name"
                    value="<?= htmlspecialchars($inventory->item_name) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('item_name') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter item name"
                    <?= isInvalid('item_name') ?>>
                <?php if (error('item_name')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('item_name') ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors resize-none <?= error('description') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter item description"
                    <?= isInvalid('description') ?>><?= htmlspecialchars($inventory->description) ?></textarea>
                <?php if (error('description')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('description') ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category" id="category"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors bg-white <?= error('category') ? 'border-red-300 bg-red-50' : '' ?>"
                    <?= isInvalid('category') ?>>
                    <option value="" disabled>-- Select a category --</option>
                    <option value="Hand Tools" <?= $inventory->category === 'Hand Tools' ? 'selected' : '' ?>>Hand Tools</option>
                    <option value="Power Tools" <?= $inventory->category === 'Power Tools' ? 'selected' : '' ?>>Power Tools</option>
                    <option value="Construction Materials" <?= $inventory->category === 'Construction Materials' ? 'selected' : '' ?>>Construction Materials</option>
                    <option value="Locks and Security" <?= $inventory->category === 'Locks and Security' ? 'selected' : '' ?>>Locks and Security</option>
                    <option value="Plumbing" <?= $inventory->category === 'Plumbing' ? 'selected' : '' ?>>Plumbing</option>
                    <option value="Electrical" <?= $inventory->category === 'Electrical' ? 'selected' : '' ?>>Electrical</option>
                    <option value="Paint and Finishes" <?= $inventory->category === 'Paint and Finishes' ? 'selected' : '' ?>>Paint and Finishes</option>
                    <option value="Chemicals" <?= $inventory->category === 'Chemicals' ? 'selected' : '' ?>>Chemicals</option>
                </select>
                <?php if (error('category')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('category') ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Pricing & Stock</h3>

            <!-- Unit Price -->
            <div class="form-group">
                <label for="unit_price" class="block text-sm font-medium text-gray-700 mb-2">
                    Unit Price <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-sm">₱</span>
                    </div>
                    <input type="number" name="unit_price" id="unit_price" step="0.01" min="0"
                        value="<?= htmlspecialchars($inventory->unit_price) ?>"
                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('unit_price') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="0.00"
                        <?= isInvalid('unit_price') ?>>
                </div>
                <?php if (error('unit_price')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('unit_price') ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Current Quantity <span class="text-red-500">*</span>
                </label>
                <input type="number" name="quantity" id="quantity" min="0"
                    value="<?= htmlspecialchars($inventory->quantity) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('quantity') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter quantity"
                    <?= isInvalid('quantity') ?>>
                <?php if (error('quantity')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('quantity') ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Restock Threshold -->
            <div class="form-group">
                <label for="restock_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                    Restock Threshold <span class="text-red-500">*</span>
                </label>
                <input type="number" name="restock_threshold" id="restock_threshold" min="0"
                    value="<?= htmlspecialchars($inventory->restock_threshold) ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('restock_threshold') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter restock threshold"
                    <?= isInvalid('restock_threshold') ?>>
                <p class="mt-1 text-xs text-gray-500">Alert when stock falls below this number</p>
                <?php if (error('restock_threshold')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('restock_threshold') ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- New Image Upload -->
            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Change Image (Optional)</label>
                <div class="mt-1 flex justify-center items-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg <?= error('item_image') ? 'border-red-300 bg-red-50' : '' ?>">
                    <div class="space-y-1 text-center">
                        <!-- Upload Icon and Text (shown by default) -->
                        <div id="upload-placeholder">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#815331] hover:text-[#6b4428] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#815331]">
                                    <span>Upload a file</span>
                                    <input id="image" name="item_image" type="file" accept="image/*" class="sr-only" <?= isInvalid('item_image') ?>>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            <p class="text-xs text-gray-400">Leave empty to keep current image</p>
                        </div>

                        <!-- Image Preview (hidden by default) -->
                        <div id="image-preview" class="hidden"></div>
                    </div>
                </div>
                <?php if (error('item_image')): ?>
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= error('item_image') ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex items-center justify-end space-x-4">
            <a href="/admin/inventory"
                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                Cancel
            </a>
            <button type="submit"
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#815331] hover:bg-[#6b4428] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Update Item
            </button>
        </div>
    </div>
</form>

<script>
    // Image upload preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `
                    <div class="relative">
                        <img src="${e.target.result}" class="w-full h-48 object-cover rounded-lg border border-gray-200" />
                        <button type="button" onclick="clearImagePreview()" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                `;
                imagePreview.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            clearImagePreview();
        }
    });

    // Function to clear image preview
    function clearImagePreview() {
        imagePreview.innerHTML = '';
        imagePreview.classList.add('hidden');
        uploadPlaceholder.classList.remove('hidden');
        imageInput.value = '';
    }
</script>

<?php layout('admin/footer') ?>