<?= layout('auth/header') ?>

<h2>Delete Inventory Item</h2>

<div>
    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
</div>

<!-- Display all inventory data -->
<div>
    <div>
        <div>
            <label>ID</label>
            <p><?= htmlspecialchars($inventory->id) ?></p>
        </div>

        <div>
            <label>Supplier Name</label>
            <p><?= htmlspecialchars($inventory->supplier_name) ?></p>
        </div>
    </div>

    <div>
        <label>Item Name</label>
        <p><?= htmlspecialchars($inventory->item_name) ?></p>
    </div>

    <div>
        <label>Description</label>
        <p><?= htmlspecialchars($inventory->description ?? 'No description') ?></p>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label>Category</label>
            <p><?= htmlspecialchars($inventory->category) ?></p>
        </div>

        <div>
            <label>Unit Price</label>
            <p>₱<?= number_format($inventory->unit_price, 2) ?></p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label>Quantity</label>
            <p><?= htmlspecialchars($inventory->quantity) ?></p>
        </div>

        <div>
            <label>Restock Threshold</label>
            <p><?= htmlspecialchars($inventory->restock_threshold) ?></p>
        </div>
    </div>

    <?php if ($inventory->item_image): ?>
        <div>
            <label>Item Image</label>
            <img src="/storage/items-img/<?= htmlspecialchars($inventory->item_image) ?>"
                alt="<?= htmlspecialchars($inventory->item_name) ?>">
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label>Created At</label>
            <p><?= htmlspecialchars($inventory->created_at) ?></p>
        </div>

        <div>
            <label>Updated At</label>
            <p><?= htmlspecialchars($inventory->updated_at) ?></p>
        </div>
    </div>
</div>

<!-- Action buttons -->
<div class="flex space-x-4">
    <form action="/admin/inventory/destroy/<?= $inventory->id ?>" method="post" class="flex-1">
        <?= csrf_token() ?>
        <button type="submit">
            Delete Item
        </button>
    </form>

    <a href="/admin/inventory">
        Cancel
    </a>
</div>


<?= layout('auth/footer') ?>