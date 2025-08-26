<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-black-900 mb-2">My Orders</h1>
            <p class="text-black-600">View your order history and status updates</p>
        </div>
        <a href="/customer/home" class="inline-flex items-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<!-- Delete 'to ang panget HAHAAHAHAHAHA -->
<div class="space-y-6">
    <?php foreach ($orders as $order) : ?>
        <div class="border rounded-xl shadow-sm p-4 bg-white">
            <div class="flex justify-between items-center mb-3">
                <h2 class="font-semibold text-lg text-gray-800">Order #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?></h2>
                <span class="text-sm text-gray-500"><?= date('M d, Y', strtotime($order->created_at)) ?></span>
            </div>

            <ul class="space-y-2">
                <?php foreach ($order->orderItems as $orderItem): ?>
                    <li class="flex justify-between items-center border-b pb-2">
                        <span class="text-gray-700"><?= $orderItem->items->item_name ?></span>
                        <span class="text-gray-500 text-sm">x<?= $orderItem->quantity ?></span>
                    </li>
                <?php endforeach ?>
            </ul>

            <div class="mt-3 flex justify-between items-center">
                <span class="font-medium text-gray-700">
                    Status:
                    <span class="px-2 py-1 rounded-lg text-xs">
                        <?= ucfirst($order->status) ?>
                    </span>
                </span>
                <span class="font-bold text-gray-900">₱<?= number_format($order->total_amount, 2) ?></span>
            </div>
        </div>
    <?php endforeach ?>
</div>

<?php layout('customer/footer') ?>