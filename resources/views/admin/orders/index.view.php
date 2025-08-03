<?php layout('admin/header') ?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Customer Orders</h1>

    <div class="grid grid-cols-3 gap-6">
        <?php foreach ($orders as $order): ?>
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-lg font-semibold mb-2">Order #<?= $order->id ?></h2>
                <p><strong>Customer:</strong> <?= $order->user->name ?></p>

                <?php foreach ($order->orderItems as $orderItem): ?>
                    <p><strong>Item name:</strong><?= $orderItem->item->item_name ?></p>
                <?php endforeach ?>

                <p><strong>Amount:</strong> ₱<?= number_format($order->total_amount, 2) ?></p>
                <p><strong>Status:</strong> <span class="badge"><?= ucfirst($order->status) ?></span></p>
                <p><strong>Date:</strong> <?= date('M d, Y h:i A', strtotime($order->created_at)) ?></p>

                <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status">
                    <?= csrf_token() ?>
                    <select name="status" class="mt-2 border rounded p-1">
                        <option value="pending" <?= $order->status === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="confirmed" <?= $order->status === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                        <option value="assembled" <?= $order->status === 'assembled' ? 'selected' : '' ?>>Assembled</option>
                        <option value="shipped" <?= $order->status === 'shipped' ? 'selected' : '' ?>>Shipped</option>
                        <option value="delivered" <?= $order->status === 'delivered' ? 'selected' : '' ?>>Delivered</option>
                    </select>
                    <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded">Update</button>
                </form>

                <form method="POST" action="/admin/orders/<?= $order->id ?>/cancel" class="mt-2">
                    <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">Cancel Order</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php layout('admin/footer') ?>