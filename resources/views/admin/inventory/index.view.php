<?php layout('header') ?>

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
                    <a href="/admin/inventory/show/<?= $item->id ?>">Show</a>
                    <a href="/admin/inventory/edit/<?= $item->id ?>">Edit</a>
                    <a href=""></a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>



<?php layout('footer') ?>