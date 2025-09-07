        </div>
    </div>

    <?= renderSweetAlert() ?>

    <footer class="w-full">
        <div class="container mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <p class="text-3xl md:text-4xl font-bold">ABG Prime</p>
                    <p class="text-xl md:text-2xl font-bold">Builders Supplies Inc.</p>
                    <p class="text-sm">
                        Your one-stop shop for tools, materials, and construction essentials. Prime
                        Builders is built to serve every Filipino builder - fast, reliable, and trusted by professionals
                        and DIYers alike.
                    </p>
                </div>

                <div class="ml-10 space-y-4">
                    <p class="mb-3 text-xl font-bold">Quick Links</p>
                    <div class="space-y-3">
                        <a href="/customer/home" class="flex items-center hover:text-[#815331] transition-colors group">
                            <svg class="w-5 h-5 mr-2 group-hover:text-[#815331] -mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                            </svg>
                            Home
                        </a>
                        <a href="/customer/profile" class="flex items-center hover:text-[#815331] transition-colors group">
                            <svg class="w-5 h-5 mr-2 group-hover:text-[#815331] -mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                            Account
                        </a>
                        <a href="/customer/my-cart" class="flex items-center hover:text-[#815331] transition-colors group">
                            <svg class="w-5 h-5 mr-2 group-hover:text-[#815331] -mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                            </svg>
                            Cart
                        </a>
                        <a href="/customer/my-orders" class="flex items-center hover:text-[#815331] transition-colors group">
                            <svg class="w-5 h-5 mr-2 group-hover:text-[#815331] -mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4.5 7.65311V16.3469L12 20.689L19.5 16.3469V7.65311L12 3.311L4.5 7.65311ZM12 1L21.5 6.5V17.5L12 23L2.5 17.5V6.5L12 1ZM6.49896 9.97065L11 12.5765V17.625H13V12.5765L17.501 9.97066L16.499 8.2398L12 10.8445L7.50104 8.2398L6.49896 9.97065Z" />
                            </svg>
                            Orders
                        </a>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xl mb-3 font-bold">Contact Us</p>
                    <p class="text-sm mb-3">AICS Bldg., Commonwealth Ave., Holy Spirit Drive, Brgy. Don Antonio Dr,
                        Quezon City </p>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                            </svg>
                            <p class="text-sm md:text-base">Phone: +63 923 456 7890</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                            </svg>
                            <p class="text-sm md:text-base">Email: buildwithzanjoe@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center bg-white p-2">
            <p>&copy; 2025 <span class="abg-footer">ABG Prime Builders Supplies Inc.</span> - Powered by ABG. Building
                Better, Together.</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoriesSection = document.getElementById('categories-section');

            // Only initialize search on customer index page
            if (window.itemList && searchInput) {
                // Connect search input to List.js
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.trim();

                    if (searchTerm === '') {
                        // Clear search and show all items
                        window.itemList.search();
                        // Show categories section
                        if (categoriesSection) {
                            categoriesSection.style.display = 'block';
                        }
                    } else {
                        // Search in item names
                        window.itemList.search(searchTerm);
                        // Hide categories section when searching
                        if (categoriesSection) {
                            categoriesSection.style.display = 'none';
                        }
                    }
                });

                // Clear search when input is cleared
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        this.value = '';
                        window.itemList.search();
                        // Show categories section when clearing searching
                        if (categoriesSection) {
                            categoriesSection.style.display = 'block';
                        }
                        this.blur();
                    }
                });
            }
        });
    </script>
</body>

</html>