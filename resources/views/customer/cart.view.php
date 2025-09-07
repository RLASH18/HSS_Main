<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="mb-2 text-3xl font-bold text-black-900">Shopping Cart</h1>
            <p class="text-black-600">Review your items and proceed to checkout</p>
        </div>
        <a href="/customer/home" class="inline-flex items-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<?php if (empty($carts)): ?>
    <!-- Empty cart -->
    <div class="p-12 text-center bg-white border border-gray-100 rounded-lg shadow-sm">
        <div class="flex items-center justify-center w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full">
            <svg class="w-12 h-12 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
        </div>
        <h3 class="mb-2 text-xl font-semibold text-gray-900">Your cart is empty</h3>
        <p class="mb-6 text-gray-600">Add some items to your cart to get started</p>
        <a href="/customer/home" class="inline-flex items-center px-6 py-3 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            Continue shopping
        </a>
    </div>
<?php else: ?>
    <!-- Cart items -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Items lists -->
        <div class="space-y-4 lg:col-span-2">
            <!-- Select all header -->
            <div class="p-4 bg-white border border-b border-gray-100 rounded-lg shadow-sm">
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
                <div class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm cart-item">
                    <div class="flex items-start space-x-4">
                        <!-- checkbox -->
                        <div class="flex-shrink-0 pt-2">
                            <input type="checkbox" class="item-checkbox w-5 h-5 text-[#815331] border-gray-300 rounded focus:ring-[#815331]"
                                data-cart-id="<?= $cart->id ?>" data-price="<?= $itemTotal ?>">
                        </div>

                        <!-- Item image -->
                        <div class="flex-shrink-0">
                            <img src="/storage/items-img/<?= $cart->item->item_image_1 ?>" alt="<?= $cart->item->item_name ?>"
                                class="object-cover w-20 h-20 border border-gray-200 rounded-lg">
                        </div>

                        <!-- Item details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="mb-1 text-lg font-semibold text-gray-900"><?= $cart->item->item_name ?></h3>
                            <div class="flex items-center space-x-4">
                                <span class="text-lg font-bold text-[#815331]">₱<?= number_format($cart->item->unit_price, 2) ?></span>
                                <span class="text-sm text-gray-500">per units</span>
                            </div>
                        </div>

                        <!-- Quantity controls -->
                        <div class="flex-shrink-0">
                            <div class="flex flex-col items-end space-y-3">
                                <!-- Quantity adjusters -->
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <!-- Decrease quantity -->
                                    <button class="p-2 transition-colors qty-btn hover:bg-gray-50" data-cart-id="<?= $cart->id ?>"
                                        data-action="decrease" data-max-stock="<?= $cart->item->quantity ?>" <?= $cart->quantity <= 1 ? 'disabled' : '' ?>>
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>

                                    <!-- Editable quantity input -->
                                    <input type="number" class="qty-input w-16 px-2 py-1 font-medium text-center text-gray-900 border-0 focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        value="<?= $cart->quantity ?>" min="1" max="<?= $cart->item->quantity ?>" data-cart-id="<?= $cart->id ?>" data-max-stock="<?= $cart->item->quantity ?>">

                                    <!-- Increase quantity -->
                                    <button class="p-2 transition-colors qty-btn hover:bg-gray-50" data-cart-id="<?= $cart->id ?>"
                                        data-action="increase" data-max-stock="<?= $cart->item->quantity ?>" <?= $cart->quantity >= $cart->item->quantity ? 'disabled' : '' ?>>
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Item total -->
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900 item-total">₱<?= number_format($itemTotal, 2) ?></div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </div>

                                <!-- Remove button -->
                                <form action="/customer/delete-cart" method="post" class="inline">
                                    <?= csrf_token() ?>
                                    <input type="hidden" name="id" value="<?= $cart->id ?>">
                                    <button type="submit" class="text-red-600 transition-colors remove-item hover:text-red-800" data-cart-id="<?= $cart->id ?>">
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
                        <div class="p-2 mt-3 border border-orange-200 rounded-lg bg-orange-50">
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
            <div class="sticky p-6 bg-white border border-gray-100 rounded-lg shadow-sm top-8">
                <h3 class="mb-4 text-lg font-semibold text-gray-900">Order Summary</h3>

                <!-- Summary details -->
                <div class="mb-6 space-y-3">
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
                        <span class="font-medium text-green-500">Free</span>
                    </div>
                    <div class="pt-3 border-t">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total:</span>
                            <span class="text-lg font-bold text-[#815331]" id="selectedTotal">₱0.00</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout button -->
                <button type="button" id="checkoutBtn"
                    class="w-full bg-[#815331] text-white font-semibold py-3 px-4 rounded-lg hover:bg-[#6d4529] transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed"
                    disabled>
                    Proceed to Checkout
                </button>
            </div>
        </div>
    </div>
<?php endif ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const checkoutBtn = document.getElementById('checkoutBtn');

        // Update checkout summary (count, subtotal, total)
        function updateSummary() {
            const selected = document.querySelectorAll('.item-checkbox:checked');
            let count = selected.length;
            let total = 0;

            selected.forEach(cb => total += parseFloat(cb.dataset.price));

            document.getElementById('selectedCount').textContent = count;
            document.getElementById('selectedSubtotal').textContent = '₱' + total.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('selectedTotal').textContent = '₱' + total.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            checkoutBtn.disabled = count === 0;
            selectAll.checked = count === checkboxes.length;
        }

        // Handle select all checkbox 
        selectAll?.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            updateSummary();
        });

        // Handle individual item selection
        checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));

        // Checkout button action (redirect to checkout page)
        checkoutBtn?.addEventListener('click', function() {
            const selected = [];
            document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
                selected.push(cb.dataset.cartId);
            });
            if (selected.length > 0) {
                // Pass all selected cart IDs as comma-separated string
                window.location.href = '/customer/checkout/' + selected.join(',');
            }
        });

        // Quantity update with AJAX
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const cartId = this.dataset.cartId;
                const action = this.dataset.action;
                const maxStock = parseInt(this.dataset.maxStock) || 0;
                const quantityEl = this.closest('.cart-item').querySelector('.qty-input');
                let currentQty = parseInt(quantityEl.value) || 1; // Default to 1 if empty or invalid

                // Calculate new quantity
                let newQty = action === 'increase' ? currentQty + 1 : currentQty - 1;

                // Validation: prevent exceeding stock or going below 1
                if (action === 'increase' && newQty > maxStock) {
                    alert(`Sorry, only ${maxStock} items available in stock.`);
                    return;
                }

                if (action === 'decrease' && newQty < 1) {
                    return; // Don't allow quantity less than 1
                }

                // Temporarily disable the button to prevent double clicks
                this.disabled = true;

                // Send update request to server
                fetch('/customer/update-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?= $_SESSION["_csrf"] ?? "" ?>'
                        },
                        body: JSON.stringify({
                            id: cartId,
                            quantity: newQty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Update quantity display
                            quantityEl.value = newQty;

                            // Update item total price
                            const itemTotalEl = this.closest('.cart-item').querySelector('.item-total');
                            itemTotalEl.textContent = '₱' + parseFloat(data.itemTotal).toLocaleString('en-PH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            // Update button states for this cart item
                            updateButtonStates(this.closest('.cart-item'), newQty, maxStock);

                            // Update checkbox data-price for summary calculation
                            const checkbox = this.closest('.cart-item').querySelector('.item-checkbox');
                            if (checkbox) {
                                checkbox.dataset.price = data.itemTotal;
                            }

                            // Refresh checkout summary
                            updateSummary();
                        } else {
                            alert(data.message || 'Failed to update quantity');
                        }
                    })
                    .catch(err => {
                        console.error('Error updating quantity:', err);
                        alert('An error occurred while updating quantity.');
                    })
                    .finally(() => {
                        // Re-enable the button
                        this.disabled = false;
                    });
            });
        });

        // Function to update button states
        function updateButtonStates(cartItem, quantity, maxStock) {
            const decreaseBtn = cartItem.querySelector('[data-action="decrease"]');
            const increaseBtn = cartItem.querySelector('[data-action="increase"]');

            if (decreaseBtn) {
                decreaseBtn.disabled = quantity <= 1;
            }
            if (increaseBtn) {
                increaseBtn.disabled = quantity >= maxStock;
            }
        }

        // Quantity input change event
        document.querySelectorAll('.qty-input').forEach(input => {
            // Handle blur event to ensure value is always valid
            input.addEventListener('blur', function() {
                if (!this.value || parseInt(this.value) < 1) {
                    this.value = 1;
                }
            });

            input.addEventListener('change', function() {
                const cartId = this.dataset.cartId;
                const maxStock = parseInt(this.dataset.maxStock) || 0;
                let newQty = parseInt(this.value) || 1; // Default to 1 if empty or invalid

                // Validation: prevent exceeding stock or going below 1
                if (newQty < 1) {
                    newQty = 1;
                    this.value = 1;
                }

                if (newQty > maxStock) {
                    alert(`Sorry, only ${maxStock} items available in stock.`);
                    newQty = maxStock;
                    this.value = maxStock;
                }

                // Only send request if quantity actually changed
                const currentDisplayQty = parseInt(this.value);
                if (currentDisplayQty === newQty) {
                    // Send update request to server
                    fetch('/customer/update-cart', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?= $_SESSION["_csrf"] ?? "" ?>'
                            },
                            body: JSON.stringify({
                                id: cartId,
                                quantity: newQty
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Update item total price
                                const itemTotalEl = this.closest('.cart-item').querySelector('.item-total');
                                itemTotalEl.textContent = '₱' + parseFloat(data.itemTotal).toLocaleString('en-PH', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });

                                // Update button states for this cart item
                                updateButtonStates(this.closest('.cart-item'), newQty, maxStock);

                                // Update checkbox data-price for summary calculation
                                const checkbox = this.closest('.cart-item').querySelector('.item-checkbox');
                                if (checkbox) {
                                    checkbox.dataset.price = data.itemTotal;
                                }

                                // Refresh checkout summary
                                updateSummary();
                            } else {
                                alert(data.message || 'Failed to update quantity');
                                // Revert to previous value on error
                                location.reload();
                            }
                        })
                        .catch(err => {
                            console.error('Error updating quantity:', err);
                            alert('An error occurred while updating quantity.');
                            // Revert to previous value on error
                            location.reload();
                        });
                }
            });
        });
    });
</script>

<?php layout('customer/footer') ?>