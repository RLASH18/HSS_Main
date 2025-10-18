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
        <input type="text" id="order-search" placeholder="Search by order ID, customer name, or items..."
            class="w-full pl-11 pr-3 py-3 border border-gray-300 rounded-lg text-sm bg-white transition-all duration-200 focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
    </div>
    <div class="flex gap-3">
        <select id="status-filter"
            class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[160px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="assembled">Assembled</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="paid">Paid</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <select id="date-filter"
            class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[140px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
            <option value="">All Dates</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="this-week">This Week</option>
            <option value="this-month">This Month</option>
            <option value="last-month">Last Month</option>
        </select>
        <select id="amount-filter"
            class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[140px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
            <option value="">All Amounts</option>
            <option value="0-1000">₱0 - ₱1,000</option>
            <option value="1000-5000">₱1,000 - ₱5,000</option>
            <option value="5000-10000">₱5,000 - ₱10,000</option>
            <option value="10000+">₱10,000+</option>
        </select>
    </div>
</div>

<!-- End of Search Filter -->

<div id="orders-container">
    <div class="list grid grid-cols-3 gap-4 auto-rows-max">
        <?php foreach ($orders as $order): ?>
            <div class="p-4 bg-white shadow rounded-lg flex flex-col" data-order="<?= $order->id ?>">
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
                            <h2 class="order-id text-base font-semibold">Order #<?= str_pad($order->id, 4, '0', STR_PAD_LEFT) ?></h2>
                            <p class="customer-name text-[#757575]"><strong></strong> <?= $order->user->name ?></p>
                        </div>
                    </div>
                    <div>
                        <?php if ($order->status === 'pending'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-orange-500 text-white text-[10px] px-3 py-1">
                                Pending
                            </p>
                        <?php elseif ($order->status === 'confirmed'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-blue-600 text-white text-[10px] px-3 py-1">
                                Confirmed
                            </p>
                        <?php elseif ($order->status === 'assembled'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-indigo-600 text-white text-[10px] px-3 py-1">
                                Assembled
                            </p>
                        <?php elseif ($order->status === 'shipped'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-sky-600 text-white text-[10px] px-3 py-1">
                                Shipped
                            </p>
                        <?php elseif ($order->status === 'paid'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-green-600 text-white text-[10px] px-3 py-1">
                                Paid
                            </p>
                        <?php elseif ($order->status === 'cancelled'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-red-600 text-white text-[10px] px-3 py-1">
                                Cancelled
                            </p>
                        <?php elseif ($order->status === 'delivered'): ?>
                            <p class="status-badge flex justify-center rounded-2xl bg-emerald-600 text-white text-[10px] px-3 py-1">
                                Delivered
                            </p>
                        <?php endif ?>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div class="my-2 flex flex-col">
                        <p class="text-sm text-[#757575]">Total Amount</p>
                        <p class="total-amount font-bold text-xl">₱<?= number_format($order->total_amount, 2) ?></p>
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
                            <p class="order-date text-xs leading-5 text-[#757575]">
                                <?= date('M d, Y h:i A', strtotime($order->created_at)) ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Items ordered -->
                <div class="my-3">
                    <p class="text-[#757575]">Items (<?= count($order->orderItems) ?>):</p>
                    <div class="flex flex-wrap gap-1 text-xs text-gray-600">
                        <?php 
                        $maxVisibleItems = 3;
                        $totalItems = count($order->orderItems);
                        $itemsToShow = array_slice($order->orderItems, 0, $maxVisibleItems);
                        $remainingCount = $totalItems - $maxVisibleItems;
                        
                        foreach ($itemsToShow as $orderItem): 
                            // Truncate item name to 5 words
                            $words = explode(' ', $orderItem->items->item_name);
                            $truncatedName = implode(' ', array_slice($words, 0, 5));
                            if (count($words) > 5) {
                                $truncatedName .= '...';
                            }
                        ?>
                            <span class="order-items bg-gray-100 px-2 py-1 rounded text-sm mt-1" title="<?= htmlspecialchars($orderItem->items->item_name) ?>">
                                <?= $truncatedName ?> (<?= $orderItem->quantity ?>)
                            </span>
                        <?php endforeach ?>
                        
                        <?php if ($remainingCount > 0): ?>
                            <span class="bg-[#815331] text-white px-2 py-1 rounded-full text-xs mt-2 font-base">
                                +<?= $remainingCount ?> more
                            </span>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Spacer to push buttons to bottom -->
                <div class="flex-grow"></div>

                <!-- All Buttons in 2x2 Grid -->
                <div class="grid grid-cols-2 gap-2 mt-auto">
                    <?php if ($order->status === 'pending'): ?>
                        <!-- Confirm -->
                        <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status" class="contents">
                            <?= csrf_token() ?>
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" onclick="updateProgress(<?= $order->id ?>, 'confirmed')"
                                class="flex items-center justify-center bg-[#815331] hover:bg-[#6d4529] text-white px-2 py-1.5 rounded text-xs w-full">
                                Confirm
                            </button>
                        </form>
                        <!-- Cancel -->
                        <form method="POST" action="/admin/orders/<?= $order->id ?>/cancel" class="contents">
                            <?= csrf_token() ?>
                            <button type="submit" onclick="updateProgress(<?= $order->id ?>, 'cancelled')"
                                class="flex items-center justify-center bg-red-600 hover:bg-red-700 text-white px-2 py-1.5 rounded text-xs w-full">
                                Cancel
                            </button>
                        </form>

                    <?php elseif ($order->status === 'confirmed'): ?>
                        <!-- Assembled -->
                        <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status" class="contents">
                            <?= csrf_token() ?>
                            <input type="hidden" name="status" value="assembled">
                            <button type="submit" onclick="updateProgress(<?= $order->id ?>, 'assembled')"
                                class="flex items-center justify-center bg-[#815331] hover:bg-[#6d4529] text-white px-2 py-1.5 rounded text-xs w-full">
                                Assembled
                            </button>
                        </form>

                    <?php elseif ($order->status === 'assembled'): ?>
                        <!-- Shipped -->
                        <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status" class="contents">
                            <?= csrf_token() ?>
                            <input type="hidden" name="status" value="shipped">
                            <button type="submit" onclick="updateProgress(<?= $order->id ?>, 'shipped')"
                                class="flex items-center justify-center bg-[#815331] hover:bg-[#6d4529] text-white px-2 py-1.5 rounded text-xs w-full">
                                Shipped
                            </button>
                        </form>

                    <?php elseif ($order->status === 'shipped'): ?>
                        <!-- Delivered -->
                        <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status" class="contents">
                            <?= csrf_token() ?>
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" onclick="updateProgress(<?= $order->id ?>, 'delivered')"
                                class="flex items-center justify-center bg-[#815331] hover:bg-[#6d4529] text-white px-2 py-1.5 rounded text-xs w-full">
                                Delivered
                            </button>
                        </form>

                    <?php elseif ($order->status === 'delivered'): ?>
                        <!-- Paid -->
                        <form method="POST" action="/admin/orders/<?= $order->id ?>/update-status" class="contents">
                            <?= csrf_token() ?>
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" onclick="updateProgress(<?= $order->id ?>, 'paid')"
                                class="flex items-center justify-center bg-[#815331] hover:bg-[#6d4529] text-white px-2 py-1.5 rounded text-xs w-full">
                                Mark Paid
                            </button>
                        </form>
                    <?php endif ?>

                    <!-- See Details Button (Always Visible) -->
                    <a href="/admin/orders/<?= $order->id ?>" class="flex items-center justify-center gap-1 bg-slate-700 hover:bg-slate-800 text-white transition-colors duration-200 px-2 py-1.5 rounded text-xs w-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Details
                    </a>

                    <!-- View Progress Button (Always Visible) -->
                    <button onclick="toggleProgress(<?= $order->id ?>)" id="progress-btn-<?= $order->id ?>" class="flex items-center justify-center gap-1 text-gray-600 hover:text-[#815331] transition-colors duration-200 px-2 py-1.5 rounded border text-xs w-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span id="progress-text-<?= $order->id ?>">Progress</span>
                    </button>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pagination mt-6 flex justify-center"></div>
</div>

<!-- Progress Modal Overlay -->
<div id="progress-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-lg w-full max-h-[80vh] overflow-hidden shadow-2xl">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50 rounded-t-xl">
            <div>
                <h3 class="text-lg font-semibold text-gray-900" id="modal-order-title">Order Progress</h3>
                <p class="text-sm text-gray-500" id="modal-order-subtitle">Track your order status</p>
            </div>
            <button onclick="closeProgressModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 rounded-full hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Modal Content -->
        <div class="p-6">
            <p class="text-sm text-gray-500 mb-6" id="modal-order-date">
                Order placed on...
            </p>

            <div class="relative" id="modal-timeline">
                <!-- Timeline content will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize List.js WITHOUT pagination (we'll handle it manually)
        var options = {
            valueNames: [
                'order-id',
                'customer-name',
                'total-amount',
                'order-date',
                'order-items',
                'status-badge'
            ],
            page: 9, // Cards for page
            pagination: false // Disable List.js pagination
        };

        var orderList = new List('orders-container', options);

        // Custom pagination with URL query parameters
        function setupCustomPagination() {
            const itemsPerPage = 9;
            const totalItems = orderList.matchingItems.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            
            // Get current page from URL
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = parseInt(urlParams.get('page')) || 1;
            
            // Show items for current page
            orderList.show((currentPage - 1) * itemsPerPage + 1, itemsPerPage);
            
            // Generate pagination HTML
            const paginationContainer = document.querySelector('.pagination');
            if (!paginationContainer) return;
            
            let paginationHTML = '';
            
            // Previous button
            if (currentPage > 1) {
                const prevPage = currentPage - 1;
                const prevUrl = prevPage === 1 ? window.location.pathname : `?page=${prevPage}`;
                paginationHTML += `<a href="${prevUrl}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>`;
            }
            
            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHTML += `<span class="px-3 py-2 text-sm font-medium text-white bg-[#815331] border border-[#815331] rounded-md">${i}</span>`;
                } else {
                    // For page 1, use clean URL without query parameter
                    const pageUrl = i === 1 ? window.location.pathname : `?page=${i}`;
                    paginationHTML += `<a href="${pageUrl}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">${i}</a>`;
                }
            }
            
            // Next button
            if (currentPage < totalPages) {
                paginationHTML += `<a href="?page=${currentPage + 1}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>`;
            }
            
            paginationContainer.innerHTML = paginationHTML;
        }
        
        // Initial pagination setup
        setupCustomPagination();

        // Custom filter functions for dropdowns
        const searchInput = document.getElementById('order-search');
        const statusFilter = document.getElementById('status-filter');
        const dateFilter = document.getElementById('date-filter');
        const amountFilter = document.getElementById('amount-filter');

        function applyFilters() {
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';

            orderList.filter(function(item) {
                let show = true;

                // Search filter
                if (searchTerm) {
                    const values = item.values();
                    const orderText = ` ${values['order-id']} ${values['customer-name']} ${values['total-amount']} ${values['order-date']} ${values['status-badge']}`.toLowerCase();
                    show = orderText.includes(searchTerm);
                }

                // Status filter
                if (statusFilter.value) {
                    const statusElement = item.elm.querySelector('.status-badge');
                    if (statusElement) {
                        const status = statusElement.textContent.toLowerCase().trim();
                        show = show && status === statusFilter.value.toLowerCase();
                    } else {
                        show = false;
                    }
                }

                // Amount filter
                if (amountFilter.value) {
                    const amountElement = item.elm.querySelector('.total-amount');
                    if (amountElement) {
                        const amountText = amountElement.textContent.replace(/[₱,\s]/g, '');
                        const amount = parseFloat(amountText);

                        if (!isNaN(amount)) {
                            switch (amountFilter.value) {
                                case '0-1000':
                                    show = show && (amount >= 0 && amount <= 1000);
                                    break;
                                case '1000-5000':
                                    show = show && (amount > 1000 && amount <= 5000);
                                    break;
                                case '5000-10000':
                                    show = show && (amount > 5000 && amount <= 10000);
                                    break;
                                case '10000+':
                                    show = show && (amount > 10000);
                                    break;
                            }
                        }
                    }
                }

                // Date filter 
                if (dateFilter.value) {
                    const dateElement = item.elm.querySelector('.order-date');
                    if (dateElement) {
                        const orderDate = new Date(dateElement.textContent);
                        const today = new Date();
                        const yesterday = new Date(today);
                        yesterday.setDate(yesterday.getDate() - 1);
                        const weekStart = new Date(today);
                        weekStart.setDate(today.getDate() - today.getDay());
                        const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                        const lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);

                        switch (dateFilter.value) {
                            case 'today':
                                show = show && orderDate.toDateString() === today.toDateString();
                                break;
                            case 'yesterday':
                                show = show && orderDate.toDateString() === yesterday.toDateString();
                                break;
                            case 'this-week':
                                show = show && orderDate >= weekStart && orderDate <= today;
                                break;
                            case 'this-month':
                                show = show && orderDate >= monthStart && orderDate <= today;
                                break;
                            case 'last-month':
                                show = show && orderDate >= lastMonthStart && orderDate <= lastMonthEnd;
                                break;
                        }
                    }
                }

                return show;
            });
            
            // Update pagination after filtering
            setupCustomPagination();
        }

        // Add event listeners for filters
        if (searchInput) searchInput.addEventListener('input', applyFilters);
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
        if (dateFilter) dateFilter.addEventListener('change', applyFilters);
        if (amountFilter) amountFilter.addEventListener('change', applyFilters);
    });

    function toggleProgress(orderId) {
        // Find the order data from the card
        const orderCard = document.querySelector(`[data-order="${orderId}"]`);
        if (!orderCard) return;

        const orderIdText = orderCard.querySelector('.order-id').textContent;
        const customerName = orderCard.querySelector('.customer-name').textContent;
        const orderDate = orderCard.querySelector('.order-date').textContent;

        // Update modal header
        document.getElementById('modal-order-title').textContent = `${orderIdText} Progress`;
        document.getElementById('modal-order-subtitle').textContent = `Customer: ${customerName}`;
        document.getElementById('modal-order-date').textContent = `Order placed on ${orderDate}`;

        // Generate timeline content
        generateModalTimeline(orderId, orderCard);

        // Show modal and prevent body scroll
        const modal = document.getElementById('progress-modal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeProgressModal() {
        const modal = document.getElementById('progress-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function generateModalTimeline(orderId, orderCard) {
        // Get order status from the status badge
        const statusBadge = orderCard.querySelector('.status-badge');
        const currentStatus = statusBadge.textContent.toLowerCase().trim();
        
        const timeline = document.getElementById('modal-timeline');
        
        // Define status hierarchy and details
        const statuses = [
            { key: 'pending', label: 'Order Placed', icon: 'clock', description: 'Order has been received and is being processed' },
            { key: 'confirmed', label: 'Confirmed', icon: 'check', description: 'Order has been confirmed and payment verified' },
            { key: 'assembled', label: 'Assembled', icon: 'box', description: 'Items have been assembled and prepared for shipment' },
            { key: 'shipped', label: 'Shipped', icon: 'truck', description: 'Order is out for delivery' },
            { key: 'delivered', label: 'Delivered', icon: 'location', description: 'Order has been successfully delivered' },
            { key: 'paid', label: 'Paid', icon: 'credit-card', description: 'Payment has been completed' }
        ];

        const statusOrder = ['pending', 'confirmed', 'assembled', 'shipped', 'delivered', 'paid'];
        const currentIndex = statusOrder.indexOf(currentStatus);

        let timelineHTML = '';

        statuses.forEach((status, index) => {
            const isCompleted = index <= currentIndex;
            const isCurrent = index === currentIndex;
            const isLast = index === statuses.length - 1;

            const iconSVGs = {
                'clock': '<path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z" />',
                'check': '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>',
                'box': '<path d="M4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311L4.5 7.65311ZM12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM6.49896 9.97065L11 12.5765V17.625H13V12.5765L17.501 9.97066L16.499 8.2398L12 10.8445L7.50104 8.2398L6.49896 9.97065Z" />',
                'truck': '<path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />',
                'location': '<path d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z" />',
                'credit-card': '<path d="M3.00488 2.99979H21.0049C21.5572 2.99979 22.0049 3.4475 22.0049 3.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979ZM20.0049 10.9998H4.00488V18.9998H20.0049V10.9998ZM20.0049 8.99979V4.99979H4.00488V8.99979H20.0049ZM14.0049 14.9998H18.0049V16.9998H14.0049V14.9998Z" />'
            };

            timelineHTML += `
                <div class="flex items-start gap-4 relative ${!isLast ? 'pb-4' : 'pb-2'}">
                    <!-- Status Circle -->
                    <div class="w-10 h-10 rounded-full ${isCompleted ? 'bg-[#815331]' : 'bg-gray-300'} flex items-center justify-center z-10 relative flex-shrink-0 shadow-sm">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            ${iconSVGs[status.icon]}
                        </svg>
                        <!-- Timeline Line - extends to connect with next circle -->
                        ${!isLast ? `<div class="absolute left-1/2 top-full w-0.5 h-10 ${index < currentIndex ? 'bg-[#815331]' : 'bg-gray-300'} transform -translate-x-1/2"></div>` : ''}
                    </div>
                    
                    <!-- Status Content -->
                    <div class="flex-1 pt-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="font-semibold text-base ${isCompleted ? 'text-gray-900' : 'text-gray-400'}">${status.label}</h4>
                            ${isCurrent ? '<span class="text-xs bg-[#815331] text-white px-2 py-1 rounded-full font-medium">Current</span>' : ''}
                        </div>
                        <p class="text-sm leading-relaxed ${isCompleted ? 'text-gray-600' : 'text-gray-400'}">${status.description}</p>
                    </div>
                </div>
            `;
        });

        timeline.innerHTML = timelineHTML;
    }

    // Close modal when clicking outside
    document.getElementById('progress-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeProgressModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProgressModal();
        }
    });

    function updateProgress(orderId, newStatus) {
        // Store the new status for this order
        window.orderStatuses = window.orderStatuses || {};
        window.orderStatuses[orderId] = newStatus;

        // Update status badge immediately
        const statusBadge = document.querySelector(`[data-order="${orderId}"] .status-badge`);
        if (statusBadge) {
            updateStatusBadge(statusBadge, newStatus);
        }

        // If modal is open for this order, update the timeline
        const modal = document.getElementById('progress-modal');
        if (!modal.classList.contains('hidden')) {
            const orderCard = document.querySelector(`[data-order="${orderId}"]`);
            if (orderCard) {
                generateModalTimeline(orderId, orderCard);
            }
        }
    }

    function updateStatusBadge(badge, status) {
        // Remove all existing classes and add base classes
        badge.className = 'status-badge flex justify-center rounded-2xl text-white text-[10px] px-3 py-1';

        // Add appropriate classes based on status
        switch (status) {
            case 'pending':
                badge.className += ' bg-orange-500';
                badge.textContent = 'Pending';
                break;
            case 'confirmed':
                badge.className += ' bg-blue-600';
                badge.textContent = 'Confirmed';
                break;
            case 'assembled':
                badge.className += ' bg-indigo-600';
                badge.textContent = 'Assembled';
                break;
            case 'shipped':
                badge.className += ' bg-sky-600';
                badge.textContent = 'Shipped';
                break;
            case 'delivered':
                badge.className += ' bg-emerald-600';
                badge.textContent = 'Delivered';
                break;
            case 'paid':
                badge.className += ' bg-green-600';
                badge.textContent = 'Paid';
                break;
            case 'cancelled':
                badge.className += ' bg-red-600';
                badge.textContent = 'Cancelled';
                break;
        }
    }
</script>

<?php layout('admin/footer') ?>