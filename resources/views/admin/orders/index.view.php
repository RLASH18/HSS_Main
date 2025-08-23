<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Customer Orders</h1>
        <p class="text-gray-600 text-base font-normal">Track all customer orders in one place</p>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="flex gap-4 mb-6 items-center">
    <div class="relative flex-1">
        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 z-10" width="20" height="20"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
        <input type="text" id="inventory-search" placeholder="Search items or categories..."
            class="w-full pl-11 pr-3 py-3 border border-gray-300 rounded-lg text-sm bg-white transition-all duration-200 focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
    </div>
    <div class="flex gap-3">
        <select id="category-filter"
            class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[180px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
            <option value="">All Categories</option>
            <option value="Hand Tools">Hand Tools</option>
            <option value="Power Tools">Power Tools</option>
            <option value="Construction Materials">Construction Materials</option>
            <option value="Locks and Security">Locks and Security</option>
            <option value="Plumbing">Plumbing</option>
            <option value="Electrical">Electrical</option>
            <option value="Paint and Finishes">Paint and Finishes</option>
            <option value="Chemicals">Chemicals</option>
        </select>
        <select id="stock-filter"
            class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[140px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
            <option value="">All Stock</option>
            <option value="low">Low Stock</option>
            <option value="medium">Warning</option>
            <option value="high">In Stock</option>
        </select>
    </div>
</div>

<!-- End of Search Filter -->

<div class="grid grid-cols-3 gap-6">
    <?php foreach ($orders as $order): ?>
    <div class="p-4 bg-white shadow rounded-lg">
        <div class="flex justify-between items-center">
            <div class="flex gap-2">
                <div class="orders-icon-box flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#815331">
                        <path
                            d="M4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311L4.5 7.65311ZM12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM6.49896 9.97065L11 12.5765V17.625H13V12.5765L17.501 9.97066L16.499 8.2398L12 10.8445L7.50104 8.2398L6.49896 9.97065Z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold">Order #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?></h2>
                    <p class="customer-name text-[#757575]"><strong></strong> <?= $order->user->name ?></p>
                </div>
            </div>
            <div>
                <?php if ($order->status === 'pending'): ?>
                <p class="rounded-xl bg-[#ffbe00] text-white text-[10px] px-[15px] py-[5px]">Pending</p>
                <?php elseif ($order->status === 'confirmed'): ?>
                <p class="flex justify-center rounded-2xl bg-teal-500 text-white text-[10px] px-[15px] py-[5px]">
                    Confirmed</p>
                <?php elseif ($order->status === 'assembled'): ?>
                <p class="flex justify-center rounded-2xl bg-[#F28C28] text-white text-[10px] px-[15px] py-[5px]">
                    Assembled</p>
                <?php elseif ($order->status === 'shipped'): ?>
                <p class="flex justify-center rounded-2xl bg-indigo-500 text-white text-[10px] px-[15px] py-[5px]">
                    Shipped</p>
                <?php elseif ($order->status === 'paid'): ?>
                <p class="flex justify-center rounded-2xl bg-lime-500 text-white text-[10px] px-[15px] py-[5px]">Paid
                </p>
                <?php elseif ($order->status === 'cancelled'): ?>
                <p class="flex justify-center rounded-2xl bg-red-500 text-white text-[10px] px-[15px] py-[5px]">
                    Cancelled</p>
                <?php elseif ($order->status === 'delivered'): ?>
                <p class="flex justify-center rounded-2xl bg-green-700 text-white text-[10px] px-[15px] py-[5px]">
                    Delivered</p>
                <?php endif ?>
            </div>
        </div>

        <div class="flex justify-between">
            <div class="my-2 flex flex-col">
                <p class="text-sm text-[#757575]">Total Amount</p>
                <p class="font-bold text-xl">₱<?= number_format($order->total_amount, 2) ?></p>
            </div>
            <div class="my-2 flex flex-col justify-center">
                <p class="text-xs leading-5 text-[#757575]">Order Date</p>
                <div class="flex items-center justify-center gap-2">
                    <svg width="15px" height="15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="#757575">
                        <path
                            d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z">
                        </path>
                    </svg>
                    <p class="text-xs leading-5 text-[#757575]">
                        <?= date('M d, Y h:i A', strtotime($order->created_at)) ?></p>
                </div>
            </div>
        </div>

        <!-- Items ordered -->
        <div class="my-3">
            <p class="text-[#757575]">Items:</p>
            <?php foreach ($order->orderItems as $orderItem): ?>
            <div class="items-ordered-container">
                <li class="list-none text-sm"><?= $orderItem->items->item_name ?>
                    (<?= $orderItem->quantity ?>)</li>
            </div>
            <?php endforeach ?>
        </div>


        <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status">
            <?= csrf_token() ?>

            <?php if ($order->status === 'pending'): ?>
            <div class="float-left">
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" class=" bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Confirm
                    Order</button>
            </div>
            <?php elseif ($order->status === 'confirmed'): ?>
            <div>
                <input type="hidden" name="status" value="assembled">
                <button type="submit" class=" bg-[#F28C28] hover:bg-[#a05f1e] text-white px-4 py-1 rounded-md">Mark
                    as
                    Assembled</button>
            </div>
            <?php elseif ($order->status === 'assembled'): ?>
            <input type="hidden" name="status" value="shipped">
            <button type="submit" class=" bg-indigo-500 hover:bg-indigo-700 text-white px-4 py-1 rounded-md">Mark as
                Shipped</button>
            <?php elseif ($order->status === 'shipped'): ?>
            <input type="hidden" name="status" value="delivered">
            <button type="submit" class=" bg-green-700 hover:bg-green-800 text-white px-4 py-1 rounded-md">Mark as
                Delivered</button>
            <?php elseif ($order->status === 'delivered'): ?>
            <input type="hidden" name="status" value="paid">
            <button type="submit" class="ml-2 bg-yellow-500 text-white px-4 py-1 rounded-md">Paid</button>
            <?php endif ?>
        </form>

        <form method="POST" action="/admin/orders/<?= $order->id ?>/cancel" class="mt-2">
            <?= csrf_token() ?>

            <?php if ($order->status === 'pending'): ?>
            <div><button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white px-4 py-1 rounded ml-2 rounded-md">Cancel</button>
            </div>
            <?php endif ?>
        </form>
    </div>
    <?php endforeach; ?>
</div>


<?php layout('admin/footer') ?>