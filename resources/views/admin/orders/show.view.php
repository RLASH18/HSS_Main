<?php layout('admin/header') ?>

<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold text-gray-900">Order Details</h1>
        <p class="text-gray-600">Complete information about order #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?></p>
    </div>
    <div class="flex space-x-3">
        <a href="/admin/orders"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Orders
        </a>
    </div>
</div>

<div>
    <!-- Order Status Alert -->
    <?php if ($order->status === 'delivered'): ?>
        <div class="p-4 mb-8 text-green-800 border border-green-200 rounded-lg bg-green-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Order Delivered</h3>
                    <div class="mt-1 text-sm">
                        <p>This order has been successfully delivered to the customer.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($order->status === 'cancelled'): ?>
        <div class="p-4 mb-8 text-red-800 border border-red-200 rounded-lg bg-red-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Order Cancelled</h3>
                    <div class="mt-1 text-sm">
                        <p>This order has been cancelled.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($order->status === 'pending'): ?>
        <div class="p-4 mb-8 text-orange-800 border border-orange-200 rounded-lg bg-orange-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Pending Confirmation</h3>
                    <div class="mt-1 text-sm">
                        <p>This order is awaiting confirmation.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <!-- 2-Column Grid Layout -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

        <!-- Left Column - Order Information -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Order Information</h3>

            <!-- Order ID -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Order ID</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <!-- Customer Name -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Customer Name</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $order->user->name ?? 'N/A' ?>
                </div>
            </div>

            <!-- Customer Email -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Customer Email</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $order->user->email ?? 'N/A' ?>
                </div>
            </div>

            <!-- Customer Contact -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Contact Number</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $order->user->contact_number ?? 'N/A' ?>
                </div>
            </div>

            <!-- Order Status -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Order Status</label>
                <div class="w-full px-4 py-3 font-bold border border-gray-200 rounded-lg bg-gray-50">
                    <span class="inline-flex items-center
                    <?php if ($order->status === 'pending'): ?>text-orange-600
                    <?php elseif ($order->status === 'confirmed'): ?>text-blue-600
                    <?php elseif ($order->status === 'assembled'): ?>text-indigo-600
                    <?php elseif ($order->status === 'shipped'): ?>text-sky-600
                    <?php elseif ($order->status === 'delivered'): ?>text-emerald-600
                    <?php elseif ($order->status === 'paid'): ?>text-green-600
                    <?php elseif ($order->status === 'cancelled'): ?>text-red-600
                    <?php else: ?>text-gray-600<?php endif ?>">
                        <?= ucfirst($order->status) ?>
                    </span>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 gap-4">
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Order Date</label>
                    <div class="w-full px-4 py-3 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50">
                        <?= date('M d, Y \a\t g:i A', strtotime($order->created_at)) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Last Updated</label>
                    <div class="w-full px-4 py-3 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50">
                        <?= date('M d, Y \a\t g:i A', strtotime($order->updated_at)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Payment & Delivery -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Payment & Delivery</h3>

            <!-- Total Amount -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Total Amount</label>
                <div class="w-full px-4 py-3 font-bold text-[#815331] border border-gray-200 rounded-lg bg-gray-50">
                    ₱<?= number_format($order->total_amount, 2) ?>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Payment Method</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center gap-2">
                        <?php if ($order->payment_method === 'cash'): ?>
                            <svg class="w-5 h-5 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M4 8.5h16v7H4z" />
                                <circle cx="12" cy="12" r="2.25" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <span>Cash on Delivery</span>
                        <?php elseif ($order->payment_method === 'gcash'): ?>
                            <svg class="w-5 h-5 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-6 3V7Z" />
                            </svg>
                            <span>GCash</span>
                        <?php else: ?>
                            <svg class="w-5 h-5 text-purple-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 10V7l7-4 7 4v3M6 14v6m4-6v6m4-6v6m4-6v6" />
                            </svg>
                            <span>Bank Transfer</span>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <!-- Delivery Method -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Delivery Method</label>
                <div class="flex items-center w-full gap-2 px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?php if ($order->delivery_method === 'pickup'): ?>
                        <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.61713 8.71233L10.8222 6.38373C11.174 6.12735 11.6087 5.98543 12.065 6.0008C13.1764 6.02813 14.1524 6.75668 14.4919 7.82036C14.6782 8.40431 14.8481 8.79836 15.0017 9.0025C15.914 10.2155 17.3655 11 19.0002 11V13C16.8255 13 14.8825 12.0083 13.5986 10.4526L12.901 14.4085L14.9621 16.138L17.1853 22.246L15.3059 22.93L13.266 17.3256L9.87576 14.4808C9.32821 14.0382 9.03139 13.3192 9.16231 12.5767L9.67091 9.6923L8.99407 10.1841L6.86706 13.1116L5.24902 11.9361L7.60016 8.7L7.61713 8.71233ZM13.5002 5.5C12.3956 5.5 11.5002 4.60457 11.5002 3.5C11.5002 2.39543 12.3956 1.5 13.5002 1.5C14.6047 1.5 15.5002 2.39543 15.5002 3.5C15.5002 4.60457 14.6047 5.5 13.5002 5.5ZM10.5286 18.6813L7.31465 22.5116L5.78257 21.226L8.75774 17.6803L9.50426 15.5L11.2954 17L10.5286 18.6813Z" />
                        </svg>
                        <span>Pickup</span>
                    <?php else: ?>
                        <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                        </svg>
                        <span>Delivery</span>
                    <?php endif ?>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Delivery Address</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 min-h-[80px]">
                    <?= $order->delivery_address ?? $order->user->address ?? 'No address provided' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Ordered Items Section -->
    <div class="mt-8">
        <h3 class="pb-4 text-lg font-semibold text-gray-900 border-b border-gray-200">Ordered Item(s)</h3>

        <div class="mt-6 space-y-4">
            <?php foreach ($order->orderItems as $item): ?>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <!-- Item Image -->
                        <div class="flex-shrink-0">
                            <?php if (isset($item->items) && !empty($item->items->item_image_1)): ?>
                                <img src="/public/storage/items-img/<?= $item->items->item_image_1 ?>"
                                    alt="<?= $item->items->item_name ?? 'Item' ?>"
                                    class="object-cover w-16 h-16 border border-gray-200 rounded-lg">
                            <?php else: ?>
                                <div class="flex items-center justify-center w-16 h-16 bg-gray-100 border border-gray-200 rounded-lg">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            <?php endif ?>
                        </div>

                        <!-- Item Details -->
                        <div class="flex-1">
                            <span class="text-sm font-medium text-gray-900">
                                <?= $item->items->item_name ?? 'Unknown Item' ?>
                            </span>
                            <p class="text-sm text-gray-500">
                                <?= $item->items->category ?? 'N/A' ?> • <?= $item->items->brand_name ?? 'N/A' ?>
                            </p>
                            <div class="flex items-center mt-1 text-sm text-gray-600">
                                <div class="flex space-x-4">
                                    <span>Qty: <?= $item->quantity ?></span>
                                    <span>Unit Price: ₱<?= number_format($item->unit_price, 2) ?></span>
                                </div>
                                <span class="ml-auto font-semibold text-base text-[#815331]">
                                    Subtotal: ₱<?= number_format($item->quantity * $item->unit_price, 2) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Total Summary -->
        <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
            <div class="text-right">
                <p class="text-sm text-gray-600">Total Amount</p>
                <p class="text-2xl font-bold text-[#815331]">₱<?= number_format($order->total_amount, 2) ?></p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-6 mt-8 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <a href="/admin/orders"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Orders
                </a>
            </div>
        </div>
    </div>
</div>

<?php layout('admin/footer') ?>