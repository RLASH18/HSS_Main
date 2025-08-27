<?php layout('customer/header') ?>

<div class="container">
    <div class="w-full bg-white border border-gray-100 rounded-lg shadow-sm">
        <div class="container w-[90%] mx-auto p-6 text-3xl font-bold">
            <h1 class="-mb-4">Categories</h1>
        </div>
        <div class="w-[80%] mx-auto p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mx-auto container">
                <div class="flex items-center justify-center flex-col gap-2 m-2">
                    <a href="#">
                        <img src="/assets/img/customer_page_categories/power_tools.png" alt="">
                    </a>
                    <p>Power Tools</p>
                </div>
                <div class="flex items-center justify-center m-2">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/hand_tools.png" alt="">
                        </a>
                        <p>Hand Tools</p>
                    </div>
                </div>
                <div class="flex items-center justify-center m-2">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/construction_materials.png" alt="">
                        </a>
                        <p>Construction Materials</p>
                    </div>
                </div>
                <div class="flex items-center justify-center m-2">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/lock_and_security.png" alt="">
                        </a>
                        <p>Lock and Security</p>
                    </div>
                </div>
                <div class="flex items-center justify-center m-2">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/plumbing.png" alt="">
                        </a>
                        <p>Plumbing</p>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/electrical.png" alt="">
                        </a>
                        <p>Electrical</p>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/paint_and_finishes.png" alt="">
                        </a>
                        <p>Paint and Finishes</p>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center flex-col gap-2">
                        <a href="#">
                            <img src="/assets/img/customer_page_categories/chemicals.png" alt="">
                        </a>
                        <p>Chemicals</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="w-full bg-white border border-gray-100 rounded-lg shadow-sm mt-8">
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($items as $item): ?>
                <a href="/customer/item/<?= $item->id ?>" class="block-group">
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
</div>

<?php layout('customer/footer') ?>