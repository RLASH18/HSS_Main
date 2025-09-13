<?php layout('admin/header') ?>

<!-- Header Section -->
<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold leading-tight text-gray-900">Delivery Details</h1>
        <p class="text-base font-normal text-gray-600">Complete information about delivery #<?= $deliveries->id ?></p>
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
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        <!-- Left Column: Info -->
        <div class="space-y-6">
            <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Customer Information</h3>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Delivery ID</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    #<?= str_pad($deliveries->id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Order ID</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    #<?= str_pad($deliveries->order_id, 4, '0', STR_PAD_LEFT) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Customer Name</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $deliveries->order->user->name ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Customer Address</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $deliveries->order->user->address ?: 'No address provided' ?>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <h3 class="pb-2 mb-4 text-lg font-semibold text-gray-900 border-b border-gray-200">Delivery Information</h3>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Delivery Method</label>
                <div class="flex items-center w-full gap-2 px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?php if ($deliveries->delivery_method === 'pickup') : ?>
                        <svg class="w-5 h-5 text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7.61713 8.71233L10.8222 6.38373C11.174 6.12735 11.6087 5.98543 12.065 6.0008C13.1764 6.02813 14.1524 6.75668 14.4919 7.82036C14.6782 8.40431 14.8481 8.79836 15.0017 9.0025C15.914 10.2155 17.3655 11 19.0002 11V13C16.8255 13 14.8825 12.0083 13.5986 10.4526L12.901 14.4085L14.9621 16.138L17.1853 22.246L15.3059 22.93L13.266 17.3256L9.87576 14.4808C9.32821 14.0382 9.03139 13.3192 9.16231 12.5767L9.67091 9.6923L8.99407 10.1841L6.86706 13.1116L5.24902 11.9361L7.60016 8.7L7.61713 8.71233ZM13.5002 5.5C12.3956 5.5 11.5002 4.60457 11.5002 3.5C11.5002 2.39543 12.3956 1.5 13.5002 1.5C14.6047 1.5 15.5002 2.39543 15.5002 3.5C15.5002 4.60457 14.6047 5.5 13.5002 5.5ZM10.5286 18.6813L7.31465 22.5116L5.78257 21.226L8.75774 17.6803L9.50426 15.5L11.2954 17L10.5286 18.6813Z" />
                        </svg>
                    <?php elseif ($deliveries->delivery_method === 'delivery') : ?>
                        <svg class="w-5 h-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8.96456 18C8.72194 19.6961 7.26324 21 5.5 21C3.73676 21 2.27806 19.6961 2.03544 18H1V6C1 5.44772 1.44772 5 2 5H16C16.5523 5 17 5.44772 17 6V8H20L23 12.0557V18H20.9646C20.7219 19.6961 19.2632 21 17.5 21C15.7368 21 14.2781 19.6961 14.0354 18H8.96456ZM15 7H3V15.0505C3.63526 14.4022 4.52066 14 5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H14.3368C14.5045 15.647 14.7296 15.3264 15 15.0505V7ZM17 13H21V12.715L18.9917 10H17V13ZM17.5 19C18.1531 19 18.7087 18.5826 18.9146 18C18.9699 17.8436 19 17.6753 19 17.5C19 16.6716 18.3284 16 17.5 16C16.6716 16 16 16.6716 16 17.5C16 17.6753 16.0301 17.8436 16.0854 18C16.2913 18.5826 16.8469 19 17.5 19ZM7 17.5C7 16.6716 6.32843 16 5.5 16C4.67157 16 4 16.6716 4 17.5C4 17.6753 4.03008 17.8436 4.08535 18C4.29127 18.5826 4.84689 19 5.5 19C6.15311 19 6.70873 18.5826 6.91465 18C6.96992 17.8436 7 17.6753 7 17.5Z" />
                        </svg>
                    <?php endif; ?>
                    <?= ucfirst($deliveries->delivery_method) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Scheduled Date</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= date('M d, Y', strtotime($deliveries->scheduled_date)) ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Remarks</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $deliveries->remarks ?: 'None' ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Driver Name</label>
                <div class="w-full px-4 py-3 text-gray-900 border border-gray-200 rounded-lg bg-gray-50">
                    <?= $deliveries->driver_name ?>
                </div>
            </div>

            <div class="form-group">
                <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                <?php
                if ($deliveries->status === 'scheduled') {
                    $statusClass = "text-blue-600";
                } elseif ($deliveries->status === 'in_transit') {
                    $statusClass = "text-orange-600";
                } elseif ($deliveries->status === 'delivered') {
                    $statusClass = "text-green-600";
                } elseif ($deliveries->status === 'failed') {
                    $statusClass = "text-red-600";
                } else {
                    $statusClass = "text-gray-600";
                }
                ?>
                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg font-bold <?= $statusClass ?>">
                    <?= ucfirst(str_replace('_', ' ', $deliveries->status)) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="block mb-2 text-sm font-medium text-gray-700">Location Map</label>
        <div id="map" class="w-full bg-gray-100 border border-gray-300 rounded-lg h-80"></div>
        <div class="flex mt-2 space-x-2">
            <button onclick="openInMaps()" type="button" class="inline-flex items-center px-3 py-1 border border-[#815331] rounded-lg text-sm font-medium text-[#815331] hover:bg-[#815331] hover:text-white transition-colors">
                Open in Maps
            </button>
            <button onclick="refreshMap()" type="button" class="inline-flex items-center px-3 py-1 text-sm font-medium text-gray-700 transition-colors border border-gray-300 rounded-lg hover:bg-gray-50">
                Refresh Map
            </button>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-6 mt-8 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div class="flex space-x-4">
                <a href="/admin/delivery"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Deliveries
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
                address.includes('Barangay') && address.includes('Quezon City') ?
                `${address.split('Barangay')[1]}, Philippines` :
                null,
                // Just Quezon City if address contains it
                address.toLowerCase().includes('quezon city') ?
                'Quezon City, Metro Manila, Philippines' :
                null,
                // Fallback to just the city mentioned
                address.toLowerCase().includes('qc') || address.toLowerCase().includes('quezon') ?
                'Quezon City, Philippines' :
                null
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