<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Billings</h1>
        <p class="text-gray-600 text-base font-normal">Keep your billing records organized</p>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>Bill ID</th>
            <th>Order ID</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Date Issued</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($billings as $billing): ?>
            <tr>
                <td><?= $billing->id ?></td>
                <td><?= $billing->orders->id ?></td>
                <td><?= $billing->payment_method ?></td>
                <td><?= $billing->payment_status ?></td>
                <td><?= $billing->amount_paid ?></td>
                <td><?= $billing->issued_at ?></td>
                <td>
                    <a href="/admin/billings/show/<?= $billing->id ?>">Show</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>    


<?php layout('admin/footer') ?>