<?php layout('admin/header') ?>

<!-- Header Section -->
<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Add New Item</h1>
        <p class="text-gray-600 text-base font-normal">Fill in the details below to add a new item to your inventory</p>
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
<form action="/admin/inventory/store" method="post" enctype="multipart/form-data">
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
                    value="<?= old('supplier_name') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('supplier_name') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter supplier name">
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('supplier_name') ?></p>
                </div>
            </div>

            <!-- Item Name -->
            <div class="form-group">
                <label for="item_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Item Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="item_name" id="item_name"
                    value="<?= old('item_name') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('item_name') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter item name">
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('item_name') ?></p>
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors resize-none <?= isInvalid('description') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter item description"><?= old('description') ?></textarea>
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('description') ?></p>
                </div>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category" id="category"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors bg-white <?= isInvalid('category') ? 'border-red-300 bg-red-50' : '' ?>">
                    <option value="" disabled selected>-- Select a category --</option>
                    <option value="Hand Tools" <?= old('category') === 'Hand Tools' ? 'selected' : '' ?>>Hand Tools</option>
                    <option value="Power Tools" <?= old('category') === 'Power Tools' ? 'selected' : '' ?>>Power Tools</option>
                    <option value="Construction Materials" <?= old('category') === 'Construction Materials' ? 'selected' : '' ?>>Construction Materials</option>
                    <option value="Locks and Security" <?= old('category') === 'Locks and Security' ? 'selected' : '' ?>>Locks and Security</option>
                    <option value="Plumbing" <?= old('category') === 'Plumbing' ? 'selected' : '' ?>>Plumbing</option>
                    <option value="Electrical" <?= old('category') === 'Electrical' ? 'selected' : '' ?>>Electrical</option>
                    <option value="Paint and Finishes" <?= old('category') === 'Paint and Finishes' ? 'selected' : '' ?>>Paint and Finishes</option>
                    <option value="Chemicals" <?= old('category') === 'Chemicals' ? 'selected' : '' ?>>Chemicals</option>
                </select>
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('category') ?></p>
                </div>
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
                        value="<?= old('unit_price') ?>"
                        class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('unit_price') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="0.00">
                </div>
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('unit_price') ?></p>
                </div>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Initial Quantity <span class="text-red-500">*</span>
                </label>
                <input type="number" name="quantity" id="quantity" min="0"
                    value="<?= old('quantity') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('quantity') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter quantity">
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('quantity') ?></p>
                </div>
            </div>

            <!-- Restock Threshold -->
            <div class="form-group">
                <label for="restock_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                    Restock Threshold <span class="text-red-500">*</span>
                </label>
                <input type="number" name="restock_threshold" id="restock_threshold" min="0"
                    value="<?= old('restock_threshold') ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('restock_threshold') ? 'border-red-300 bg-red-50' : '' ?>"
                    placeholder="Enter restock threshold">
                <p class="mt-1 text-xs text-gray-500">Alert when stock falls below this number</p>
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('restock_threshold') ?></p>
                </div>
            </div>

            <!-- Item Image -->
            <div class="form-group">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Item Image <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#815331] transition-colors">
                    <div class="space-y-1 text-center">
                        <!-- Upload Icon and Text (shown by default) -->
                        <div id="upload-placeholder">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-[#815331] hover:text-[#6b4428] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-[#815331]">
                                    <span>Upload a file</span>
                                    <input id="image" name="item_image" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                        </div>

                        <!-- Image Preview (hidden by default) -->
                        <div id="image-preview" class="hidden"></div>
                    </div>
                </div>
                <div class="text-red-500 text-xs text-left mt-2">
                    <p><?= error('item_image') ?></p>
                </div>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add Item
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