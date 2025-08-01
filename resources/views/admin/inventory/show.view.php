<?php layout('auth/header') ?>

<h1><?= htmlspecialchars($inventory->item_name) ?></h1>
<p>Supplier: <?= htmlspecialchars($inventory->supplier_name) ?></p>
<p>Price: ₱<?= number_format($inventory->unit_price, 2) ?></p>
<img src="/storage/items-img/<?= htmlspecialchars($inventory->item_image) ?>" alt="Image" class="object-cover w-32 h-32">

<a href="/admin/inventory">
    Go back
</a>


<?php layout('auth/footer') ?>
