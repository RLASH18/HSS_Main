<?php layout('customer/header') ?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Your Profile</h1>
            <button
                class="bg-amber-700 hover:bg-amber-800 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                    </path>
                </svg>
                Edit Profile
            </button>
        </div>

        <!-- Profile Info Section -->
        <div class="bg-white rounded-lg shadow-sm p-8 mb-8">
            <div class="flex items-center space-x-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-20 h-20 rounded-full bg-gray-300 overflow-hidden">
                        <img src="/public/assets/img/default-avatar.jpg" alt="Profile Picture"
                            class="w-full h-full object-cover"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-full h-full bg-gray-300 flex items-center justify-center text-gray-600 text-2xl font-semibold"
                            style="display: none;">
                            <?= strtoupper(substr($users->name ?? 'U', 0, 1)) ?>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">
                        <?= htmlspecialchars(($users->name ?? ''))?>
                    </h2>
                    <p class="text-gray-500 mb-3">@<?= htmlspecialchars($users->username) ?></p>

                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span>Customer</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-400">ID:</span>
                            <span class="ml-1 font-medium">#<?= htmlspecialchars($users->id) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-6">
                    <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Contact Information</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Email:</span>
                        </div>
                        <p class="text-gray-900 ml-6"><?= htmlspecialchars($users->email) ?>
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Phone:</span>
                        </div>
                        <p class="text-gray-900 ml-6"><?= htmlspecialchars($users->contact_number) ?>
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Address:</span>
                        </div>
                        <div class="text-gray-900 ml-6">
                            <p><?= htmlspecialchars($users->address)?></p>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-6">
                    <svg class="w-5 h-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-9 0v10a2 2 0 002 2h8a2 2 0 002-2V7H7z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Birthdate:</span>
                        </div>
                        <p class="text-gray-900 ml-6"><?= date("F j, Y",strtotime($users->birthdate))?></p>
                    </div>

                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Gender:</span>
                        </div>
                        <p class="text-gray-900 ml-6"><?= htmlspecialchars($users->gender)?></p>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center mb-6">
                    <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Created:</span>
                        </div>
                        <p class="text-gray-900 ml-6"><?= date("F j, Y",strtotime($users->created_at))?>
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center mb-2">
                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Last Updated:</span>
                        </div>
                        <p class="text-gray-900 ml-6"><?= date("F j, Y",strtotime($users->updated_at)) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php layout('customer/footer') ?>