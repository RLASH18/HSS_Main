<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Dashboard</h1>
        <p class="text-gray-600 text-base font-normal">Welcome back @<strong class="text-[#815331]"><?= auth()->username ?></strong>!</p>
    </div>
</div>
<div class="admin-cards-container grid grid-cols-4 gap-5 my-4">
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Total Orders</p>
            <p><?= $orders ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Customers</p>
            <p><?= $customers ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Revenue</p>
            <p><?= $revenue ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 10h9.231M6 14h9.231M18 5.086A5.95 5.95 0 0 0 14.615 4c-3.738 0-6.769 3.582-6.769 8s3.031 8 6.769 8A5.94 5.94 0 0 0 18 18.916" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Inventory</p>
            <p><?= $inventory ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                        d="M4.07141 14v6h5.99999v-6H4.07141Zm4.5-4h6.99999l-3.5-6-3.49999 6Zm7.99999 10c1.933 0 3.5-1.567 3.5-3.5s-1.567-3.5-3.5-3.5-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5Z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="admin-chart-container grid grid-cols-2 gap-4">
    <div
        class="chart-1-container bg-white border border-gray-200 rounded-lg shadow-sm flex justify-center align-center">
        <img src="/assets/img/chart1.png" alt="">
    </div>
    <div
        class="chart-2-container bg-white border border-gray-200 rounded-lg shadow-sm flex justify-center align-center">
        <img src="/assets/img/chart2.png" alt="">
    </div>
</div>

<div class="grid grid-cols-3 gap-5 my-4">
    <div class="recent-orders-container bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <h1 class="mb-3">Recent Orders</h1>
        <?php foreach ($recentOrders as $order):  ?>
            <div class="flex align-center justify-between my-3">
                <div>
                    <p class="id">#<?= $order->id ?></p>
                    <p class="name"><?= $order->user->name ?></p>
                    <p class="cost">₱<?= $order->total_amount ?></p>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="date-time mb-1"><?= date("M, d Y", strtotime($order->created_at)) ?></p>
                    <?php if ($order->status === 'pending'): ?>
                        <p class="flex justify-center rounded-2xl bg-[#ffbe00] text-white text-[10px] p-[2px]">Pending</p>
                    <?php elseif ($order->status === 'confirmed'): ?>
                        <p class="flex justify-center rounded-2xl bg-teal-500 text-white text-[10px] p-[2px]">Confirmed</p>
                    <?php elseif ($order->status === 'assembled'): ?>
                        <p class="flex justify-center rounded-2xl bg-[#F28C28] text-white text-[10px] p-[2px]">Assembled</p>
                    <?php elseif ($order->status === 'shipped'): ?>
                        <p class="flex justify-center rounded-2xl bg-indigo-500 text-white text-[10px] p-[2px]">Shipped</p>
                    <?php elseif ($order->status === 'paid'): ?>
                        <p class="flex justify-center rounded-2xl bg-lime-500 text-white text-[10px] p-[2px]">Paid</p>
                    <?php elseif ($order->status === 'cancelled'): ?>
                        <p class="flex justify-center rounded-2xl bg-red-500 text-white text-[10px] p-[2px]">Cancelled</p>
                    <?php elseif ($order->status === 'delivered'): ?>
                        <p class="flex justify-center rounded-2xl bg-green-700 text-white text-[10px] p-[2px]">Delivered</p>
                    <?php endif ?>
                </div>
            </div>
            <hr class=" horizontal-line">
        <?php endforeach ?>
    </div>
    <div class="new-customers-container bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <h1 class="mb-3">New Customers</h1>
        <?php foreach ($newCustomers as $newCustomer): ?>
            <div class="flex align-center justify-between my-3">
                <div>
                    <p class="name"><?= $newCustomer->name ?></p>
                    <p class="email"><?= $newCustomer->email ?></p>
                </div>
                <div class="flex flex-col justify-end">
                    <p class="date-time">
                        <?= date("M, d g:i:a", strtotime($newCustomer->created_at)) ?>
                    </p>
                </div>
            </div>
            <hr class="horizontal-line">
        <?php endforeach ?>
    </div>
    <div class="added-products-container bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <h1 class="mb-3">Added Products</h1>
        <?php foreach ($addedProducts as $item): ?>
            <div class="flex justify-between my-3">
                <div>
                    <p class="product-name"><?= $item->item_name ?></p>
                    <p class="item-category"><?= $item->category ?></p>
                </div>
                <div>
                    <p class="quantity"><?= $item->quantity ?> pcs</p>
                    <p class="date-time"><?= date("M, d g:i:a", strtotime($item->created_at)) ?></p>
                </div>
            </div>
            <hr class="horizontal-line">
        <?php endforeach ?>
    </div>
</div>

<?php layout('admin/footer') ?>