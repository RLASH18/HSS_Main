<?php layout('admin/header') ?>

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Customer Orders</h1>

    <div class="grid grid-cols-3 gap-6">
        <?php foreach ($orders as $order): ?>
            <div class="p-4 bg-white shadow rounded-lg">
                <h2 class="text-lg font-semibold mb-2">Order #<?= $order->id ?></h2>
                <p><strong>Customer:</strong> <?= $order->user->name ?></p>

                <div class="my-3">
                    <strong>Items Ordered</strong>
                    <?php foreach ($order->orderItems as $orderItem): ?>
                        <li><?= $orderItem->items->item_name ?> (<?= $orderItem->quantity ?>)</li>
                    <?php endforeach ?>
                </div>

                <p><strong>Amount:</strong> ₱<?= number_format($order->total_amount, 2) ?></p>
                <p><strong>Status:</strong> <span class="badge"><?= ucfirst($order->status) ?></span></p>
                <p><strong>Date:</strong> <?= date('M d, Y h:i A', strtotime($order->created_at)) ?></p>

                <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status">
                    <?= csrf_token() ?>

                    <?php if ($order->status === 'pending'): ?>
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded">Confirmed</button>
                    <?php elseif ($order->status === 'confirmed'): ?>
                        <input type="hidden" name="status" value="assembled">
                        <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded">Assembled</button>
                    <?php elseif ($order->status === 'assembled'): ?>
                        <input type="hidden" name="status" value="shipped">
                        <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded">Shipped</button>
                    <?php elseif ($order->status === 'shipped'): ?>
                        <input type="hidden" name="status" value="delivered">
                        <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded">Delivered</button>
                    <?php elseif ($order->status === 'delivered'): ?>
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded">Paid</button>
                    <?php endif ?>
                </form>

                <form method="POST" action="/admin/orders/<?= $order->id ?>/cancel" class="mt-2">
                    <?= csrf_token() ?>

                    <?php if ($order->status === 'pending'): ?>
                        <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">Cancel Order</button>
                    <?php endif ?>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php layout('admin/footer') ?>