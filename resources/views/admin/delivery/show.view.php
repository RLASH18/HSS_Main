<?php layout('admin/header') ?>

<h1>Delivery Info</h1>

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


<a href="/admin/delivery">Go back</a>

<?php layout('admin/footer') ?>