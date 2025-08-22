<?php layout('customer/header') ?>

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

            <button type="submit">Add to cart</button>
        </form>

        <a href="/customer/checkout/<?= $items->id ?>">Buy</a>
    </div>

</div>

<script>
    let qty = 1;
    let qtyElement = document.getElementById("qty");
    let qtyInput = document.getElementById("quantity");

    function increaseQty() {
        qty++;
        qtyElement.textContent = qty;
        qtyInput.value = qty; // update hidden input
    }

    function decreaseQty() {
        if (qty > 1) {
            qty--;
            qtyElement.textContent = qty;
            qtyInput.value = qty; // update hidden input
        }
    }
</script>

<?php layout('customer/footer') ?>