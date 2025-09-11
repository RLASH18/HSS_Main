<?php layout('admin/header') ?>

<!-- Header section -->
<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold leading-tight text-gray-900">Settings</h1>
        <p class="text-base font-normal text-gray-600">Control your admin account and system settings</p>
    </div>
</div>

<div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
    <form method="POST" action="/admin/settings/update">
        <?= csrf_token() ?>
        <!-- 2-Column Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6 mt-2">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 border-b pb-3">Profile</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="<?= $admin->name ?? '' ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('name') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('name') ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Username</label>
                        <input type="text" name="username" value="<?= $admin->username ?? '' ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('username') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('username') ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="<?= $admin->email ?? '' ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('email') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('email') ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="tel" name="contact_number" value="<?= $admin->contact_number ?? '' ?>"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('contact_number') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('contact_number') ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors resize-none <?= isInvalid('address') ? 'border-red-300 bg-red-50' : '' ?>"><?= $admin->address ?? '' ?></textarea>
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('address') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6 mt-2">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 border-b pb-3">Change Password</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Current Password</label>
                        <input type="password" name="current_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('current_password') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('current_password') ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="new_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('new_password') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('new_password') ?></p>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="confirm_password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('confirm_password') ? 'border-red-300 bg-red-50' : '' ?>">
                        <div class="text-red-500 text-xs text-left mt-2">
                            <p><?= error('confirm_password') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-6 border-t">
            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#815331] hover:bg-[#6b4428] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors mt-3">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Update Profile
            </button>
        </div>
    </form>
</div>

<!-- System Info -->
<div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm lg:col-span-2 mt-4">
    <h3 class="mb-4 text-lg font-semibold text-gray-900">System Information</h3>
    <div class="space-y-3">
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Current Admin:</span>
            <span class="text-sm font-medium"><?= $admin->username ?? 'Unknown' ?></span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Role:</span>
            <span class="text-sm font-medium text-green-600"><?= ucfirst($admin->role ?? 'admin') ?></span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Email Status:</span>
            <span class="text-sm font-medium <?= $admin->email_verified_at ? 'text-green-600' : 'text-red-600' ?>">
                <?= $admin->email_verified_at ? 'Verified' : 'Not Verified' ?>
            </span>
        </div>
        <div class="flex justify-between">
            <span class="text-sm text-gray-600">Last Updated:</span>
            <span class="text-sm font-medium"><?= date('M d, Y', strtotime($admin->updated_at ?? 'now')) ?></span>
        </div>
    </div>
</div>

<?php layout('admin/footer') ?>