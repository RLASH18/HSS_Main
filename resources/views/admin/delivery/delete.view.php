<?php layout('admin/header') ?>

<h2>Delete Delivery Info</h2>

<p>Are you sure you want to delete this delivery?</p>

<ul>
    <li><strong>Delivery ID:</strong> <?= $deliveries->id ?></li>
    <li><strong>Order ID:</strong> <?= $deliveries->order_id ?></li>
    <li><strong>Order Name:</strong> <?= $deliveries->order->user->name ?></li>
    <li><strong>Delivery Method:</strong> <?= ucfirst($deliveries->delivery_method) ?></li>
    <li><strong>Scheduled Date:</strong> <?= $deliveries->scheduled_date ?></li>
    <li><strong>Remarks:</strong> <?= $deliveries->remarks ?: 'None' ?></li>
    <li><strong>Driver Name:</strong> <?= $deliveries->driver_name ?></li>
    <li><strong>Status:</strong> <?= ucfirst($deliveries->status) ?></li>
</ul>

<form action="/admin/delivery/destroy/<?= $deliveries->id ?>" method="post">
    <?= csrf_token() ?>
    <button type="submit">Yes, Delete Delivery</button>
    <a href="/admin/delivery">Cancel</a>
</form>

<?php layout('admin/footer') ?>