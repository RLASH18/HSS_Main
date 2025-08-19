<?php layout('admin/header') ?>


<div class="admin-dashboard-container row-span-full">
    <h1>hello @<?= auth()->username ?>!</h1>
    <h1>Orders: <?= $orders ?></h1>
    <h1>Customers: <?= $customers ?></h1>
    <h1>Revenue: <?= $revenue ?></h1>
    <h1>Inventory: <?= $inventory ?></h1> 

    <form action="/admin/logout" method="post">
        <?= csrf_token() ?>
        <button type="submit">Logout</button>
    </form>
</div>

<?php layout('admin/footer') ?>