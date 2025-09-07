<?php layout('admin/header') ?>

<!-- Header section -->
<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold leading-tight text-gray-900">Billing Details</h1>
        <p class="text-base font-normal text-gray-600">View and manage billing information for order #<?= $billings->order_id ?></p>
    </div>
    <div class="flex gap-3">
        <a href="/admin/billings" class="px-4 py-2 text-sm font-medium text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
            Back to Billings
        </a>
        <?php if ($billings->payment_status === 'unpaid'): ?>
            <button onclick="markAsPaid(<?= $billings->id ?>)" class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                Mark as Paid
            </button>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Billing Information -->
    <div class="space-y-6 lg:col-span-2">
        <!-- Payment Status Card -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Payment Information</h3>
                <div class="flex items-center gap-2">
                    <?php if ($billings->payment_status === 'paid'): ?>
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Paid
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Unpaid
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Billing ID</label>
                        <p class="font-mono text-lg font-semibold text-gray-900">#<?= str_pad($billings->id, 6, '0', STR_PAD_LEFT) ?></p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Payment Method</label>
                        <div class="flex items-center gap-2">
                            <?php if ($billings->payment_method === 'cash'): ?>
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Cash on Delivery</span>
                            <?php elseif ($billings->payment_method === 'gcash'): ?>
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">GCash</span>
                            <?php else: ?>
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Bank Transfer</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Amount Paid</label>
                        <p class="text-2xl font-bold text-[#815331]">₱<?= number_format($billings->amount_paid, 2) ?></p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Order ID</label>
                        <a href="/admin/orders/show/<?= $billings->order_id ?>" class="font-mono text-lg font-semibold text-blue-600 transition-colors hover:text-blue-800">
                            #<?= str_pad($billings->order_id, 6, '0', STR_PAD_LEFT) ?>
                        </a>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Issued Date</label>
                        <p class="text-sm text-gray-900"><?= date('F d, Y g:i A', strtotime($billings->issued_at)) ?></p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Days Since Issued</label>
                        <p class="text-sm text-gray-600"><?= floor((time() - strtotime($billings->issued_at)) / (60 * 60 * 24)) ?> days ago</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <?php if (isset($order)): ?>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Order Details</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Customer</label>
                        <p class="text-sm font-medium text-gray-900"><?= $order->user->name ?? 'N/A' ?></p>
                        <p class="text-xs text-gray-500"><?= $order->user->email ?? 'N/A' ?></p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Order Status</label>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            <?php if ($order->status === 'pending'): ?>bg-yellow-100 text-yellow-800
                            <?php elseif ($order->status === 'confirmed'): ?>bg-blue-100 text-blue-800
                            <?php elseif ($order->status === 'shipped'): ?>bg-indigo-100 text-indigo-800
                            <?php elseif ($order->status === 'delivered'): ?>bg-green-100 text-green-800
                            <?php elseif ($order->status === 'cancelled'): ?>bg-red-100 text-red-800
                            <?php else: ?>bg-gray-100 text-gray-800<?php endif; ?>">
                            <?= ucfirst($order->status) ?>
                        </span>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Total Amount</label>
                        <p class="text-lg font-bold text-[#815331]">₱<?= number_format($order->total_amount, 2) ?></p>
                    </div>
                </div>
                
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">Delivery Address</label>
                    <p class="text-sm text-gray-900"><?= $order->delivery_address ?? 'N/A' ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Actions Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Quick Actions</h3>
            <div class="space-y-3">
                <?php if ($billings->payment_status === 'unpaid'): ?>
                    <button onclick="markAsPaid(<?= $billings->id ?>)" class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                        Mark as Paid
                    </button>
                    <button onclick="sendReminder(<?= $billings->id ?>)" class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-yellow-600 rounded-lg hover:bg-yellow-700">
                        Send Payment Reminder
                    </button>
                <?php endif; ?>
                <button onclick="printBilling(<?= $billings->id ?>)" class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                    Print Billing
                </button>
                <button onclick="downloadPDF(<?= $billings->id ?>)" class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-purple-600 rounded-lg hover:bg-purple-700">
                    Download PDF
                </button>
            </div>
        </div>

        <!-- Payment History -->
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Payment Timeline</h3>
            <div class="space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 mt-2 bg-blue-500 rounded-full"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Billing Created</p>
                        <p class="text-xs text-gray-500"><?= date('M d, Y g:i A', strtotime($billings->issued_at)) ?></p>
                    </div>
                </div>
                <?php if ($billings->payment_status === 'paid'): ?>
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 mt-2 bg-green-500 rounded-full"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Payment Received</p>
                        <p class="text-xs text-gray-500">₱<?= number_format($billings->amount_paid, 2) ?></p>
                    </div>
                </div>
                <?php else: ?>
                <div class="flex items-start gap-3">
                    <div class="w-2 h-2 mt-2 bg-red-500 rounded-full"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Payment Pending</p>
                        <p class="text-xs text-gray-500">Awaiting payment</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function markAsPaid(billingId) {
    if (confirm('Are you sure you want to mark this billing as paid?')) {
        fetch(`/admin/billings/${billingId}/mark-paid`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating payment status');
            }
        })
        .catch(error => {
            alert('Error updating payment status');
        });
    }
}

function sendReminder(billingId) {
    if (confirm('Send payment reminder to customer?')) {
        fetch(`/admin/billings/${billingId}/send-reminder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Payment reminder sent successfully');
            } else {
                alert('Error sending reminder');
            }
        });
    }
}

function printBilling(billingId) {
    window.open(`/admin/billings/${billingId}/print`, '_blank');
}

function downloadPDF(billingId) {
    window.open(`/admin/billings/${billingId}/pdf`, '_blank');
}
</script>

<?php layout('admin/footer') ?>