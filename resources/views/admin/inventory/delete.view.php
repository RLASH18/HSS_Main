<?= layout('auth/header') ?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-6 space-y-6 bg-white rounded-lg shadow">
        <h2 class="text-2xl font-bold text-center text-red-600">Delete Inventory Item</h2>

        <div class="p-4 bg-red-50 border border-red-200 rounded-md">
            <p class="text-red-800 font-medium">Are you sure you want to delete this item? This action cannot be undone.</p>
        </div>

        <!-- Display all inventory data -->
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">ID</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->id) ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Supplier Name</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->supplier_name) ?></p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Item Name</label>
                <p class="mt-1 text-sm text-gray-900 font-semibold"><?= htmlspecialchars($inventory->item_name) ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->description ?? 'No description') ?></p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->category) ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Unit Price</label>
                    <p class="mt-1 text-sm text-gray-900">₱<?= number_format($inventory->unit_price, 2) ?></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->quantity) ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Restock Threshold</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->restock_threshold) ?></p>
                </div>
            </div>

            <?php if ($inventory->image): ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <img src="/storage/items-img/<?= htmlspecialchars($inventory->image) ?>"
                        alt="<?= htmlspecialchars($inventory->item_name) ?>"
                        class="mt-2 object-cover w-32 h-32 border rounded-md">
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->created_at) ?></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Updated At</label>
                    <p class="mt-1 text-sm text-gray-900"><?= htmlspecialchars($inventory->updated_at) ?></p>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="flex space-x-4">
            <form action="/admin/inventory/destroy/<?= $inventory->id ?>" method="post" class="flex-1">
                <?= csrf_token() ?>
                <button type="submit"
                    class="w-full px-4 py-2 text-white transition bg-red-600 rounded-md hover:bg-red-700">
                    Delete Item
                </button>
            </form>

            <a href="/admin/inventory"
                class="flex-1 px-4 py-2 text-center text-gray-700 transition bg-gray-200 rounded-md hover:bg-gray-300">
                Cancel
            </a>
        </div>
    </div>
</div>

<?= layout('auth/footer') ?>