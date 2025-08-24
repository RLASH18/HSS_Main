<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/script.js"></script>
    <!-- DataTable and jQuery cdn -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.3.3/datatables.min.css" rel="stylesheet"
        integrity="sha384-C0ogMvg31Mu1GWzYxEEobPIlBlGbp/DY94Le4M9y/HFd9VGLT1zWL7MErNMsM2x6" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.3.3/datatables.min.js"
        integrity="sha384-qyN6ZT87DHLvgCDC+GYE3myTUDGpz3swpW19cYxOh4oa/8GNSGPMteQwbyM6Ot0D" crossorigin="anonymous">
    </script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.css" rel="stylesheet">
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@6.1.19/index.global.min.js'></script>
</head>

<body class="grid grid-cols-[250px_1fr]">
    <!-- sidebar and navbar will go here -->
    <section class="sidebar row-span-full min-h-screen p-4">
        <div class="sidebar-company-logo-container flex items-center justify-center mb-14 p-1">
            <img src="/assets/img/abg-logo.png" alt="ABG Prime Logo" class="h-12 w-auto mr-2">
            <div class="company-text">
                <img src="/assets/img/abg-company-name.svg" alt="ABG Company Name" class="h-5 w-auto mt-1">
                <img src="/assets/img/abg-company-subtitle.svg" alt="ABG Company Subtitle" class="h-4 w-auto mt-1">
            </div>
        </div>

        <div class="sidebar-links-container">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 px-2">Main</h2>
            <ul>
                <li class="group sidebar-item" data-route="/admin/dashboard">
                    <span class="sidebar-icon">
                        <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.143 4H4.857A.857.857 0 0 0 4 4.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 10 9.143V4.857A.857.857 0 0 0 9.143 4Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286A.857.857 0 0 0 20 9.143V4.857A.857.857 0 0 0 19.143 4Zm-10 10H4.857a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286A.857.857 0 0 0 9.143 14Zm10 0h-4.286a.857.857 0 0 0-.857.857v4.286c0 .473.384.857.857.857h4.286a.857.857 0 0 0 .857-.857v-4.286a.857.857 0 0 0-.857-.857Z" />
                        </svg>
                    </span>
                    <a href="/admin/dashboard">Dashboard</a>
                </li>
                <li class="group sidebar-item" data-route="/admin/inventory">
                    <span class="sidebar-icon">
                        <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 6h8m-8 4h12M6 14h8m-8 4h12" />
                        </svg>
                    </span>
                    <a href="/admin/inventory">Inventory</a>
                </li>
                <li class="group sidebar-item" data-route="/admin/orders">
                    <span class="sidebar-icon">
                        <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                        </svg>
                    </span>
                    <a href="/admin/orders">Customer Order</a>
                </li>
                <li class="group sidebar-item" data-route="/admin/billings">
                    <span class="sidebar-icon">
                        <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z" />
                        </svg>
                    </span>
                    <a href="/admin/billings">Billings</a>
                </li>
                <li class="group sidebar-item" data-route="/admin/delivery">
                    <span class="sidebar-icon">
                        <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                        </svg>
                    </span>
                    <a href="/admin/delivery">Deliveries</a>
                </li>
                <div class="mt-8">
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2 px-2">Account</h2>
                    <li class="group sidebar-item" data-route="/admin/settings">
                        <span class="sidebar-icon">
                            <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>
                        </span>
                        <a href="/admin/settings">Settings</a>
                    </li>
                    <li class="group sidebar-item" data-route="/admin/logout">
                        <form action="/admin/logout" method="post" class="flex items-center w-full">
                            <?= csrf_token() ?>
                            <button type="submit"
                                class="flex items-center w-full text-left text-[#815331] group-hover:text-white">
                                <span class="sidebar-icon">
                                    <svg class="w-7 h-7 text-gray-800 dark:text-white group-hover:text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h7.5A2.25 2.25 0 0120.75 5.25v13.5A2.25 2.25 0 0118 21h-7.5a2.25 2.25 0 01-2.25-2.25V15m6 0H3m0 0l3-3m-3 3 3 3" />
                                    </svg>
                                </span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </div>
            </ul>
        </div>
    </section>

    <div class="col-start-2 bg-[#F8F9FA]">
        <!-- Top Navbar -->
        <nav class="flex items-center justify-between px-5 py-3">
            <div class="text-sm text-[#815331]">
                <span>Pages</span>
                <?php foreach (breadcrumbs() as $crumb): ?>
                    <span class="mx-1">/</span>
                    <span class="font-medium text-gray-900"><?= htmlspecialchars($crumb) ?></span>
                <?php endforeach ?>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path
                            d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zm0 2c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z" />
                    </svg>
                </div>
                <span class="text-sm font-medium text-[#815331]">Admin</span>
            </div>
        </nav>

        <main class="main-content p-6 col-start-2">