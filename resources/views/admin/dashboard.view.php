<?php layout('admin/header') ?>

<h1>hello @<?= auth()->username ?>!</h1>
<h1><?= $orders ?></h1>
<h1><?= $customers ?></h1>
<h1><?= $revenue ?></h1>
<h1><?= $inventory ?></h1> 

<?php layout('admin/footer') ?>