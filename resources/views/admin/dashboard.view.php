<?php layout('admin/header') ?>

<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Dashboard</h1>
        <p class="text-gray-600 text-base font-normal">Welcome back @<strong class="text-[#815331]"><?= auth()->username ?></strong>!</p>
    </div>
</div>
<div class="admin-cards-container grid grid-cols-4 gap-5 my-4">
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p class="font-semibold text-gray-900">Total Orders</p>
            <p><?= $orders ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6h8m-8 6h8m-8 6h8M4 16a2 2 0 1 1 3.321 1.5L4 20h5M4 5l2-1v6m-2 0h4" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p class="font-semibold text-gray-900">Customers</p>
            <p><?= $customers ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
        </div>
    </div>
    <div class="flex p-3 bg-white border border-gray-200 rounded-lg shadow-sm justify-between">
        <div class="p-2">
            <p class="font-semibold text-gray-900">Revenue</p>
            <p>₱ <?= number_format($revenue, 2) ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
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
            <p class="font-semibold text-gray-900">Inventory</p>
            <p><?= $inventory ?></p>
        </div>
        <div class="p-2 flex items-center justify-center">
            <div class="icon-admin">
                <svg class="w-8 h-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                        d="M4.07141 14v6h5.99999v-6H4.07141Zm4.5-4h6.99999l-3.5-6-3.49999 6Zm7.99999 10c1.933 0 3.5-1.567 3.5-3.5s-1.567-3.5-3.5-3.5-3.5 1.567-3.5 3.5 1.567 3.5 3.5 3.5Z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="admin-chart-container grid grid-cols-2 gap-4">
    <!-- Sales Overview Chart -->
    <div class="chart-1-container bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Sales Overview</h3>
        </div>
        <div class="relative h-80">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    <!-- Stock Overview Chart -->
    <div class="chart-2-container bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Stock Overview</h3>
        </div>
        <div class="relative h-80">
            <canvas id="stockChart"></canvas>
        </div>
    </div>
</div>

<!-- Item Movement Alert Chart -->
<div class="chart-3-container bg-white border border-gray-200 rounded-lg shadow-sm p-6 mt-5">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-1">Item Movement Alert</h3>
        <p class="text-sm text-gray-600">Fast vs Slow Moving Items</p>
    </div>
    <div class="relative h-80">
        <canvas id="movementChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-3 gap-5 my-4">
    <div class="recent-orders-container bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <h1 class="font-semibold text-gray-900 mb-4">Recent Orders</h1>
        <?php foreach ($recentOrders as $order):  ?>
            <div class="flex align-center justify-between my-3">
                <div>
                    <p class="id">#<?= $order->id ?></p>
                    <p class="name"><?= $order->user->name ?></p>
                    <p class="cost">₱<?= $order->total_amount ?></p>
                </div>
                <div class="flex flex-col justify-center">
                    <p class="date-time mb-1"><?= date("M, d Y", strtotime($order->created_at)) ?></p>
                    <?php if ($order->status === 'pending'): ?>
                        <p class="flex justify-center rounded-2xl bg-orange-500 text-white text-[10px] px-3 py-1">
                            Pending
                        </p>
                    <?php elseif ($order->status === 'confirmed'): ?>
                        <p class="flex justify-center rounded-2xl bg-blue-600 text-white text-[10px] px-3 py-1">
                            Confirmed
                        </p>
                    <?php elseif ($order->status === 'assembled'): ?>
                        <p class="flex justify-center rounded-2xl bg-indigo-600 text-white text-[10px] px-3 py-1">
                            Assembled
                        </p>
                    <?php elseif ($order->status === 'shipped'): ?>
                        <p class="flex justify-center rounded-2xl bg-sky-600 text-white text-[10px] px-3 py-1">
                            Shipped
                        </p>
                    <?php elseif ($order->status === 'paid'): ?>
                        <p class="flex justify-center rounded-2xl bg-green-600 text-white text-[10px] px-3 py-1">
                            Paid
                        </p>
                    <?php elseif ($order->status === 'cancelled'): ?>
                        <p class="flex justify-center rounded-2xl bg-red-600 text-white text-[10px] px-3 py-1">
                            Cancelled
                        </p>
                    <?php elseif ($order->status === 'delivered'): ?>
                        <p class="flex justify-center rounded-2xl bg-emerald-600 text-white text-[10px] px-3 py-1">
                            Delivered
                        </p>
                    <?php endif ?>
                </div>
            </div>
            <hr class=" horizontal-line">
        <?php endforeach ?>
    </div>
    <div class="new-customers-container bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <h1 class="font-semibold text-gray-900 mb-4">New Customers</h1>
        <?php foreach ($newCustomers as $newCustomer): ?>
            <div class="flex align-center justify-between my-3">
                <div>
                    <p class="name"><?= $newCustomer->username ?></p>
                    <p class="email"><?= $newCustomer->email ?></p>
                </div>
                <div class="flex flex-col justify-end">
                    <p class="date-time">
                        <?= date("M, d g:i:a", strtotime($newCustomer->created_at)) ?>
                    </p>
                </div>
            </div>
            <hr class="horizontal-line">
        <?php endforeach ?>
    </div>
    <div class="added-products-container bg-white border border-gray-200 rounded-lg shadow-sm p-4">
        <h1 class="font-semibold text-gray-900 mb-4">Added Products</h1>
        <?php foreach ($addedProducts as $item): ?>
            <div class="flex items-start justify-between my-3">
                <!-- Left: item name + category -->
                <div class="min-w-0 flex-1 pr-3">
                    <p class="product-name text-sm font-medium text-gray-900 truncate" title="<?= $item->item_name ?>">
                        <?= $item->item_name ?>
                    </p>
                    <p class="item-category text-xs text-gray-600 truncate">
                        <?= $item->category ?>
                    </p>
                </div>

                <!-- Right: quantity + date -->
                <div class="text-right shrink-0">
                    <p class="quantity text-sm"><?= $item->quantity ?> pcs</p>
                    <p class="date-time text-xs text-gray-500">
                        <?= date("M, d g:i:a", strtotime($item->created_at)) ?>
                    </p>
                </div>
            </div>
            <hr class="horizontal-line border-gray-200">
        <?php endforeach ?>
    </div>
</div>

<script>
    // Sales Chart Data from PHP
    const salesData = <?= json_encode($salesData) ?>;
    const stockData = <?= json_encode($stockData) ?>;
    const movementData = <?= json_encode($movementData) ?>;

    // Sales Overview Chart (Area Chart)
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesData.labels,
            datasets: [{
                label: 'Revenue',
                data: salesData.revenue,
                borderColor: '#815331',
                backgroundColor: 'rgba(129, 83, 49, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#815331',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverBackgroundColor: '#815331',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: ₱' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        }
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    display: true,
                    position: 'left',
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        },
                        callback: function(value) {
                            return '₱' + (value / 1000) + 'k';
                        }
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.2)',
                        lineWidth: 1
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });

    // Stock Overview Chart (Bar Chart)
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    const stockChart = new Chart(stockCtx, {
        type: 'bar',
        data: {
            labels: stockData.labels,
            datasets: [{
                label: 'Stock Quantity',
                data: stockData.data,
                backgroundColor: function(context) {
                    const colors = ['rgba(129, 83, 49, 0.3)', '#815331', 'rgba(129, 83, 49, 0.5)', '#A67C52', 'rgba(129, 83, 49, 0.7)', '#8B5A3C'];
                    return colors[context.dataIndex] || 'rgba(129, 83, 49, 0.4)';
                },
                borderColor: 'transparent',
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                categoryPercentage: 0.8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'x',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y + ' items';
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        },
                        maxRotation: 0,
                        minRotation: 0
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    display: true,
                    beginAtZero: true,
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        }
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.2)',
                        lineWidth: 1
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });

    // Item Movement Alert Chart (Horizontal Bar Chart)
    const movementCtx = document.getElementById('movementChart').getContext('2d');

    // Combine fast and slow moving data for display
    const combinedLabels = [...movementData.fastMoving.labels, ...movementData.slowMoving.labels];
    const combinedData = [...movementData.fastMoving.data, ...movementData.slowMoving.data];
    const fastCount = movementData.fastMoving.count;
    const slowCount = movementData.slowMoving.count;

    // Create color array - brand colors for consistency
    const backgroundColors = [
        ...Array(fastCount).fill('#815331'), // Brand color for fast moving
        ...Array(slowCount).fill('rgba(129, 83, 49, 0.4)') // Lighter brand color for slow moving
    ];

    const movementChart = new Chart(movementCtx, {
        type: 'bar',
        data: {
            labels: combinedLabels,
            datasets: [{
                label: 'Items',
                data: combinedData,
                backgroundColor: backgroundColors,
                borderColor: 'transparent',
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y', // Horizontal bars
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#374151',
                        font: {
                            size: 11
                        },
                        generateLabels: function(chart) {
                            const visibility = (start, end) => {
                                for (let i = start; i < end; i++) {
                                    if (!chart.getDataVisibility(i)) {
                                        return true; // hidden if any item is hidden
                                    }
                                }
                                return false;
                            };

                            return [{
                                    text: `Fast Moving (${fastCount})`,
                                    fillStyle: '#815331',
                                    strokeStyle: '#815331',
                                    lineWidth: 1, // needed for strike-through
                                    hidden: visibility(0, fastCount), // check visibility of fast group
                                    index: 0
                                },
                                {
                                    text: `Slow Moving (${slowCount})`,
                                    fillStyle: 'rgba(129, 83, 49, 0.4)',
                                    strokeStyle: 'rgba(129, 83, 49, 0.4)',
                                    lineWidth: 2,
                                    hidden: visibility(fastCount, combinedLabels.length),
                                    index: 1
                                }
                            ];
                        }
                    },
                    onClick: function(e, legendItem, legend) {
                        const chart = legend.chart;
                        const index = legendItem.index;

                        if (index === 0) {
                            // Toggle fast moving items (first fastCount items)
                            for (let i = 0; i < fastCount; i++) {
                                chart.toggleDataVisibility(i);
                            }
                        } else if (index === 1) {
                            // Toggle slow moving items (remaining items)
                            for (let i = fastCount; i < combinedLabels.length; i++) {
                                chart.toggleDataVisibility(i);
                            }
                        }

                        chart.update();
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    callbacks: {
                        label: function(context) {
                            const isSlowMoving = context.dataIndex >= fastCount;
                            const type = isSlowMoving ? 'Slow Moving' : 'Fast Moving';
                            const value = isSlowMoving ? 'Stock: ' : 'Sold: ';
                            return type + ' - ' + value + context.parsed.x;
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    beginAtZero: true,
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        }
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.2)',
                        lineWidth: 1
                    },
                    border: {
                        display: false
                    }
                },
                y: {
                    display: true,
                    ticks: {
                        color: '#9CA3AF',
                        font: {
                            size: 10
                        }
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    }
                }
            }
        }
    });
</script>

<?php layout('admin/footer') ?>