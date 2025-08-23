<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-black-900 mb-2"><?= ucfirst($items->item_name) ?></h1>
            <p class="text-black-600">Check the details and choose quantity to buy</p>
        </div>
        <a href="/customer/home" class="inline-flex items-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="space-y-6">
            <div class="form-group">
                <div class="flex items-center">
                    <img src="/storage/items-img/<?= $items->item_image ?>" alt="Item image" class="w-64 h-64 object-cover">
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="form-group">
                <div class="flex items-center">
                    <?= $items->item_name ?>
                </div>
            </div>

            <div class="form-group">
                <div class="flex items-center">
                    <?= $items->unit_price ?>
                </div>
            </div>

            <div class="form-group">
                <div class="flex items-center">
                    Description: <?= $items->description ?>
                </div>
            </div>

            <div class="form-group">
                <div class="flex items-center">
                    Price: <?= $items->unit_price ?>
                </div>
            </div>

            <div class="form-group">
                <div class="flex items-center">
                    Quantity: <?= $items->quantity ?>
                </div>
            </div>
        </div>
    </div>

    <div>
        <form action="/customer/add-to-cart" method="post">
            <?= csrf_token() ?>

            <input type="hidden" name="item_id" value="<?= $items->id ?>">

            <label for="quantity">Quantity</label>

            <!-- Minus button -->
            <button type="button" onclick="decreaseQty()" class="px-3 py-1 border rounded">-</button>
            <!-- Number display -->
            <span class="px-4" id="qty">1</span>
            <!-- Plus button -->
            <button type="button" onclick="increaseQty()" class="px-3 py-1 border rounded">+</button>

            <input type="hidden" name="quantity" id="quantity" value="1">

            <button type="submit" id="addToCartBtn">Add to cart</button>
        </form>

        <a href="/customer/place-order">Buy</a>
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