 <?php layout('auth/header') ?>

<a href="/admin/inventory/add">Add an Item</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Item name</th>
            <th>Category</th>
            <th>Unit price</th>
            <th>Quantity</th>
            <th>Restock Threshold</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inventory as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item->id) ?></td>
                <td><?= htmlspecialchars($item->item_name) ?></td>
                <td><?= htmlspecialchars($item->category) ?></td>
                <td><?= htmlspecialchars($item->unit_price) ?></td>
                <td><?= htmlspecialchars($item->quantity) ?></td>
                <td><?= htmlspecialchars($item->restock_threshold) ?></td>
                <td>
                    <?php if ($item->quantity < $item->restock_threshold): ?>
                        <p>Low stock</p>
                    <?php elseif ($item->quantity <= $item->restock_threshold * 1.5): ?>
                        <p>Medium</p>
                    <?php else: ?>
                        <p>In stock</p>
                    <?php endif ?>
                </td>
                <td>
                    <a href="/admin/inventory/show/<?= $item->id ?>">Show</a>
                    <a href="/admin/inventory/edit/<?= $item->id ?>">Edit</a>
                    <a href="/admin/inventory/delete/<?= $item->id ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php layout('auth/footer') ?>