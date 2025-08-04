<?php layout('admin/header') ?>

<div class="container mx-auto p-6">
    <?php if (isset($order) && $order): ?>
        <h1 class="text-2xl font-bold mb-6">Order Details</h1>
        
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Order #<?= $order->id ?></h2>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p><strong>Customer:</strong> <?= $order->user->name ?? 'Unknown' ?></p>
                    <p><strong>Status:</strong> <span class="badge"><?= ucfirst($order->status) ?></span></p>
                    <p><strong>Date:</strong> <?= date('M d, Y h:i A', strtotime($order->created_at)) ?></p>
                </div>
                <div>
                    <p><strong>Total Amount:</strong> ₱<?= number_format($order->total_amount, 2) ?></p>
                </div>
            </div>

            <h3 class="text-md font-semibold mb-3">Order Items:</h3>
            <div class="space-y-2">
                <?php foreach ($order->orderItems as $orderItem): ?>
                    <div class="border p-3 rounded">
                        <p><strong>Item:</strong> <?= $orderItem->items->item_name ?? 'Unknown Item' ?></p>
                        <p><strong>Quantity:</strong> <?= $orderItem->quantity ?></p>
                        <p><strong>Price:</strong> ₱<?= number_format($orderItem->unit_price, 2) ?></p>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="mt-6">
                <a href="/admin/orders" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Orders</a>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <h1 class="text-2xl font-bold text-gray-600 mb-4">Order Not Found</h1>
            <p class="text-gray-500 mb-6">The order you're looking for doesn't exist.</p>
            <a href="/admin/orders" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Orders</a>
        </div>
    <?php endif ?>
</div>

<?php layout('admin/footer') ?>