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
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
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
    // Initialize map with Quezon City as default (better for Philippine addresses)
    const map = L.map('map').setView([14.6760, 121.0437], 13); // Quezon City coordinates
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Geocode the customer address with multiple strategies
    const address = "<?= $deliveries->order->user->address ?>";
    
    if (address && address.trim() !== '') {        
        // Function to try geocoding with different search strategies
        async function geocodeAddress() {
            const searchQueries = [
                // Original address with Philippines context
                `${address}, Philippines`,
                // Address with Metro Manila context
                `${address}, Metro Manila, Philippines`,
                // Just the barangay and city if address contains them
                address.includes('Barangay') && address.includes('Quezon City') 
                    ? `${address.split('Barangay')[1]}, Philippines`
                    : null,
                // Just Quezon City if address contains it
                address.toLowerCase().includes('quezon city') 
                    ? 'Quezon City, Metro Manila, Philippines'
                    : null,
                // Fallback to just the city mentioned
                address.toLowerCase().includes('qc') || address.toLowerCase().includes('quezon')
                    ? 'Quezon City, Philippines'
                    : null
            ].filter(query => query !== null);

            for (let query of searchQueries) {
                try {                    
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=ph&limit=5`);
                    const data = await response.json();
                                        
                    if (data.length > 0) {
                        // Find the best match (prefer more specific results)
                        let bestMatch = data[0];
                        
                        // Prefer results that contain "Quezon City" in display name
                        const qcMatch = data.find(result => 
                            result.display_name.toLowerCase().includes('quezon city')
                        );
                        if (qcMatch) bestMatch = qcMatch;
                        
                        const lat = parseFloat(bestMatch.lat);
                        const lon = parseFloat(bestMatch.lon);
                                                
                        // Verify coordinates are in Philippines (rough bounds)
                        if (lat >= 4.5 && lat <= 21.5 && lon >= 116 && lon <= 127) {
                            map.setView([lat, lon], 15);
                            
                            // Add marker with popup
                            const marker = L.marker([lat, lon]).addTo(map)
                                .bindPopup(`
                                    <div style="min-width: 200px;">
                                        <b>Delivery Address</b><br>
                                        <strong>Original:</strong> ${address}<br>
                                        <strong>Found:</strong> ${bestMatch.display_name}<br>
                                    </div>
                                `)
                                .openPopup();
                            
                            return true; // Success
                        }
                    }
                } catch (error) {
                    console.error(`Error geocoding "${query}":`, error);
                }
            }
            
            return false; // No results found
        }

        // Try geocoding
        geocodeAddress().then(success => {
            if (!success) {                
                // Determine best fallback location based on address content
                let fallbackLat = 14.6760; // Quezon City
                let fallbackLon = 121.0437;
                let fallbackName = "Quezon City Center";
                
                if (address.toLowerCase().includes('payatas')) {
                    fallbackLat = 14.7167; // Payatas area
                    fallbackLon = 121.1167;
                    fallbackName = "Payatas Area, Quezon City";
                } else if (address.toLowerCase().includes('quezon') || address.toLowerCase().includes('qc')) {
                    // Keep Quezon City center
                } else {
                    // Default to Manila if no QC reference
                    fallbackLat = 14.5995;
                    fallbackLon = 120.9842;
                    fallbackName = "Manila Center";
                }
                
                map.setView([fallbackLat, fallbackLon], 13);
                
                L.marker([fallbackLat, fallbackLon]).addTo(map)
                    .bindPopup(`
                        <div style="min-width: 200px;">
                            <b>Address Not Found</b><br>
                            <strong>Address:</strong> ${address}<br>
                            <strong>Showing:</strong> ${fallbackName}<br>
                            <em>Please verify the exact location with the customer</em>
                        </div>
                    `)
                    .openPopup();
            }
        });
    } else {
        // Default to Quezon City when no address is available
        L.marker([14.6760, 121.0437]).addTo(map)
            .bindPopup(`<b>No Address</b><br><em>Customer address not available</em>`)
            .openPopup();
    }

    function openInMaps() {
        if (address && address.trim() !== '') {
            // Try Google Maps first (better for Philippine addresses), then OpenStreetMap
            const googleMapsUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address + ', Philippines')}`;
            const osmUrl = `https://www.openstreetmap.org/search?query=${encodeURIComponent(address + ', Philippines')}`;
            
            // Open Google Maps (more accurate for Philippines)
            window.open(googleMapsUrl);
        } else {
            alert('No address available to open in maps');
        }
    }

    function refreshMap() {
        map.invalidateSize();
        // Optionally re-run geocoding
        location.reload();
    }
</script>

<?php layout('admin/footer') ?>