<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Billings</h1>
        <p class="text-gray-600 text-base font-normal">Keep your billing records organized</p>
    </div>
</div>

<div class="admin-cards-container grid grid-cols-2 gap-5 my-4">
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Total Revenue</p>
            <p></p>
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
            <p>Pending amount</p>
            <p></p>
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
            <p>Total Transactions</p>
            <p></p>
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
            <p>Success Rate</p>
            <p></p>
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

<div class="custom-datatable bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200">
    <table id="billing-table" class="w-full border-collapse text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Bill ID</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Order ID</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Payment Method</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Status</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Amount</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Date Issued</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($billings as $billing): ?>
                <tr>
                    <td class="px-5 py-4 border-b border-gray-100 text-black-500 font-semibold font-mono">#<?= str_pad($billing->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-500 font-semibold font-mono">#<?= str_pad($billing->orders->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <?php if ($billing->payment_method === 'gcash'): ?>
                            <span class="inline-flex items-center gap-1 rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-6 3V7Z" />
                                </svg>
                                GCash
                            </span>
                        <?php elseif ($billing->payment_method === 'cash'): ?>
                            <span class="inline-flex items-center gap-1 rounded-full border border-green-200 bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M4 8.5h16v7H4z" />
                                    <circle cx="12" cy="12" r="2.25" stroke="currentColor" stroke-width="2" />
                                </svg>
                                Cash
                            </span>
                        <?php elseif ($billing->payment_method === 'bank_transfer' || $billing->payment_method === 'bank' || $billing->payment_method === 'bank transfer'): ?>
                            <span class="inline-flex items-center gap-1 rounded-full border border-purple-200 bg-purple-50 px-2.5 py-1 text-xs font-medium text-purple-700">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 10V7l7-4 7 4v3M6 14v6m4-6v6m4-6v6m4-6v6" />
                                </svg>
                                Bank Transfer
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-xs font-medium text-gray-700">
                                <?= ucfirst($billing->payment_method) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <?php if ($billing->payment_status === 'unpaid'): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-red-50 text-red-600 border border-red-200">Unpaid</span>
                        <?php elseif ($billing->payment_status === 'paid'): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-green-50 text-green-600 border border-green-200">Paid</span>
                        <?php endif ?>
                    </td>
                    <td class="px-5 py-4 border-b border-gray-100 text-green-600 font-semibold">₱<?= number_format($billing->amount_paid, 2) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-600"><?= $billing->issued_at ?></td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <div class="flex gap-2 items-center">
                            <a href="/admin/billings/show/<?= $billing->id ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-gray-500 bg-gray-50 border border-gray-200 hover:text-gray-700 hover:bg-gray-100 hover:-translate-y-0.5" title="View">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        const table = $('#billing-table').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [
                [0, 'desc']
            ],
        });
    });
</script>

<?php layout('admin/footer') ?>