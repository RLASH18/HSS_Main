<?php layout('auth/header') ?>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <form action="/admin/inventory/update/<?= $inventory->id ?>" method="post" enctype="multipart/form-data"
        class="w-full max-w-2xl p-6 space-y-6 bg-white rounded-lg shadow">

        <?= csrf_token() ?>

        <!-- Supplier Name -->
        <div>
            <label for="supplier_name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
            <input type="text" name="supplier_name" id="supplier_name"
                value="<?= htmlspecialchars($inventory->supplier_name) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('supplier_name') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('supplier_name') ?></p>
        </div>

        <!-- Item Name -->
        <div>
            <label for="item_name" class="block text-sm font-medium text-gray-700">Item Name</label>
            <input type="text" name="item_name" id="item_name"
                value="<?= htmlspecialchars($inventory->item_name) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('item_name') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('item_name') ?></p>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <input type="text" name="description" id="description"
                value="<?= htmlspecialchars($inventory->description) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('description') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('description') ?></p>
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" name="category" id="category"
                value="<?= htmlspecialchars($inventory->category) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('category') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('category') ?></p>
        </div>

        <!-- Image -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" accept="image/*"
                class="block w-full mt-1 text-sm text-gray-700 border rounded-md cursor-pointer bg-gray-50 focus:outline-none" <?= isInvalid('image') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('image') ?></p>
        </div>

        <!-- Unit Price -->
        <div>
            <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
            <input type="number" name="unit_price" id="unit_price" step="0.01"
                value="<?= htmlspecialchars($inventory->unit_price) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('unit_price') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('unit_price') ?></p>
        </div>

        <!-- Quantity -->
        <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" id="quantity"
                value="<?= htmlspecialchars($inventory->quantity) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('quantity') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('quantity') ?></p>
        </div>

        <!-- Restock Threshold -->
        <div>
            <label for="restock_threshold" class="block text-sm font-medium text-gray-700">Restock Threshold</label>
            <input type="number" name="restock_threshold" id="restock_threshold"
                value="<?= htmlspecialchars($inventory->restock_threshold) ?>"
                class="block w-full mt-1 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" <?= isInvalid('restock_threshold') ?>>
            <p class="mt-1 text-sm text-red-500"><?= error('restock_threshold') ?></p>
        </div>

        <!-- Update Button -->
        <div>
            <button type="submit"
                class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">
                Update item
            </button>
        </div>

        <div>
            <a href="/admin/inventory">
                <button
                    class="w-full px-4 py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700">
                    Back
                </button>
            </a>
        </div>

    </form>
</div>

<?php layout('auth/footer') ?>