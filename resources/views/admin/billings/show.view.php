<?php layout('admin/header') ?>

<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold text-gray-900">Billing Details</h1>
        <p class="text-gray-600">View billing information for order #<?= str_pad($billings->order_id, 4, '0', STR_PAD_LEFT) ?></p>
    </div>
    <div class="flex space-x-3">
        <a href="/admin/billings"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Billings
        </a>
        <button onclick="printBilling()"
            class="inline-flex items-center px-4 py-2 bg-[#815331] text-white rounded-lg text-sm font-medium hover:bg-[#6d4429] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Billing
        </button>
    </div>
</div>

<div>
    <!-- Payment Status Alert -->
    <?php if ($billings->payment_status === 'paid'): ?>
        <div class="p-4 mb-8 text-green-800 border border-green-200 rounded-lg bg-green-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Payment Completed</h3>
                    <div class="mt-1 text-sm">
                        <p>Amount: ₱<?= number_format($billings->amount_paid, 2) ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="p-4 mb-8 text-red-800 border border-red-200 rounded-lg bg-red-50">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Payment Pending</h3>
                    <div class="mt-1 text-sm">
                        <p>Amount Due: ₱<?= number_format($billings->amount_paid, 2) ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <!-- 2-Column Grid Layout -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

        <!-- Left Column - Billing Information -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Billing Information</h3>

            <!-- Billing ID -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Billing ID</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    #<?= str_pad($billings->id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <!-- Order ID -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Order ID</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    #<?= str_pad($billings->order_id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Payment Method</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <div class="flex items-center gap-2">
                        <?php if ($billings->payment_method === 'cash'): ?>
                            <svg class="w-5 h-5 text-green-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M4 8.5h16v7H4z" />
                                <circle cx="12" cy="12" r="2.25" stroke="currentColor" stroke-width="2" />
                            </svg>
                            <span>Cash on Delivery</span>
                        <?php elseif ($billings->payment_method === 'gcash'): ?>
                            <svg class="w-5 h-5 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-6 3V7Z" />
                            </svg>
                            <span>GCash</span>
                        <?php else: ?>
                            <svg class="w-5 h-5 text-purple-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 10V7l7-4 7 4v3M6 14v6m4-6v6m4-6v6m4-6v6" />
                            </svg>
                            <span>Bank Transfer</span>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <!-- Amount -->
            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Amount</label>
                <div class="w-full px-4 py-3 font-bold text-[#815331] border border-gray-200 rounded-lg bg-gray-50">
                    ₱<?= number_format($billings->amount_paid, 2) ?>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="grid grid-cols-1 gap-4">
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Issued Date</label>
                    <div class="w-full px-4 py-3 text-sm text-gray-600 border border-gray-200 rounded-lg bg-gray-50">
                        <?= date('M d, Y \a\t g:i A', strtotime($billings->issued_at)) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Customer & Order Info -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Customer & Order Details</h3>

            <?php if (isset($order) && $order): ?>
                <!-- Customer Info -->
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Customer Name</label>
                    <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                        <?= $order->user->name ?? 'N/A' ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Customer Email</label>
                    <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                        <?= $order->user->email ?? 'N/A' ?>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Order Status</label>
                    <div class="w-full px-4 py-3 font-bold border border-gray-200 rounded-lg bg-gray-50">
                        <span class="inline-flex items-center
                        <?php if ($order->status === 'pending'): ?>text-yellow-600
                        <?php elseif ($order->status === 'confirmed'): ?>text-blue-600
                        <?php elseif ($order->status === 'shipped'): ?>text-indigo-600
                        <?php elseif ($order->status === 'delivered'): ?>text-green-600
                        <?php elseif ($order->status === 'cancelled'): ?>text-red-600
                        <?php elseif ($order->status === 'paid'): ?>text-emerald-600
                        <?php else: ?>text-gray-600<?php endif ?>">
                            <?= ucfirst($order->status) ?>
                        </span>
                    </div>
                </div>

                <!-- Delivery Address -->
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Delivery Address</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 min-h-[80px]">
                        <?= $order->delivery_address ?? 'No address provided' ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <!-- Ordered Items Section -->
    <?php if (isset($orderItems) && !empty($orderItems)): ?>
        <div class="mt-8">
            <h3 class="pb-4 text-lg font-semibold text-gray-900 border-b border-gray-200">Ordered Item(s)</h3>

            <div class="mt-6 space-y-4">
                <?php foreach ($orderItems as $item): ?>
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-4">
                            <!-- Item Image -->
                            <div class="flex-shrink-0">
                                <?php if (isset($item->inventory) && !empty($item->inventory->item_image_1)): ?>
                                    <img src="/storage/items-img/<?= $item->inventory->item_image_1 ?>"
                                        alt="<?= $item->inventory->item_name ?? 'Item' ?>"
                                        class="object-cover w-16 h-16 border border-gray-200 rounded-lg">
                                <?php else: ?>
                                    <div class="flex items-center justify-center w-16 h-16 bg-gray-100 border border-gray-200 rounded-lg">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                <?php endif ?>
                            </div>

                            <!-- Item Details -->
                            <div class="flex-1">
                                <span class="text-sm font-medium text-gray-900">
                                    <?= $item->inventory->item_name ?? 'Unknown Item' ?>
                                </span>
                                <p class="text-sm text-gray-500">
                                    <?= $item->inventory->category ?? 'N/A' ?>
                                </p>
                                <div class="flex items-center mt-1 text-sm text-gray-600">
                                    <div class="flex space-x-4">
                                        <span>Qty: <?= $item->quantity ?></span>
                                        <span>Unit Price: ₱<?= number_format($item->unit_price, 2) ?></span>
                                    </div>
                                    <span class="ml-auto font-semibold text-base text-[#815331]">
                                        Subtotal: ₱<?= number_format($item->quantity * $item->unit_price, 2) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <!-- Action Buttons -->
    <div class="pt-6 mt-8 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <a href="/admin/billings"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Billings
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    function printBilling() {
        const printWindow = window.open('', '_blank');

        const printContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Billing #<?= str_pad($billings->id, 4, '0', STR_PAD_LEFT) ?></title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 40px;
                    color: #333;
                }
                .print-header {
                    text-align: center;
                    margin-bottom: 30px;
                }
                .print-header h1 {
                    color: #815331;
                    margin: 0;
                    font-size: 24px;
                }
                .print-header h2 {
                    margin: 5px 0;
                    font-size: 20px;
                    color: #444;
                }
                .print-header p {
                    font-size: 14px;
                    color: #666;
                }
                .billing-info {
                    margin-bottom: 25px;
                    background: #faf9f8;
                }
                .billing-info p {
                    margin: 4px 0;
                    font-size: 14px;
                    line-height: 1.6; 
                }
                .items-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 40px;
                    font-size: 14px;
                }
                .items-table th, .items-table td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                .items-table th {
                    background-color: #815331;
                    text-align: center;
                }
                .items-table td {
                    background: #fff;
                }
                .items-table tr:nth-child(even) td {
                    background: #f9f6f4;
                }
                .total {
                    margin-top: 25px;
                    text-align: right;
                    font-size: 16px;
                    font-weight: bold;
                    color: #815331;
                }
                .footer {
                    margin-top: 40px; 
                    text-align: center; 
                    font-size: 12px;
                }
                @media print {
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-header">
                <h1>ABG Prime Builder Supplies Inc.</h1>
                <h2>Billing Statement</h2>
                <p>Billing ID: #<?= str_pad($billings->id, 4, '0', STR_PAD_LEFT) ?></p>
            </div>
            
            <div class="billing-info">
                <p><strong>Customer:</strong> <?= $order->user->name ?? 'N/A' ?></p>
                <p><strong>Email:</strong> <?= $order->user->email ?? 'N/A' ?></p>
                <p><strong>Order ID:</strong> #<?= str_pad($billings->order_id, 4, '0', STR_PAD_LEFT) ?></p>
                <p><strong>Payment Method:</strong> <?= ucfirst($billings->payment_method) ?></p>
                <p><strong>Status:</strong> <?= ucfirst($billings->payment_status) ?></p>
                <p><strong>Date:</strong> <?= date('M d, Y g:i A', strtotime($billings->issued_at)) ?></p>
            </div>
            
            <?php if (isset($orderItems) && !empty($orderItems)): ?>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td><?= $item->inventory->item_name ?? 'Unknown Item' ?></td>
                                <td><?= $item->inventory->category ?? 'N/A' ?></td>
                                <td style="text-align:center;"><?= $item->quantity ?></td>
                                <td style="text-align:right;">₱<?= number_format($item->unit_price, 2) ?></td>
                                <td style="text-align:right;">₱<?= number_format($item->quantity * $item->unit_price, 2) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
            
            <div class="total">
                <p>Total Amount: ₱<?= number_format($billings->amount_paid, 2) ?></p>
            </div>

            <div class="footer">
                <p>Thank you for your business!</p>
                <p>For inquiries, please contact us at your convenience.</p>
            </div>
        </body>
        </html>
    `;

        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }
</script>

<?php layout('admin/footer') ?>