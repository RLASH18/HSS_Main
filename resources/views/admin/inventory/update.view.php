<?php layout('auth/header') ?>

<form action="/admin/inventory/update/<?= $inventory->id ?>" method="post" enctype="multipart/form-data">

    <?= csrf_token() ?>

    <!-- Supplier Name -->
    <div>
        <label for="supplier_name">Supplier Name</label>
        <input type="text" name="supplier_name" id="supplier_name"
            value="<?= htmlspecialchars($inventory->supplier_name) ?>"
            <?= isInvalid('supplier_name') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('supplier_name') ?></p>
    </div>

    <!-- Item Name -->
    <div>
        <label for="item_name">Item Name</label>
        <input type="text" name="item_name" id="item_name"
            value="<?= htmlspecialchars($inventory->item_name) ?>"
            <?= isInvalid('item_name') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('item_name') ?></p>
    </div>

    <!-- Description -->
    <div>
        <label for="description">Description</label>
        <input type="text" name="description" id="description"
            value="<?= htmlspecialchars($inventory->description) ?>"
            <?= isInvalid('description') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('description') ?></p>
    </div>

    <!-- Category -->
    <div>
        <label for="category">Category</label>
        <input type="text" name="category" id="category"
            value="<?= htmlspecialchars($inventory->category) ?>"
            <?= isInvalid('category') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('category') ?></p>
    </div>

    <!-- Image -->
    <div>
        <label for="image">Item Image</label>
        <input type="file" name="item_image" id="image" accept="image/*"
            <?= isInvalid('item_image') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('item_image') ?></p>
    </div>

    <!-- Unit Price -->
    <div>
        <label for="unit_price">Unit Price</label>
        <input type="number" name="unit_price" id="unit_price" step="0.01"
            value="<?= htmlspecialchars($inventory->unit_price) ?>"
            <?= isInvalid('unit_price') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('unit_price') ?></p>
    </div>

    <!-- Quantity -->
    <div>
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity"
            value="<?= htmlspecialchars($inventory->quantity) ?>"
            <?= isInvalid('quantity') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('quantity') ?></p>
    </div>

    <!-- Restock Threshold -->
    <div>
        <label for="restock_threshold">Restock Threshold</label>
        <input type="number" name="restock_threshold" id="restock_threshold"
            value="<?= htmlspecialchars($inventory->restock_threshold) ?>"
            <?= isInvalid('restock_threshold') ?>>
        <p class="mt-1 text-sm text-red-500"><?= error('restock_threshold') ?></p>
    </div>

    <!-- Update Button -->
    <div>
        <button type="submit">
            Update item
        </button>
    </div>

    <div>
        <a href="/admin/inventory">
            <button>
                Go back
            </button>
        </a>
    </div>

</form>

<?php layout('auth/footer') ?>