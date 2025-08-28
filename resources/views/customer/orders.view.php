<?php layout('customer/header') ?>

<!-- header section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-black-900 mb-2">My Orders</h1>
            <p class="text-black-600">View your order history and status updates</p>
        </div>
        <a href="/customer/home" class="inline-flex items-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Continue Shopping
        </a>
    </div>
</div>

<div id="order-list">
    <div class="list space-y-6">
        <?php foreach ($orders as $order) : ?>
            <div class="border rounded-xl shadow-sm p-4 bg-white">
                <!-- Order header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="order-name font-semibold text-lg text-gray-800">Order #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?></h2>
                        <div class="flex items-center space-x-6 text-sm text-gray-500 mt-2">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 1V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7V1H9ZM20 11H4V19H20V11ZM7 5H4V9H20V5H17V7H15V5H9V7H7V5Z" />
                                </svg>
                                Ordered <?= date('M d, Y', strtotime($order->created_at)) ?>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                                </svg>
                                Est. Delivery <?= date('M d, Y', strtotime($order->created_at . ' +7 days')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="text-right -mt-4">
                        <?php if ($order->status === 'pending'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-[#ffbe00] text-white text-sm font-medium">
                                Pending
                            </span>
                        <?php elseif ($order->status === 'confirmed'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-teal-500 text-white text-sm font-medium">
                                Confirmed
                            </span>
                        <?php elseif ($order->status === 'assembled'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-[#F28C28] text-white text-sm font-medium">
                                Assembled
                            </span>
                        <?php elseif ($order->status === 'shipped'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-indigo-500 text-white text-sm font-medium">
                                Shipped
                            </span>
                        <?php elseif ($order->status === 'delivered'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-green-700 text-white text-sm font-medium">
                                Delivered
                            </span>
                        <?php elseif ($order->status === 'paid'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-lime-500 text-white text-sm font-medium">
                                Paid
                            </span>
                        <?php elseif ($order->status === 'cancelled'):  ?>
                            <span class="status px-3 py-1 rounded-full bg-red-500 text-white text-sm font-medium">
                                Cancelled
                            </span>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Status bar -->
                <div class="progress-container mb-6" data-status="<?= strtolower($order->status) ?>">
                    <div class="flex items-center justify-between relative">
                        <!-- Progress Line -->
                        <div class="absolute top-4 left-5 right-10 h-0.5 bg-gray-200 z-0">
                            <div class="progress-line h-full bg-[#815331] transition-all duration-500" style="width: 0%"></div>
                        </div>

                        <!-- Status steps -->
                        <div class="step flex flex-col items-center relative z-10" data-step="pending">
                            <div class="step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z" />
                                </svg>
                            </div>
                            <span class="step-label text-xs mt-2 text-center text-gray-500">Order Placed</span>
                        </div>

                        <div class="step flex flex-col items-center relative z-10" data-step="confirmed">
                            <div class="step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="step-label text-xs mt-2 text-center text-gray-500">Confirmed</span>
                        </div>

                        <div class="step flex flex-col items-center relative z-10" data-step="assembled">
                            <div class="step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311L4.5 7.65311ZM12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM6.49896 9.97065L11 12.5765V17.625H13V12.5765L17.501 9.97066L16.499 8.2398L12 10.8445L7.50104 8.2398L6.49896 9.97065Z" />
                                </svg>
                            </div>
                            <span class="step-label text-xs mt-2 text-center text-gray-500">Assembled</span>
                        </div>

                        <div class="step flex flex-col items-center relative z-10" data-step="shipped">
                            <div class="step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                                </svg>
                            </div>
                            <span class="step-label text-xs mt-2 text-center text-gray-500">Shipped</span>
                        </div>

                        <div class="step flex flex-col items-center relative z-10" data-step="delivered">
                            <div class="step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z" />
                                </svg>
                            </div>
                            <span class="step-label text-xs mt-2 text-center text-gray-500">Delivered</span>
                        </div>

                        <div class="step flex flex-col items-center relative z-10" data-step="paid">
                            <div class="step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500">
                                <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z" />
                                </svg>
                            </div>
                            <span class="step-label text-xs mt-2 text-center text-gray-500">Payment Complete</span>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-4">
                    <h3 class="font-medium text-gray-800 mb-3">Order Items</h3>
                    <div class="space-y-3">
                        <?php foreach ($order->orderItems as $orderItem): ?>
                            <div class="flex justify-between items-center py-2 px-3 bg-gray-100 rounded-lg">
                                <div class="flex-1">
                                    <span class="text-gray-800 font-medium"><?= $orderItem->items->item_name ?></span>
                                    <div class="text-sm text-gray-500">Qty: <?= $orderItem->quantity ?></div>
                                </div>
                                <div class="text-right">
                                    <span class="font-medium text-gray-900">₱<?= number_format($orderItem->unit_price * $orderItem->quantity, 2) ?></span>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <!-- Order total -->
                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                    <span class="font-semibold text-gray-800">Total</span>
                    <span class="font-bold text-xl text-[#815331]">₱<?= number_format($order->total_amount, 2) ?></span>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <!-- Pagination -->
    <div class="pagination mt-4 flex justify-center"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status configuration
        const statusConfig = {
            'pending': {
                index: 0
            },
            'confirmed': {
                index: 1
            },
            'assembled': {
                index: 2
            },
            'shipped': {
                index: 3
            },
            'delivered': {
                index: 4
            },
            'paid': {
                index: 5
            }
        };

        // Update progress bars
        document.querySelectorAll('.progress-container').forEach(container => {
            const status = container.dataset.status;
            const config = statusConfig[status] || statusConfig['pending'];
            const currentIndex = config.index;

            // Update progress line
            const progressLine = container.querySelector('.progress-line');
            const progressPercentage = currentIndex > 0 ? (currentIndex / 5) * 100 : 0;
            progressLine.style.width = progressPercentage + '%';

            // Update steps
            const steps = container.querySelectorAll('.step');
            steps.forEach((step, index) => {
                const circle = step.querySelector('.step-circle');
                const label = step.querySelector('.step-label');

                if (index <= currentIndex) {
                    // Completed step
                    circle.className = 'step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-[#815331] text-white';
                    label.className = 'step-label text-xs mt-2 text-center text-[#815331] font-medium';
                } else {
                    // Pending step
                    circle.className = 'step-circle w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium bg-gray-300 text-gray-500';
                    label.className = 'step-label text-xs mt-2 text-center text-gray-500';
                }
            });
        });
    });
</script>

<script>
    // Pagination
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            valueNames: ['order-name', 'status'], // Optional for searching/sorting
            page: 5,
            pagination: true
        };

        var orderLists = new List('order-list', options);
    });
</script>

<?php layout('customer/footer') ?>