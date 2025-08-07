<?php layout('admin/header') ?>

<a href="/admin/delivery/create">Add delivery</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Item name</th>
            <th>Customer</th>
            <th>Price</th>
            <th>Status</th>
            <th>Driver</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deliveries as $delivery): ?>
            <tr>
                <td><?= $delivery->id ?></td>
                <td><?= $delivery->order->orderItems[0]->items->item_name ?></td>
                <td><?= $delivery->order->user->name ?></td>
                <td><?= $delivery->order->total_amount ?></td>
                <td><?= $delivery->status ?></td>
                <td><?= $delivery->driver_name ?></td>
                <td><?= $delivery->scheduled_date ?></td>
                <td>
                    <a href="">Show</a>
                    <a href="">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php layout('admin/footer') ?>