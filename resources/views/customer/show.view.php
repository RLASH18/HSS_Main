<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-black-900 mb-2"><?= ucfirst($items->item_name) ?></h1>
            <p class="text-black-600">Check the details and choose quantity to buy</p>
        </div>
        <a href="/customer/home"
            class="inline-flex items-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm mt-6 p-8">
    <!-- Product Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Image -->
        <div class="flex justify-center lg:justify-start">
            <div class="bg-gray-50 rounded-lg p-8 max-w-md">
                <img src="/storage/items-img/<?= $items->item_image ?>" alt="<?= $items->item_name ?>"
                    class="w-full h-80 object-contain">
            </div>
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <!-- Product Title -->
            <h1 class="text-3xl font-bold text-gray-900"><?= ucfirst($items->item_name) ?></h1>

            <!-- Price -->
            <div class="text-3xl font-bold text-gray-900">₱<?= number_format($items->unit_price, 2) ?></div>

            <!-- Description -->
            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                <p class="text-gray-600 leading-relaxed"><?= $items->description ?></p>
            </div>

            <!-- Form -->
            <form action="/customer/add-to-cart" method="post" class="space-y-6">
                <?= csrf_token() ?>
                <input type="hidden" name="item_id" value="<?= $items->id ?>">

                <!-- Quantity Selector -->
                <div class="space-y-3">
                    <label class="text-lg font-semibold text-gray-900">Quantity: <span class="text-sm font-light">(<?= $items->quantity ?>)</span></label>
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="decreaseQty()"
                            class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center text-gray-600 hover:border-gray-400 hover:text-gray-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>

                        <span class="text-xl font-semibold min-w-[3rem] text-center" id="qty">1</span>

                        <button type="button" onclick="increaseQty()"
                            class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center text-gray-600 hover:border-gray-400 hover:text-gray-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" name="quantity" id="quantity" value="1">
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4">
                    <button type="submit" id="addToCartBtn"
                        class="flex-1 bg-white border-2 border-[#815331] text-[#815331] font-semibold py-3 px-6 rounded-lg hover:bg-[#815331] hover:text-white transition-colors">
                        ADD TO CART
                    </button>

                    <a href="/customer/place-order"
                        class="flex-1 bg-[#815331] text-white font-semibold py-3 px-6 rounded-lg hover:bg-[#6d4529] transition-colors text-center">
                        BUY
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let qty = 1;
    let maxQty = <?= $items->quantity ?>;
    let qtyElement = document.getElementById("qty");
    let qtyInput = document.getElementById("quantity");
    let addBtn = document.getElementById("addToCartBtn");

    function updateBtnState() {
        addBtn.disabled = qty > maxQty;
    }

    function increaseQty() {
        qty++;
        qtyElement.textContent = qty;
        qtyInput.value = qty; // update hidden input
        updateBtnState();
    }

    function decreaseQty() {
        if (qty > 1) {
            qty--;
            qtyElement.textContent = qty;
            qtyInput.value = qty; // update hidden input
            updateBtnState();
        }
    }

    updateBtnState();
</script>

<?php layout('customer/footer') ?>