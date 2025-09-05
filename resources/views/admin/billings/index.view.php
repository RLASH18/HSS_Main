<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Billings</h1>
        <p class="text-gray-600 text-base font-normal">Keep your billing records organized</p>
    </div>
</div>

<!-- Cards -->
<div class="admin-cards-container grid grid-cols-2 gap-5 my-4">
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Total Revenue</p>
            <p class="mt-1">₱ <?= number_format($revenue, 2) ?></p>
            <p class="text-sm text-gray-500 mt-6">From paid transactions</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg mt-1">
            <div class="icon-admin">
                <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 10h9.231M6 14h9.231M18 5.086A5.95 5.95 0 0 0 14.615 4c-3.738 0-6.769 3.582-6.769 8s3.031 8 6.769 8A5.94 5.94 0 0 0 18 18.916" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Pending amount</p>
            <p class="mt-1">₱ <?= number_format($pending, 2) ?></p>
            <p class="text-sm text-gray-500 mt-6">Awaiting payment</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg mt-1">
            <div class="icon-admin">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-8 h-8 text-white">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Total Transactions</p>
            <p class="mt-1"><?= $total ?></p>
            <p class="text-sm text-gray-500 mt-6">All billing records</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg mt-1">
            <div class="icon-admin">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-8 h-8 text-white">
                    <path d="M18.0049 6.99979H21.0049C21.5572 6.99979 22.0049 7.4475 22.0049 7.99979V19.9998C22.0049 20.5521 21.5572 20.9998 21.0049 20.9998H3.00488C2.4526 20.9998 2.00488 20.5521 2.00488 19.9998V3.99979C2.00488 3.4475 2.4526 2.99979 3.00488 2.99979H18.0049V6.99979ZM4.00488 8.99979V18.9998H20.0049V8.99979H4.00488ZM4.00488 4.99979V6.99979H16.0049V4.99979H4.00488ZM15.0049 12.9998H18.0049V14.9998H15.0049V12.9998Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Success Rate</p>
            <p class="mt-1"><?= number_format($rate, 2) ?>%</p>
            <p class="text-sm text-gray-500 mt-6">Payment completion</p>
        </div>
        <div class="flex items-center justify-center w-12 h-12 rounded-lg mt-1">
            <div class="icon-admin">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="w-8 h-8 text-white">
                    <path d="M16.0037 9.41421L7.39712 18.0208L5.98291 16.6066L14.5895 8H7.00373V6H18.0037V17H16.0037V9.41421Z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Billing table -->
<div class="custom-datatable bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200">
    <table id="billing-table" class="w-full border-collapse text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Bill ID</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Order ID</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Payment Method</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Status</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Amount</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Date Issued</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($billings as $billing): ?>
                <tr class="h-16 hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-900 font-semibold font-mono align-middle">#<?= str_pad($billing->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-600 font-semibold font-mono align-middle">#<?= str_pad($billing->orders->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 align-middle">
                        <?php if ($billing->payment_method === 'gcash'): ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-500 px-3 py-1.5 text-xs font-semibold text-white min-w-[100px] justify-center">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H9l-6 3V7Z" />
                                </svg>
                                GCash
                            </span>
                        <?php elseif ($billing->payment_method === 'cash'): ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-white min-w-[100px] justify-center">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M4 8.5h16v7H4z" />
                                    <circle cx="12" cy="12" r="2.25" stroke="currentColor" stroke-width="2" />
                                </svg>
                                Cash
                            </span>
                        <?php elseif ($billing->payment_method === 'bank_transfer' || $billing->payment_method === 'bank' || $billing->payment_method === 'bank transfer'): ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-500 px-3 py-1.5 text-xs font-semibold text-white min-w-[100px] justify-center">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 10V7l7-4 7 4v3M6 14v6m4-6v6m4-6v6m4-6v6" />
                                </svg>
                                Bank Transfer
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#815331] px-3 py-1.5 text-xs font-semibold text-white min-w-[100px] justify-center">
                                <?= ucfirst($billing->payment_method) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-100 align-middle">
                        <?php if ($billing->payment_status === 'unpaid'): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[90px] bg-red-500 text-white">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Unpaid
                            </span>
                        <?php elseif ($billing->payment_status === 'paid'): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[90px] bg-emerald-500 text-white">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Paid
                            </span>
                        <?php endif ?>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-100 text-[#815331] font-bold text-base align-middle">₱<?= number_format($billing->amount_paid, 2) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-600 font-medium align-middle"><?= date('F j, Y, g:i a', strtotime($billing->issued_at)) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 align-middle">
                        <div class="flex gap-2 items-center">
                            <a href="/admin/billings/show/<?= $billing->id ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg transition-all duration-200 text-gray-600 bg-gray-100 border border-gray-200 hover:text-white hover:bg-[#815331] hover:border-[#815331] hover:-translate-y-0.5" title="View">
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
    $(document).ready(function() {
        const table = $('#billing-table').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                searchable: false,
                targets: -1
            }],
            dom: '<"datatable-controls"<"datatable-length"l><"datatable-info"i>>rt<"datatable-footer"<"datatable-pagination"p>>',
            language: {
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ billings",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });
    });
</script>

<?php layout('admin/footer') ?>