<?php layout('admin/header') ?>

<!-- Header section -->
<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold leading-tight text-gray-900">Settings</h1>
        <p class="text-base font-normal text-gray-600">Control your admin account and system settings</p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <!-- Admin Profile Settings -->
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Admin Profile</h3>
        <form method="POST" action="/admin/settings/profile">
            <div class="space-y-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="<?= auth()->name ?? '' ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" value="<?= auth()->username ?? '' ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="<?= auth()->email ?? '' ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="tel" name="contact_number" value="<?= auth()->contact_number ?? '' ?>"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Address</label>
                    <textarea name="address" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20"><?= auth()->address ?? '' ?></textarea>
                </div>
                <button type="submit" class="w-full bg-[#815331] hover:bg-[#5f3e27] text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
                    Update Profile
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Change Password</h3>
        <form method="POST" action="/admin/settings/password">
            <div class="space-y-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" name="new_password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" name="confirm_password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#815331] focus:ring-2 focus:ring-[#815331]/20">
                </div>
                <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                    Change Password
                </button>
            </div>
        </form>
    </div>

    <!-- System Info -->
    <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm lg:col-span-2">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">System Information</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Current Admin:</span>
                <span class="text-sm font-medium"><?= auth()->username ?? 'Unknown' ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Role:</span>
                <span class="text-sm font-medium text-green-600"><?= ucfirst(auth()->role ?? 'admin') ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Email Status:</span>
                <span class="text-sm font-medium <?= auth()->email_verified_at ? 'text-green-600' : 'text-red-600' ?>">
                    <?= auth()->email_verified_at ? 'Verified' : 'Not Verified' ?>
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Last Updated:</span>
                <span class="text-sm font-medium"><?= date('M d, Y', strtotime(auth()->updated_at ?? 'now')) ?></span>
            </div>
        </div>
    </div>
</div>

<?php layout('admin/footer') ?>