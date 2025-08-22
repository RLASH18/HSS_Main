<?php layout('customer/header') ?>

<!-- Checkout Page -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
            <p class="text-gray-600">Review your order and complete your purchase</p>
        </div>
        <a href="/customer/my-cart" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Cart
        </a>
    </div>
</div>

<form action="/customer/place-order" method="post" id="checkoutForm">
    <?= csrf_token() ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details & Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h3>

                <?php
                $cartIdsList = [];
                foreach ($cartItems as $cart):
                    $cartIdsList[] = $cart->id;
                    $itemTotal = $cart->quantity * $cart->item->unit_price;
                ?>

                    <div class="flex items-center space-x-4 py-4 border-b border-gray-200 last:border-b-0">
                        <!-- Item Image -->
                        <div class="flex-shrink-0">
                            <img src="/storage/items-img/<?= $cart->item->item_image ?>"
                                alt="<?= $cart->item->item_name ?>"
                                class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                        </div>

                        <!-- Item Details -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900"><?= $cart->item->item_name ?></h4>
                            <p class="text-sm text-gray-600"><?= $cart->item->description ?? 'No description' ?></p>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-sm text-gray-500">Qty: <?= $cart->quantity ?></span>
                                <span class="text-sm text-gray-500">×</span>
                                <span class="text-sm font-medium text-[#815331]">₱<?= number_format($cart->item->unit_price, 2) ?></span>
                            </div>
                        </div>

                        <!-- Item Total -->
                        <div class="text-right">
                            <div class="text-lg font-semibold text-gray-900">₱<?= number_format($itemTotal, 2) ?></div>
                        </div>
                    </div>
                <?php endforeach ?>

                <!-- Hidden input for cart IDs -->
                <input type="hidden" name="cart_ids" value="<?= implode(',', $cartIdsList) ?>">
            </div>

            <!-- Delivery Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Information</h3>

                <div class="space-y-4">
                    <!-- Customer Info (Read-only) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" value="<?= $user->name ?>" readonly
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="text" value="<?= $user->contact_number ?? 'Not provided' ?>" readonly
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div>
                        <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">
                            Delivery Address <span class="text-red-500">*</span>
                        </label>
                        <textarea name="delivery_address" id="delivery_address" rows="3" required
                            placeholder="Enter complete delivery address..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-[#815331] focus:border-[#815331]"><?= $user->address ?? '' ?></textarea>
                    </div>

                    <!-- Delivery method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Delivery Method <span class="text-red-500">*</span>
                        </label>

                        <div class="space-y-3">
                            <!-- Pickup Option -->
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="radio" name="delivery_method" value="pickup" required
                                    class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Pickup</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">Collect from our store location</p>
                                </div>
                            </label>

                            <!-- Delivery Option -->
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                <input type="radio" name="delivery_method" value="delivery" required
                                    class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Delivery</span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">We deliver to your address</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method</h3>

                <div class="space-y-3">
                    <!-- Cash on Delivery -->
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="radio" name="payment_method" value="cash" required
                            class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Cash on Delivery</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Pay when your order arrives</p>
                        </div>
                    </label>

                    <!-- Bank Transfer -->
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="radio" name="payment_method" value="bank_transfer" required
                            class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Bank Transfer</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Transfer to our bank account</p>
                        </div>
                    </label>

                    <!-- GCash -->
                    <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                        <input type="radio" name="payment_method" value="gcash" required
                            class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                        <div class="ml-3 flex-1">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">GCash</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Pay via GCash mobile wallet</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                <!-- Summary Details -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Items (<?= count($cartItems) ?>):</span>
                        <span class="font-medium">₱<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping:</span>
                        <span class="font-medium text-green-600">Free</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Tax:</span>
                        <span class="font-medium">₱0.00</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-[#815331]">₱<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Place Order Button -->
                <button type="submit"
                    class="w-full bg-[#815331] text-white font-semibold py-3 px-4 rounded-lg hover:bg-[#6d4529] transition-colors focus:ring-2 focus:ring-[#815331] focus:ring-offset-2">
                    Place Order
                </button>

                <!-- Security Notice -->
                <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Your order information is secure</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkoutForm');

        form.addEventListener('submit', function(e) {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const deliveryAddress = document.getElementById('delivery_address').value.trim();
            const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');

            if (!paymentMethod) {
                e.preventDefault();
                alert('Please select a payment method.');
                return;
            }

            if (!deliveryAddress) {
                e.preventDefault();
                alert('Please enter your address.');
                return;
            }

            if (!deliveryMethod) {
                e.preventDefault();
                alert('Please enter your address.');
                return;
            }
        });
    });
</script>

<?php layout('customer/footer') ?>