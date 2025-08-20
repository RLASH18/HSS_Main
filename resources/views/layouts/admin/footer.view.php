
        </main>
    </div>    
    <!-- shows SweetAlert -->
    <?php renderSweetAlert() ?>

    <script>
        // Sidebar active link functionality
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const sidebarItems = document.querySelectorAll('.sidebar-item');

            sidebarItems.forEach(item => {
                const route = item.getAttribute('data-route');
                if (route && currentPath.startsWith(route)) {
                    item.classList.add('active');

                    // Remove conflicting Tailwind classes and ensure white color
                    const svg = item.querySelector('.sidebar-icon svg');
                    const link = item.querySelector('a');

                    if (svg) {
                        svg.classList.remove('text-gray-800', 'dark:text-white');
                        svg.classList.add('text-white');
                    }

                    if (link) {
                        link.classList.add('text-white');
                    }
                }
            });
        });
    </script>
</body>

</html>