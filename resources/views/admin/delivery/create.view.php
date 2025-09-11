<?php layout('admin/header') ?>

<!-- Header Section -->
<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Add New Delivery</h1>
        <p class="text-gray-600 text-base font-normal">Complete the form below to schedule a new delivery.</p>
    </div>
    <div class="flex space-x-3">
        <a href="/admin/delivery"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Deliveries
        </a>
    </div>
</div>

<?php if (empty($orders)): ?>
    <!-- No Orders Available Message -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                <h3 class="text-lg font-medium text-yellow-800">No Orders Available</h3>
                <p class="text-yellow-700 mt-1">No assembled orders are available for delivery assignment.</p>
                <p class="text-sm text-yellow-600 mt-2">
                    <strong>Note:</strong> Deliveries are automatically created when orders reach 'assembled' status. 
                    You can also manually create deliveries here for assembled orders that don't have deliveries yet.
                </p>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- Form Section -->
    <form action="/admin/delivery/store" method="post">
        <?= csrf_token() ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Order ID -->
                <div class="form-group">
                    <label for="order_select" class="block text-sm font-medium text-gray-700 mb-2">Order ID <span class="text-red-500">*</span></label>
                    <select name="order_id" id="order_select" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('order_id') ? 'border-red-300 bg-red-50' : '' ?>">
                        <option value="" disabled selected>Select Order ID</option>
                        <?php foreach ($orders as $order): ?>
                            <option value="<?= $order->id ?>" <?= old('order_id') == $order->id ? 'selected' : '' ?>>
                                Order #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?> - <?= $order->user->name ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <div class="text-sm text-gray-600 mt-2">
                        <p class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Showing only orders without existing deliveries (<?= count($orders) ?> available)
                        </p>
                    </div>
                    <div class="text-red-500 text-xs text-left mt-2">
                        <p><?= error('order_id') ?></p>
                    </div>
                </div>

                <!-- Delivery Method -->
                <div class="form-group">
                    <label for="delivery_method" class="block text-sm font-medium text-gray-700 mb-2">Delivery Method <span class="text-red-500">*</span></label>
                    <select name="delivery_method" id="delivery_method" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('delivery_method') ? 'border-red-300 bg-red-50' : '' ?>">
                        <option value="" disabled selected>Select Delivery Method</option>
                        <option value="pickup" <?= old('delivery_method') == 'pickup' ? 'selected' : '' ?>>Pickup</option>
                        <option value="delivery" <?= old('delivery_method') == 'delivery' ? 'selected' : '' ?>>Delivery</option>
                    </select>
                    <div class="text-red-500 text-xs text-left mt-2">
                        <p><?= error('delivery_method') ?></p>
                    </div>
                    <div id="delivery_hint" class="text-sm text-gray-600 mt-2 hidden">
                        <span id="hint_text"></span>
                    </div>
                </div>

                <!-- Scheduled Date -->
                <div class="form-group">
                    <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date <span class="text-red-500">*</span></label>
                    <input type="date" name="scheduled_date" id="scheduled_date" value="<?= old('scheduled_date') ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('scheduled_date') ? 'border-red-300 bg-red-50' : '' ?>">
                    <div class="text-red-500 text-xs text-left mt-2">
                        <p><?= error('scheduled_date') ?></p>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Driver Name -->
                <div class="form-group">
                    <label for="driver_name" class="block text-sm font-medium text-gray-700 mb-2">Driver Name</label>
                    <input type="text" name="driver_name" id="driver_name" value="<?= old('driver_name') ?>" placeholder="Enter driver name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('driver_name') ? 'border-red-300 bg-red-50' : '' ?>">
                    <div class="text-red-500 text-xs text-left mt-2">
                        <p><?= error('driver_name') ?></p>
                    </div>
                </div>

                <!-- Remarks -->
                <div class="form-group">
                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="4" placeholder="Enter any additional notes or remarks" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors resize-none <?= isInvalid('remarks') ? 'border-red-300 bg-red-50' : '' ?>"><?= old('remarks') ?></textarea>
                    <div class="text-red-500 text-xs text-left mt-2">
                        <p><?= error('remarks') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
            <a href="/admin/delivery" class="px-6 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-[#815331] text-white rounded-lg text-sm font-medium hover:bg-[#6d4428] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                Create Delivery
            </button>
        </div>
    </form>
<?php endif ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderSelect = document.getElementById('order_select');
        const deliveryMethodSelect = document.getElementById('delivery_method');
        const deliveryHint = document.getElementById('delivery_hint');
        const hintText = document.getElementById('hint_text');

        // Only initialize if there are orders available
        <?php if (!empty($orders)): ?>
            // Create order data mapping for easy access
            const orderData = {
                <?php foreach ($orders as $order): ?>
                    <?= $order->id ?>: {
                        delivery_method: '<?= $order->delivery_method ?? 'pickup' ?>',
                        customer_name: '<?= $order->user->name ?>'
                    },
                <?php endforeach ?>
            };

            // Updates delivery method and hint text when an order is selected
            orderSelect.addEventListener('change', function() {
                const orderId = this.value;

                // If valid order set delivery + show green hint, else reset + gray hint
                if (orderId && orderData[orderId]) {
                    const order = orderData[orderId];
                    deliveryMethodSelect.value = order.delivery_method;
                    hintText.textContent = `Customer selected: ${order.delivery_method} (${order.customer_name})`;
                    deliveryHint.classList.remove('hidden');
                    deliveryHint.classList.add('text-green-600');
                } else {
                    deliveryMethodSelect.value = '';
                    deliveryHint.classList.add('hidden');
                    deliveryHint.classList.remove('text-green-600');
                }
            });
        <?php endif ?>
    });
</script>

<?php layout('admin/footer') ?>