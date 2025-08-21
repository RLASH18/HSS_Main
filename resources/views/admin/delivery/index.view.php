<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Deliveries</h1>
        <p class="text-gray-600 text-base font-normal">Schedule delivery and prepares items for pickup</p>
    </div>
    <button class="bg-[#815331] hover:bg-[#5f3e27] text-white px-5 py-3 rounded-lg font-medium text-sm">
        <a href="/admin/delivery/create" class="text-white no-underline">Add Delivery</a>
    </button>
</div>

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
                    <a href="/admin/delivery/show/<?= $delivery->id ?>">Show</a>
                    <a href="/admin/delivery/edit/<?= $delivery->id ?>">Edit</a>
                    <a href="/admin/delivery/delete/<?= $delivery->id ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php layout('admin/footer') ?>