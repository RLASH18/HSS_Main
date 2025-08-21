<?php layout('admin/header') ?>

<!-- Header Section -->
<div class="flex justify-between items-start mb-8">
    <div class="flex-1">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">Delivery Details</h1>
        <p class="text-gray-600 text-base font-normal">Complete information about delivery #<?= $deliveries->id ?></p>
    </div>
    <div class="flex space-x-3">
        <a href="/admin/delivery"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Deliveries
        </a>
    </div>
</div>

<div>
    <!-- 2-Column Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column: Info -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Customer Information</h3>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Delivery ID</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    #<?= str_pad($deliveries->id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Order ID</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    #<?= str_pad($deliveries->order_id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= $deliveries->order->user->name ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Customer Address</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= $deliveries->order->user->address ?: 'No address provided' ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Location Map</label>
                <div id="map" class="w-full h-64 rounded-lg border border-gray-300 bg-gray-100"></div>
                <div class="mt-2 flex space-x-2">
                    <button onclick="openInMaps()" type="button" class="inline-flex items-center px-3 py-1 border border-[#815331] rounded-lg text-sm font-medium text-[#815331] hover:bg-[#815331] hover:text-white transition-colors">
                        Open in Maps
                    </button>
                    <button onclick="refreshMap()" type="button" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Refresh Map
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2 mb-4">Delivery Information</h3>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Method</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= ucfirst($deliveries->delivery_method) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Scheduled Date</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= $deliveries->scheduled_date ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= $deliveries->remarks ?: 'None' ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Driver Name</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= $deliveries->driver_name ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-gray-900">
                    <?= ucfirst($deliveries->status) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <a href="/admin/delivery"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize map
    const map = L.map('map').setView([14.5995, 120.9842], 13); // Default to Manila coordinates
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Geocode the customer address
    const address = "<?= $deliveries->order->user->address ?>";
    console.log('Customer address:', address); // Debug log
    
    if (address && address.trim() !== '') {
        console.log('Geocoding address:', address); // Debug log
        
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
            .then(response => {
                console.log('Geocoding response status:', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Geocoding data:', data); // Debug log
                
                if (data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    console.log('Coordinates found:', lat, lon); // Debug log
                    
                    map.setView([lat, lon], 15);
                    
                    // Add marker with popup
                    const marker = L.marker([lat, lon]).addTo(map)
                        .bindPopup(`<b>Delivery Address</b><br>${address}`)
                        .openPopup();
                    
                    console.log('Marker added:', marker); // Debug log
                } else {
                    console.warn('No coordinates found for address:', address);
                    // Add a default marker at Manila center with address info
                    L.marker([14.5995, 120.9842]).addTo(map)
                        .bindPopup(`<b>Address Not Found</b><br>${address}<br><em>Showing default location</em>`)
                        .openPopup();
                }
            })
            .catch(error => {
                console.error('Geocoding error:', error);
                // Add a default marker with error info
                L.marker([14.5995, 120.9842]).addTo(map)
                    .bindPopup(`<b>Geocoding Error</b><br>${address}<br><em>Could not locate address</em>`)
                    .openPopup();
            });
    } else {
        console.warn('No address provided');
        // Add a default marker when no address is available
        L.marker([14.5995, 120.9842]).addTo(map)
            .bindPopup(`<b>No Address</b><br><em>Customer address not available</em>`)
            .openPopup();
    }

    function openInMaps() {
        if (address && address.trim() !== '') {
            window.open(`https://www.openstreetmap.org/search?query=${encodeURIComponent(address)}`);
        } else {
            alert('No address available to open in maps');
        }
    }

    function refreshMap() {
        map.invalidateSize();
    }
</script>

<?php layout('admin/footer') ?>