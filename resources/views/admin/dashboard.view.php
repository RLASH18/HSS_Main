<?php layout('admin/header') ?>

<h1>hello @<?= auth()->username ?>!</h1>
<h1><?= $orders ?></h1>
<h1><?= $customers ?></h1>
<h1><?= $revenue ?></h1>
<h1><?= $inventory ?></h1> 

<form action="/admin/logout" method="post">
    <?= csrf_token() ?>
    <button type="submit">Logout</button>
</form>

<?php layout('admin/footer') ?>