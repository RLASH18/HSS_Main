<?php layout('customer/header') ?>

<!-- Checkout Page -->
<div class="mb-4 sm:mb-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="mb-2 text-2xl sm:text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="text-sm sm:text-base text-gray-600">Review your order and complete your purchase</p>
        </div>
        <a href="<?= isset($buyNow) ? '/customer/item/' . ($itemId ?? '') : '/customer/my-cart' ?>" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 text-sm sm:text-base font-medium text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            <?= isset($buyNow) ? 'Back to Product' : 'Back to Cart' ?>
        </a>
    </div>
</div>

<form action="<?= isset($buyNow) ? '/customer/process-buy-now' : '/customer/place-order' ?>" method="post" id="checkoutForm">
    <?= csrf_token() ?>

    <div class="grid grid-cols-1 gap-4 sm:gap-6 lg:gap-8 lg:grid-cols-3">
        <!-- Order Details & Forms -->
        <div class="space-y-4 sm:space-y-6 lg:col-span-2">
            <!-- Order Items -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <h3 class="mb-3 sm:mb-4 text-base sm:text-lg font-semibold text-gray-900">Order Items</h3>

                <?php
                $cartIdsList = [];
                $items = isset($orderItems) ? $orderItems : $cartItems;
                foreach ($items as $item):
                    if (isset($buyNow)) {
                        // For buy now, we don't have cart IDs
                        $itemTotal = $item->total;
                    } else {
                        // For cart items
                        $cartIdsList[] = $item->id;
                        $itemTotal = $item->quantity * $item->item->unit_price;
                    }
                ?>

                    <div class="flex items-center py-3 sm:py-4 gap-3 sm:gap-4 border-b border-gray-200 last:border-b-0">
                        <!-- Item Image -->
                        <div class="flex-shrink-0">
                            <img src="/storage/items-img/<?= $item->item->item_image_1 ?>"
                                alt="<?= $item->item->item_name ?>"
                                class="object-cover w-12 h-12 sm:w-16 sm:h-16 border border-gray-200 rounded-lg">
                        </div>

                        <!-- Item Details -->
                        <div class="flex-1 min-w-0">
                            <span class="text-xs sm:text-sm font-medium text-gray-900 line-clamp-2"><?= $item->item->item_name ?></span>
                            <div class="flex items-center mt-1 gap-2">
                                <span class="text-sm text-gray-500">Qty: <?= $item->quantity ?></span>
                                <span class="text-sm text-gray-500">×</span>
                                <span class="text-sm font-medium text-[#815331]">₱<?= number_format($item->item->unit_price, 2) ?></span>
                            </div>
                        </div>

                        <!-- Item Total -->
                        <div class="text-right">
                            <div class="text-sm sm:text-lg font-semibold text-gray-900">₱<?= number_format($itemTotal, 2) ?></div>
                        </div>
                    </div>
                <?php endforeach ?>

                <!-- Hidden inputs for form data -->
                <?php if (isset($buyNow)): ?>
                    <input type="hidden" name="item_id" value="<?= $orderItems[0]->item_id ?>">
                    <input type="hidden" name="quantity" value="<?= $orderItems[0]->quantity ?>">
                <?php else : ?>
                    <input type="hidden" name="cart_ids" value="<?= implode(',', $cartIdsList) ?>">
                <?php endif ?>
            </div>

            <!-- Delivery Information -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <h3 class="mb-3 sm:mb-4 text-base sm:text-lg font-semibold text-gray-900">Delivery Information</h3>

                <div class="space-y-4">
                    <!-- Customer Info (Read-only) -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" value="<?= $user->name ?>" readonly
                                class="w-full px-3 py-2 text-sm sm:text-base text-gray-600 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" value="<?= $user->contact_number ?? 'Not provided' ?>" readonly
                                class="w-full px-3 py-2 text-sm sm:text-base text-gray-600 border border-gray-300 rounded-lg bg-gray-50">
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div>
                        <label for="delivery_address" class="block mb-1 text-sm font-medium text-gray-700">
                            Delivery Address <span class="text-red-500">*</span>
                        </label>
                        <textarea name="delivery_address" id="delivery_address" rows="3" required
                            placeholder="Enter complete delivery address..."
                            class="w-full px-3 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-[#815331] focus:border-[#815331]"><?= $user->address ?? '' ?></textarea>
                    </div>

                    <!-- Delivery method -->
                    <div>
                        <label class="block mb-3 text-sm font-medium text-gray-700">
                            Delivery Method <span class="text-red-500">*</span>
                        </label>

                        <div class="space-y-3">
                            <!-- Pickup Option -->
                            <label class="flex items-center p-3 sm:p-4 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="delivery_method" value="pickup" required
                                    class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                                <div class="flex-1 ml-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Pickup</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">Collect from our store location</p>
                                </div>
                            </label>

                            <!-- Delivery Option -->
                            <label class="flex items-center p-3 sm:p-4 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="delivery_method" value="delivery" required
                                    class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                                <div class="flex-1 ml-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                        <span class="font-medium text-gray-900">Delivery</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">We deliver to your address</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="p-4 sm:p-6 bg-white rounded-lg shadow-sm">
                <h3 class="mb-3 sm:mb-4 text-base sm:text-lg font-semibold text-gray-900">Payment Method</h3>

                <div class="space-y-3">
                    <!-- Cash on Delivery -->
                    <label class="flex items-center p-3 sm:p-4 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="cash" required
                            class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                        <div class="flex-1 ml-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Cash on Delivery</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600">Pay when your order arrives</p>
                        </div>
                    </label>

                    <!-- Bank Transfer -->
                    <label class="flex items-center p-3 sm:p-4 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="bank_transfer" required
                            class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                        <div class="flex-1 ml-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">Bank Transfer</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600">Transfer to our bank account</p>
                        </div>
                    </label>

                    <!-- GCash -->
                    <label class="flex items-center p-3 sm:p-4 transition-colors border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="payment_method" value="gcash" required
                            class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                        <div class="flex-1 ml-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium text-gray-900">GCash</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600">Pay via GCash mobile wallet</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="sticky p-4 sm:p-6 bg-white rounded-lg shadow-sm top-4 sm:top-8">
                <h3 class="mb-3 sm:mb-4 text-base sm:text-lg font-semibold text-gray-900">Order Summary</h3>

                <!-- Summary Details -->
                <div class="mb-4 sm:mb-6 space-y-2 sm:space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Items (<?= isset($buyNow) ? count($orderItems) : count($cartItems) ?>):</span>
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
                    <div class="pt-2 sm:pt-3 border-t">
                        <div class="flex justify-between">
                            <span class="text-base sm:text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-base sm:text-lg font-bold text-[#815331]">₱<?= number_format($total, 2) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-4">
                    <label class="flex items-start cursor-pointer">
                        <input type="checkbox" id="termsCheckbox" required
                            class="w-4 h-4 mt-1 text-[#815331] border-gray-300 rounded focus:ring-[#815331]">
                        <span class="ml-2 text-sm text-gray-700">
                            I agree to the 
                            <button type="button" id="openTermsModal" class="text-[#815331] underline hover:text-[#6d4529] font-medium">
                                Terms and Conditions
                            </button>
                        </span>
                    </label>
                </div>

                <!-- Place Order Button -->
                <button type="submit" id="placeOrderBtn" disabled
                    class="w-full bg-[#815331] text-white font-semibold py-2 sm:py-3 px-4 text-sm sm:text-base rounded-lg hover:bg-[#6d4529] transition-colors focus:ring-2 focus:ring-[#815331] focus:ring-offset-2 opacity-50 cursor-not-allowed">
                    Place Order
                </button>

                <!-- Security Notice -->
                <div class="p-3 mt-4 rounded-lg bg-gray-50">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Your order information is secure</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Terms and Conditions Modal -->
<div id="termsModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Backdrop -->
    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50" id="termsBackdrop"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="relative w-full max-w-3xl bg-white rounded-lg shadow-xl">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b sm:p-6">
                <h2 class="text-xl font-bold text-gray-900 sm:text-2xl">Terms and Conditions</h2>
                <button type="button" id="closeTermsModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 overflow-y-auto sm:p-6 max-h-96 sm:max-h-[500px]">
                <div class="space-y-4 text-sm text-gray-700 sm:text-base">
                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">1. Order Acceptance</h3>
                        <p>By placing an order through ABG Prime Builders Supplies Inc., you agree to purchase the products listed in your order. All orders are subject to acceptance and availability.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">2. Payment Terms</h3>
                        <p>We accept Cash on Delivery, Bank Transfer, and GCash payments. For online payments (GCash/Bank Transfer), orders will be processed after payment confirmation. Cash on Delivery orders will be confirmed upon successful delivery.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">3. Delivery Policy</h3>
                        <p>Delivery times are estimates and may vary based on location and product availability. We will notify you of any significant delays. You must provide accurate delivery information to ensure successful delivery.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">4. Product Information</h3>
                        <p>We strive to provide accurate product descriptions and images. However, actual products may vary slightly from images shown. All measurements and specifications are approximate.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">5. Returns and Refunds</h3>
                        <p>Returns are accepted within 7 days of delivery for defective or damaged items. Products must be unused and in original packaging. Refunds will be processed within 7-14 business days after return approval.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">6. Cancellation Policy</h3>
                        <p>Orders can be cancelled before shipment. Once an order has been shipped, cancellation is not possible. Contact customer support immediately if you need to cancel an order.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">7. Privacy and Data Protection</h3>
                        <p>Your personal information will be used solely for order processing and delivery. We do not share your information with third parties except as necessary to fulfill your order.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">8. Limitation of Liability</h3>
                        <p>ABG Prime Builders Supplies Inc. is not liable for any indirect, incidental, or consequential damages arising from the use of our products or services.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">9. Changes to Terms</h3>
                        <p>We reserve the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the modified terms.</p>
                    </section>

                    <section>
                        <h3 class="mb-2 text-base font-semibold text-gray-900 sm:text-lg">10. Contact Information</h3>
                        <p>For questions about these terms, please contact us at abgprimebuilderssuppliesinc4@gmail.com or call us during business hours (Mon-Sat: 8AM-6PM).</p>
                    </section>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3 p-4 border-t sm:p-6">
                <button type="button" id="declineTerms" class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200 sm:text-base">
                    Decline
                </button>
                <button type="button" id="acceptTerms" class="px-4 py-2 text-sm font-medium text-white transition-colors bg-[#815331] rounded-lg hover:bg-[#6d4529] sm:text-base">
                    Accept Terms
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkoutForm');
        const termsModal = document.getElementById('termsModal');
        const termsCheckbox = document.getElementById('termsCheckbox');
        const openTermsBtn = document.getElementById('openTermsModal');
        const closeTermsBtn = document.getElementById('closeTermsModal');
        const termsBackdrop = document.getElementById('termsBackdrop');
        const acceptTermsBtn = document.getElementById('acceptTerms');
        const declineTermsBtn = document.getElementById('declineTerms');
        const placeOrderBtn = document.getElementById('placeOrderBtn');

        // Function to check if all required fields are selected
        function checkFormCompletion() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
            const termsAccepted = termsCheckbox.checked;

            // Enable button only if all three are selected
            if (paymentMethod && deliveryMethod && termsAccepted) {
                placeOrderBtn.disabled = false;
                placeOrderBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                placeOrderBtn.disabled = true;
                placeOrderBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Add event listeners to all required fields
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', checkFormCompletion);
        });

        document.querySelectorAll('input[name="delivery_method"]').forEach(radio => {
            radio.addEventListener('change', checkFormCompletion);
        });

        termsCheckbox.addEventListener('change', checkFormCompletion);

        // Open modal when clicking "Terms and Conditions" link
        openTermsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            termsModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });

        // Close modal function
        function closeModal() {
            termsModal.classList.add('hidden');
            document.body.style.overflow = ''; // Restore scrolling
        }

        // Close modal when clicking X button
        closeTermsBtn.addEventListener('click', closeModal);

        // Close modal when clicking backdrop
        termsBackdrop.addEventListener('click', closeModal);

        // Accept terms button
        acceptTermsBtn.addEventListener('click', function() {
            termsCheckbox.checked = true;
            checkFormCompletion(); // Check if button should be enabled
            closeModal();
        });

        // Decline terms button
        declineTermsBtn.addEventListener('click', function() {
            termsCheckbox.checked = false;
            checkFormCompletion(); // Check if button should be disabled
            closeModal();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !termsModal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Form validation
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
                alert('Please select a delivery method.');
                return;
            }

            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Please accept the Terms and Conditions to proceed.');
                return;
            }
        });
    });
</script>

<?php layout('customer/footer') ?>