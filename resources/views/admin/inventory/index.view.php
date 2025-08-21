<?php layout('admin/header') ?>

<!-- Header section -->
<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Inventory</h1>
        <p class="text-gray-600 text-base font-normal">Monitor and manage your stock levels</p>
    </div>
    <button class="bg-[#815331] hover:bg-[#5f3e27] text-white px-5 py-3 rounded-lg font-medium text-sm">
        <a href="/admin/inventory/create" class="text-white no-underline">Add Item</a>
    </button>
</div>

<!-- Search and Filter Section -->
<div class="flex gap-4 mb-6 items-center">
    <div class="relative flex-1">
        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 z-10" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
        <input type="text" id="inventory-search" placeholder="Search items or categories..." class="w-full pl-11 pr-3 py-3 border border-gray-300 rounded-lg text-sm bg-white transition-all duration-200 focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
    </div>
    <div class="flex gap-3">
        <select id="category-filter" class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[180px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
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
        <select id="stock-filter" class="px-4 py-3 border border-gray-300 rounded-lg bg-white text-sm text-gray-700 cursor-pointer transition-all duration-200 min-w-[140px] focus:outline-none focus:border-[#815331] focus:ring-3 focus:ring-[#5f3e27]">
            <option value="">All Stock</option>
            <option value="low">Low Stock</option>
            <option value="medium">Warning</option>
            <option value="high">In Stock</option>
        </select>
    </div>
</div>

<!-- Inventory table -->
<div class="custom-datatable bg-white rounded-xl overflow-hidden shadow-sm border border-gray-200">
    <table id="inventory-table" class="w-full border-collapse text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">ID</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Item name</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Category</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Unit price</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Quantity</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Restock Threshold</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Status</th>
                <th class="px-5 py-4 text-left font-semibold text-gray-700 text-xs uppercase tracking-wide border-b border-gray-200">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventory as $item): ?>
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-600 font-semibold font-mono">#<?= str_pad($item->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-900 font-medium"><?= htmlspecialchars($item->item_name) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-600"><?= htmlspecialchars($item->category) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-green-600 font-semibold">₱<?= number_format($item->unit_price, 2) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-900 font-medium"><?= htmlspecialchars($item->quantity) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100 text-gray-600"><?= htmlspecialchars($item->restock_threshold) ?></td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <?php if ($item->quantity < $item->restock_threshold): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-red-50 text-red-600 border border-red-200">Low Stock</span>
                        <?php elseif ($item->quantity <= $item->restock_threshold * 1.5): ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-orange-50 text-orange-600 border border-orange-200">Warning</span>
                        <?php else: ?>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium text-center min-w-[80px] bg-green-50 text-green-600 border border-green-200">In Stock</span>
                        <?php endif ?>
                    </td>
                    <td class="px-5 py-4 border-b border-gray-100">
                        <div class="flex gap-2 items-center">
                            <a href="/admin/inventory/show/<?= $item->id ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-gray-500 bg-gray-50 border border-gray-200 hover:text-gray-700 hover:bg-gray-100 hover:-translate-y-0.5" title="View">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </a>
                            <a href="/admin/inventory/edit/<?= $item->id ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-blue-600 bg-blue-50 border border-blue-200 hover:text-blue-800 hover:bg-blue-100 hover:-translate-y-0.5" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                            <a href="/admin/inventory/delete/<?= $item->id ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-md transition-all duration-200 text-red-600 bg-red-50 border border-red-200 hover:text-red-800 hover:bg-red-100 hover:-translate-y-0.5" title="Delete">
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

<script>
    $(document).ready(function() {
        const table = $('#inventory-table').DataTable({
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
                info: "Showing _START_ to _END_ of _TOTAL_ items",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            }
        });

        // Custom search functionality
        $('#inventory-search').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Category filter
        $('#category-filter').on('change', function() {
            table.column(2).search(this.value).draw();
        });

        // Stock level filter
        $('#stock-filter').on('change', function() {
            const value = this.value;
            if (value === '') {
                table.column(6).search('').draw();
            } else if (value === 'low') {
                table.column(6).search('Low Stock').draw();
            } else if (value === 'medium') {
                table.column(6).search('Warning').draw();
            } else if (value === 'high') {
                table.column(6).search('In Stock').draw();
            }
        });
    });
</script>

<?php layout('admin/footer') ?>