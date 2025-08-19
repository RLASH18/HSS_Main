<?php layout('customer/header') ?>

<div class="container mx-auto p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($items as $item): ?>
            <a href="/customer/show/<?= $item->id ?>" class="block-group">
                <div class="border rounded-x1 overflow-hidden shadow-sm hover:shadow-md transition">
                    <!-- product image -->
                    <img src="/storage/items-img/<?= $item->item_image ?>" alt="<?= $item->item_name ?>" 
                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">

                    <div class="p-4">
                        <!-- Price -->
                        <h5 class="text-green-600 font-bold text-lg">
                            PHP <?= number_format($item->unit_price, 2) ?>
                        </h5>

                        <!-- Name -->
                        <p class="text-gray-800 font-medium truncate">
                            <?= $item->item_name ?>
                        </p>

                        <!-- Quantity -->
                        <p class="text-sm text-gray-500 text-right">
                            Qty: <?= $item->quantity  ?>
                        </p>
                    </div>
                </div>
            </a>
        <?php endforeach ?>
    </div>
</div>

<?php layout('customer/footer') ?>