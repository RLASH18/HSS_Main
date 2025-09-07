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
<div class="admin-cards-container grid grid-cols-3 gap-5 my-4">
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Pending Deliveries</p>
            <p><?= $pendingDeliveries ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Deliveries Completed</p>
            <p><?= $deliveriesCompleted ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p>Failed Deliveries</p>
            <p><?= $failedDeliveries ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM11 7H13V13H11V7Z" />
                </svg>
            </div>
        </div>
    </div>
</div>
<!-- End of Delivery Cards -->

<div>
    <div id="calendar" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6"></div>
</div>

<!-- Inventory table/ Template table -->
<div class="custom-datatable bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200 my-4">
    <table id="delivery-table" class="w-full border-collapse table-fixed text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">ID</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Item name</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Customer</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Unit price</th>
                <th class="px-6 py-4 text-center font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Status</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Driver</th>
                <th class="px-6 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Scheduled Date</th>
                <th class="px-6 py-4 text-center font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deliveries as $delivery): ?>
                <tr class="h-16 hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-900 font-semibold font-mono align-middle">#<?= str_pad($delivery->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-900 font-semibold align-middle"><?= $delivery->order->orderItems[0]->items->item_name ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-600 font-medium align-middle"><?= $delivery->order->user->name ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 text-[#815331] font-bold text-base align-middle">₱<?= number_format($delivery->order->total_amount, 2) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 align-middle">
                        <?php if ($delivery->status === "scheduled"): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[100px] bg-yellow-100 text-yellow-800">
                                Scheduled
                            </span>
                        <?php elseif ($delivery->status === "rescheduled"): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[100px] bg-orange-100 text-orange-800">
                                Rescheduled
                            </span>
                        <?php elseif ($delivery->status === "in_transit"): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[100px] bg-blue-100 text-blue-800">In
                                Transit
                            </span>
                        <?php elseif ($delivery->status === "delivered"): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[100px] bg-emerald-500 text-white">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Delivered
                            </span>
                        <?php elseif ($delivery->status === "failed"): ?>
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-xs font-semibold min-w-[100px] bg-red-500 text-white">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Failed
                            </span>
                        <?php endif ?>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-600 font-medium align-middle"><?= $delivery->driver_name ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 text-gray-600 font-medium align-middle"><?= date('F j, Y', strtotime($delivery->scheduled_date)) ?></td>
                    <td class="px-6 py-4 border-b border-gray-100 align-middle">
                        <div class="flex gap-2 items-center">
                            <a href="/admin/delivery/show/<?= $delivery->id ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg transition-all duration-200 text-gray-600 bg-gray-100 border border-gray-200 hover:text-white hover:bg-[#815331] hover:border-[#815331] hover:-translate-y-0.5" title="View">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="/admin/delivery/edit/<?= $delivery->id ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg transition-all duration-200 text-white bg-blue-500 border border-blue-500 hover:bg-blue-600 hover:border-blue-600 hover:-translate-y-0.5" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <a href="/admin/delivery/delete/<?= $delivery->id ?>" class="inline-flex items-center justify-center w-9 h-9 rounded-lg transition-all duration-200 text-white bg-red-500 border border-red-500 hover:bg-red-600 hover:border-red-600 hover:-translate-y-0.5" title="Delete">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3,6 5,6 21,6"></polyline>
                                    <path d="M19,6V20a2,2,0,0,1-2,2H7a2,2,0,0,1-2-2V6M8,6V4a2,2,0,0,1,2-2h4a2,2,0,0,1,2,2V6"></path>
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
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 'auto',
            events: '/admin/delivery/calendar-data',
            eventDisplay: 'block',
            dayMaxEvents: 3,
            moreLinkClick: 'popover',
            eventClick: function(info) {
                const event = info.event;
                const props = event.extendedProps;

                // Create simplified popup content
                const content = `
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">Delivery #000${event.id}</h3>
                            <span class="px-3 py-1 text-sm font-medium rounded-full" style="background-color: ${event.backgroundColor}20; color: ${event.backgroundColor};">
                                ${props.status}
                            </span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500">Customer:</span>
                                    <p class="font-medium text-gray-900">${props.customer}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Driver:</span>
                                    <p class="font-medium text-gray-900">${props.driver}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="text-sm text-gray-500">Method:</span>
                                    <p class="font-medium text-gray-900">${props.method}</p>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500">Total:</span>
                                    <p class="font-medium text-[#815331]">₱${props.total}</p>
                                </div>
                            </div>
                            
                            ${props.remarks ? `
                                <div class="pt-3 border-t border-gray-200">
                                    <span class="text-sm text-gray-500">Remarks:</span>
                                    <p class="text-gray-800 mt-1">${props.remarks}</p>
                                </div>
                            ` : ''}
                            
                            <div class="pt-3 border-t border-gray-200">
                                <span class="text-sm text-gray-500">Items:</span>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    ${props.items.map(item => `<span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">${item}</span>`).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Create and show modal
                showEventModal(content);
            },
            eventMouseEnter: function(info) {
                // Add hover effect
                info.el.style.transform = 'scale(1.02)';
                info.el.style.zIndex = '10';
                info.el.style.transition = 'all 0.2s ease';
            },
            eventMouseLeave: function(info) {
                // Remove hover effect
                info.el.style.transform = 'scale(1)';
                info.el.style.zIndex = '1';
            },
            // Custom styling
            eventDidMount: function(info) {
                // Add custom classes and styling
                info.el.classList.add('delivery-event');
                info.el.style.borderRadius = '6px';
                info.el.style.border = 'none';
                info.el.style.fontSize = '12px';
                info.el.style.fontWeight = '500';
                info.el.style.cursor = 'pointer';
                info.el.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
            }
        });

        calendar.render();

        // Function to show event modal
        function showEventModal(content) {
            // Remove existing modal if any
            const existingModal = document.getElementById('event-modal');
            if (existingModal) {
                existingModal.remove();
            }

            // Create modal
            const modal = document.createElement('div');
            modal.id = 'event-modal';
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 relative">
                    ${content}
                </div>
            `;

            document.body.appendChild(modal);

            // Close on background click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeEventModal();
                }
            });
        }

        // Function to close event modal
        window.closeEventModal = function() {
            const modal = document.getElementById('event-modal');
            if (modal) {
                modal.remove();
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEventModal();
            }
        });
    });
</script>

<?php layout('admin/footer') ?>