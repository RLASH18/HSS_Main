<?php layout('admin/header') ?>

<!-- Header Section -->
<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Edit Delivery</h1>
        <p class="text-gray-600 text-base font-normal">Make changes to the delivery information and save your updates</p>
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

<!-- Form Section -->
<form action="/admin/delivery/update/<?= $deliveries->id ?>" method="post">
    <?= csrf_token() ?>

    <div class="space-y-6">

        <!-- Order ID -->
        <div class="form-group">
            <label for="order_select" class="block text-sm font-medium text-gray-700 mb-2">Order ID <span class="text-red-500">*</span></label>
            <select name="order_id" id="order_select" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('order_id') ? 'border-red-300 bg-red-50' : '' ?>" <?= isInvalid('order_id') ?>>
                <option value="" disabled>Select Order ID</option>
                <?php $selectedOrderId = old('order_id') ?: $deliveries->order_id ?>
                <?php foreach ($orders as $order): ?>
                    <option value="<?= $order->id ?>"
                        <?= $selectedOrderId === $order->id ? 'selected' : '' ?>>
                        Order #<?= $order->id ?> - <?= htmlspecialchars($order->user->name) ?>
                    </option>
                <?php endforeach ?>
            </select>
            <p class="mt-2 text-sm text-red-600"><?= error('order_id') ?></p>
        </div>

        <!-- Delivery Method -->
        <div class="form-group">
            <label for="delivery_method" class="block text-sm font-medium text-gray-700 mb-2">Delivery Method <span class="text-red-500">*</span></label>
            <select name="delivery_method" id="delivery_method" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('delivery_method') ? 'border-red-300 bg-red-50' : '' ?>" <?= isInvalid('delivery_method') ?>>
                <?php $selectedMethod = old('delivery_method') ?: $deliveries->delivery_method ?>
                <option value="pickup" <?= $selectedMethod === 'pickup' ? 'selected' : '' ?>>Pickup</option>
                <option value="delivery" <?= $selectedMethod === 'delivery' ? 'selected' : '' ?>>Delivery</option>
            </select>
            <p class="mt-2 text-sm text-red-600"><?= error('delivery_method') ?></p>
        </div>

        <!-- Scheduled Date -->
        <div class="form-group">
            <label for="scheduled_date" class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date <span class="text-red-500">*</span></label>
            <input type="date" id="scheduled_date" name="scheduled_date" value="<?= $deliveries->scheduled_date ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('scheduled_date') ? 'border-red-300 bg-red-50' : '' ?>" <?= isInvalid('scheduled_date') ?>>
            <p class="mt-2 text-sm text-red-600"><?= error('scheduled_date') ?></p>
        </div>

        <!-- Driver Name -->
        <div class="form-group">
            <label for="driver_name" class="block text-sm font-medium text-gray-700 mb-2">Driver Name <span class="text-red-500">*</span></label>
            <input type="text" id="driver_name" name="driver_name" value="<?= $deliveries->driver_name ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= error('driver_name') ? 'border-red-300 bg-red-50' : '' ?>" <?= isInvalid('driver_name') ?>>
            <p class="mt-2 text-sm text-red-600"><?= error('driver_name') ?></p>
        </div>

        <!-- Remarks -->
        <div class="form-group">
            <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
            <textarea name="remarks" id="remarks" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors resize-none <?= error('remarks') ? 'border-red-300 bg-red-50' : '' ?>" <?= isInvalid('remarks') ?>><?= $deliveries->remarks ?></textarea>
            <p class="mt-2 text-sm text-red-600"><?= error('remarks') ?></p>
        </div>

        <input type="hidden" name="status" value="scheduled">

        <!-- Form Actions -->
        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
            <a href="/admin/delivery" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#815331] hover:bg-[#6b4428] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Delivery
            </button>
        </div>
    </div>
</form>

<?php layout('admin/footer') ?>