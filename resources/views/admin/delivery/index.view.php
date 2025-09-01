<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Deliveries</h1>
        <p class="text-gray-600 text-base font-normal">Schedule delivery and prepares items for pickup</p>
    </div>
    <button class="bg-[#815331] hover:bg-[#5f3e27] text-white px-5 py-3 rounded-lg font-medium text-sm">
        <a href="/admin/delivery/create" class="text-white no-underline">Add Delivery</a>
    </button>
</div>

<!-- Delivery Cards -->
<div class="admin-cards-container grid grid-cols-4 gap-5 my-4">
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Pending Deliveries</p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Available Drivers</p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Deliveries Completed</p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 10h9.231M6 14h9.231M18 5.086A5.95 5.95 0 0 0 14.615 4c-3.738 0-6.769 3.582-6.769 8s3.031 8 6.769 8A5.94 5.94 0 0 0 18 18.916" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Failed Deliveries</p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z">
                    </path>
                </svg>
            </div>
        </div>
    </div>
</div>
<!-- End of Delivery Cards -->

<div>
    <div id='calendar'></div>
</div>

<!-- Inventory table/ Template table -->
<div class="custom-datatable bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200 my-4">
    <table id="delivery-table" class="w-full border-collapse text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">ID</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Item name</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Customer</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Unit price</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Status</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Driver</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Date</th>
                <th class="px-5 py-4 text-right font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveries as $delivery): ?>
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-600 font-semibold font-mono">#<?= str_pad($delivery->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-900 font-medium"><?= htmlspecialchars($delivery->order->orderItems[0]->items->item_name) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-600"><?= htmlspecialchars($delivery->order->user->name) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-green-600 font-semibold">₱<?= number_format($delivery->order->total_amount, 2) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <?php if ($delivery->status === "scheduled"): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-yellow-50 text-yellow-600 border border-yellow-200">
                                Scheduled
                            </span>
                        <?php elseif ($delivery->status === "rescheduled"): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-orange-50 text-orange-600 border border-orange-200">
                                Rescheduled
                            </span>
                        <?php elseif ($delivery->status === "in_transit"): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-blue-50 text-blue-600 border border-blue-200">In
                                Transit
                            </span>
                        <?php elseif ($delivery->status === "delivered"): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-green-50 text-green-600 border border-green-200">
                                Delivered
                            </span>
                        <?php elseif ($delivery->status === "failed"): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-red-100 text-red-600 border border-red-300">
                                Failed
                            </span>
                        <?php endif ?>
                    </td>
                    <td class="px-5 py-4 border-b border-gray-100"><?= $delivery->driver_name ?></td>
                    <td class="px-5 py-4 border-b border-gray-100"><?= $delivery->scheduled_date ?></td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <div class="flex gap-2 items-center">
                            <a href="/admin/delivery/show/<?= $delivery->id ?>"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-gray-500 bg-gray-50 border border-gray-200 hover:text-gray-700 hover:bg-gray-100 hover:-translate-y-0.5"
                                title="View">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="/admin/delivery/edit/<?= $delivery->id ?>"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-blue-600 bg-blue-50 border border-blue-200 hover:text-blue-800 hover:bg-blue-100 hover:-translate-y-0.5"
                                title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <a href="/admin/delivery/delete/<?= $delivery->id ?>"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-red-600 bg-red-50 border border-red-200 hover:text-red-800 hover:bg-red-100 hover:-translate-y-0.5"
                                title="Delete">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <polyline points="3,6 5,6 21,6"></polyline>
                                    <path
                                        d="M19,6V20a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6M8,6V4a2,2,0,0,1,2-2h4a2,2,0,0,1,2,2V6">
                                    </path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<!-- End of template table -->

<script>
    $(document).ready(function() {
        const table = $('#delivery-table').DataTable({
            scrollX: true,
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
                info: "Showing _START_ to _END_ of _TOTAL_ deliveries",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'resourceTimelineWeek'
        });
        calendar.render();
    });
</script>

<?php layout('admin/footer') ?>