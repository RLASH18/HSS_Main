<?php layout('customer/header') ?>

<!-- Header Section -->
<div class="mb-4 sm:mb-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-black-900 mb-2">My Profile</h1>
            <p class="text-sm sm:text-base text-black-600">Manage your details or continue shopping</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <a href="/customer/home" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6d4529] transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Continue Shopping
            </a>
            <div class="relative w-full sm:w-auto">
                <button id="accountBtn" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors text-sm sm:text-base">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Account
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div id="accountDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                    <a href="/customer/edit-profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                    <a href="/customer/contact" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact Support
                    </a>
                    <form action="/customer/logout" method="post">
                        <?= csrf_token() ?>
                        <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 18H6V20H18V4H6V6H4V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V18ZM6 11H13V13H6V16L1 12L6 8V11Z" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Info Section -->
<div class="bg-white border border-gray-100 rounded-lg shadow-sm p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6">
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
        <!-- Avatar -->
        <div class="flex-shrink-0">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gray-300 overflow-hidden flex items-center justify-center text-gray-600 text-xl sm:text-2xl font-semibold">
                <?php if (!empty($users->profile_picture)): ?>
                    <img src="/storage/profile-img/<?= $users->profile_picture ?>"
                        alt="Profile Picture"
                        class="w-full h-full object-cover">
                <?php else: ?>
                    <?= strtoupper(substr($users->name ?? 'U', 0, 1)) ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- User Info -->
        <div class="flex-1 text-center sm:text-left">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-1">
                <?= $users->name ?? '' ?>
            </h2>
            <p class="text-sm sm:text-base text-gray-500 mb-3">@<?= $users->username ?></p>

            <div class="flex items-center justify-center sm:justify-start flex-wrap gap-3 sm:gap-4 text-xs sm:text-sm text-gray-600">
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span>Customer</span>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-400">ID:</span>
                    <span class="ml-1 font-medium">#<?= str_pad($users->id, 4, '0', STR_PAD_LEFT) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Information Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
    <!-- Contact Information -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-4 sm:p-6 lg:p-8">
        <div class="flex items-center mb-4 sm:mb-6">
            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Contact Information</h3>
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
                <p class="text-gray-900 ml-6"><?= $users->email ?></p>
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
                <p class="text-gray-900 ml-6">
                    <?php if (!empty($users->contact_number)): ?>
                        <?= $users->contact_number ?>
                    <?php else: ?>
                        <span class="text-gray-400 italic">Not set</span>
                    <?php endif; ?>
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
                    <?php if (!empty($users->address)): ?>
                        <p><?= $users->address ?></p>
                    <?php else: ?>
                        <p><span class="text-gray-400 italic">Not set</span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Information -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-4 sm:p-6 lg:p-8">
        <div class="flex items-center mb-4 sm:mb-6">
            <svg class="w-5 h-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Personal Information</h3>
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
                <p class="text-gray-900 ml-6">
                    <?php if (!empty($users->birthdate)): ?>
                        <?= date("F j, Y", strtotime($users->birthdate)) ?>
                    <?php else: ?>
                        <span class="text-gray-400 italic">Not set</span>
                    <?php endif; ?>
                </p>
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
                <p class="text-gray-900 ml-6">
                    <?php if (!empty($users->gender)): ?>
                        <?= ucfirst($users->gender) ?>
                    <?php else: ?>
                        <span class="text-gray-400 italic">Not set</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-4 sm:p-6 lg:p-8">
        <div class="flex items-center mb-4 sm:mb-6">
            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Account Information</h3>
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
                <p class="text-gray-900 ml-6"><?= date("F j, Y", strtotime($users->created_at)) ?></p>
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
                <p class="text-gray-900 ml-6"><?= date("F j, Y", strtotime($users->updated_at)) ?></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('accountBtn');
        const dropdown = document.getElementById('accountDropdown');

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', function() {
            dropdown.classList.add('hidden');
        });
    });
</script>

<?php layout('customer/footer') ?>