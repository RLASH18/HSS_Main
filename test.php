<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Shopping Cart</h1>
    <p class="text-gray-600">Review your items and proceed to checkout</p>
</div>

<?php if (empty($carts)): ?>
    <!-- Empty cart -->
    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
        <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
        <p class="text-gray-600 mb-6">Add some items to your cart to get started</p>
        <a href="/customer/home" class="inline-flex items-center px-6 py-3 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            Continue shopping
        </a>
    </div>
<?php else: ?>
    <!-- Cart items -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Items lists -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Select all header -->
            <div class="bg-white rounded-lg shadow-sm p-4 border-b">
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" id="selectAll" class="w-5 h-5 text-[#815331] border-gray-300 rounded focus:ring-[#815331]">
                        <span class="font-medium text-gray-900">Select all items</span>
                    </label>
                    <span class="text-sm text-gray-600"><?= count($carts) ?> item(s)</span>
                </div>
            </div>

            <!-- Cart items -->
            <?php
            $totalAmount = 0;
            foreach ($carts as $cart):
                $itemTotal = $cart->quantity * $cart->item->unit_price;
                $totalAmount += $itemTotal;
            ?>
                <div class="bg-white rounded-lg shadow-sm p-6 cart-item">
                    <div class="flex items-start space-x-4">
                        <!-- checkbox -->
                        <div class="flex-shrink-0 pt-2">
                            <input type="checkbox" class="item-checkbox w-5 h-5 text-[#815331] border-gray-300 rounded focus:ring-[#815331]"
                                data-cart-id="<?= $cart->id ?>" data-price="<?= $itemTotal ?>">
                        </div>

                        <!-- Item image -->
                        <div class="flex-shrink-0">
                            <img src="/storage/items-img/<?= $cart->item->item_image ?>" alt="<?= $cart->item->item_name ?>"
                                class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                        </div>

                        <!-- Item details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg font-semibold text-gray-900 mb-1"><?= $cart->item->item_name ?></h3>
                            <p class="text-sm text-gray-600 mb-2"><?= $cart->item->description ?? 'No description available' ?></p>
                            <div class="flex items-center space-x-4">
                                <span class="text-lg font-bold text-[#815331]">₱<?= number_format($cart->item->unit_price, 2) ?></span>
                                <span class="text-sm text-gray-500">× <?= $cart->quantity ?></span>
                            </div>
                        </div>

                        <!-- Quantity controls -->
                        <div class="flex-shrink-0">
                            <div class="flex flex-col items-end space-y-3">
                                <!-- Quantity adjusters -->
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <!-- Decrease quantity -->
                                    <form method="POST" action="/customer/cart/update" class="inline">
                                        <input type="hidden" name="id" value="<?= $cart->id ?>">
                                        <input type="hidden" name="quantity" value="<?= max(1, $cart->quantity - 1) ?>">
                                        <button type="submit" class="p-2 hover:bg-gray-50 transition-colors" <?= $cart->quantity <= 1 ? 'disabled' : '' ?>>
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Current quantity -->
                                    <span class="w-16 text-center text-gray-900 font-medium"><?= $cart->quantity ?></span>

                                    <!-- Increase quantity -->
                                    <form method="POST" action="/customer/cart/update" class="inline">
                                        <input type="hidden" name="id" value="<?= $cart->id ?>">
                                        <input type="hidden" name="quantity" value="<?= $cart->quantity + 1 ?>">
                                        <button type="submit" class="p-2 hover:bg-gray-50 transition-colors" <?= $cart->quantity >= $cart->item->quantity ? 'disabled' : '' ?>>
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <!-- Item total -->
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">₱<?= number_format($itemTotal, 2) ?></div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </div>

                                <!-- Remove button -->
                                <form method="POST" action="/customer/delete-item" class="inline">
                                    <input type="hidden" name="id" value="<?= $cart->id ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-2 rounded-lg hover:bg-red-50"
                                        onclick="return confirm('Remove this item from cart?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Stock warning -->
                    <?php if ($cart->item->quantity < 10): ?>
                        <div class="mt-3 p-2 bg-orange-50 border border-orange-200 rounded-lg">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <span class="text-sm text-orange-800">Only <?= $cart->item->quantity ?> left in stock</span>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        </div>

        <!-- Checkout summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                <!-- Summary details -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Selected Items:</span>
                        <span class="font-medium" id="selectedCount">0</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium" id="selectedSubtotal">₱0.00</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping:</span>
                        <span class="font-medium text-green-600">Free</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-[#815331]" id="selectedTotal">₱0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button type="button" id="checkoutBtn"
                    class="w-full bg-[#815331] text-white font-semibold py-3 px-4 rounded-lg hover:bg-[#6d4529] transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed"
                    disabled>
                    Proceed to Checkout
                </button>

                <div class="mt-4 text-center">
                    <a href="/customer/home" class="text-sm text-[#815331] hover:text-[#6d4529] transition-colors">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<!-- Super simple JS - just for checkboxes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const checkoutBtn = document.getElementById('checkoutBtn');

        function updateSummary() {
            const selected = document.querySelectorAll('.item-checkbox:checked');
            let count = selected.length;
            let total = 0;

            selected.forEach(cb => total += parseFloat(cb.dataset.price));

            document.getElementById('selectedCount').textContent = count;
            document.getElementById('selectedSubtotal').textContent = '₱' + total.toFixed(2);
            document.getElementById('selectedTotal').textContent = '₱' + total.toFixed(2);

            checkoutBtn.disabled = count === 0;
            selectAll.checked = count === checkboxes.length;
        }

        selectAll?.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSummary();
        });

        checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));

        checkoutBtn?.addEventListener('click', function() {
            const selected = [];
            document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                selected.push(cb.dataset.cartId);
            });
            if (selected.length > 0) {
                window.location.href = '/customer/checkout/' + selected[0];
            }
        });
    });
</script>

<?php layout('customer/footer') ?>