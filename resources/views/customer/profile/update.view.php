<?php layout('customer/header') ?>

<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit your profile</h1>
            <p class="text-gray-600">Review your order and complete your purchase</p>
        </div>
        <a href="/customer/profile" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to profile
        </a>
    </div>
</div>

<!-- Profile update form -->
<div class="w-full bg-white border border-gray-100 rounded-lg shadow-sm">
    <form action="/customer/update-profile" method="post" enctype="multipart/form-data" class="p-8">
        <?= csrf_token() ?>

        <!-- Profile picture section -->
        <div class="mb-8 text-center">
            <div class="relative inline-block">
                <div class="w-24 h-24 rounded-full bg-gray-200 overflow-hidden mx-auto mb-4 relative">
                    <?php if ($users->profile_picture): ?>
                        <img src="/storage/profile-img/<?= $users->profile_picture ?>" alt="Profile Picture" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-300 text-gray-600 text-2xl font-bold">
                            <?= strtoupper(substr($users->name ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif ?>
                    <!-- Camera button inside the circle -->
                    <label for="profile_picture" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-full opacity-0 hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </label>
                </div>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden">
            </div>
            <p class="text-sm text-gray-500">Click the camera to update your profile picture</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Personal information -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Personal Information</h3>
                </div>

                <!-- Full name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="<?= $users->name ?? old('name') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('name') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your full name">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('name') ?></p>
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="username" name="username" value="<?= $users->username ?? old('username') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('username') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your username">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('username') ?></p>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="email" name="email" value="<?= $users->email ?? old('email') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('email') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your email">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('email') ?></p>
                    </div>
                </div>

                <!-- Birthdate -->
                <div>
                    <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-2">
                        Date of Birth
                    </label>
                    <input type="date" id="birthdate" name="birthdate" value="<?= $users->birthdate ?? old('birthdate') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('birthdate') ? 'border-red-300 bg-red-50' : '' ?>">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('birthdate') ?></p>
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <!-- Hidden input to ensure gender field is always present -->
                    <input type="hidden" name="gender" value="">
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="male" <?= (($users->gender ?? old('gender')) === 'male') ? 'checked' : '' ?>
                                class="w-4 h-4 text-[#815331] focus:ring-[#815331] border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Male</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="gender" value="female" <?= (($users->gender ?? old('gender')) === 'female') ? 'checked' : '' ?>
                                class="w-4 h-4 text-[#815331] focus:ring-[#815331] border-gray-300">
                            <span class="ml-2 text-sm text-gray-700">Female</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Contact and security -->
            <div class="space-y-6">
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-1">Contact & Security</h3>
                </div>

                <!-- Contact number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">
                        Contact Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="contact_number" name="contact_number" value="<?= $users->contact_number ?? old('contact_number') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('contact_number') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your contact number">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('contact_number') ?></p>
                    </div>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('address')  ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your complete address"><?= $users->address ?? old('address') ?? '' ?></textarea>
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('address') ?></p>
                    </div>
                </div>

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                        Current Password
                    </label>
                    <input type="password" id="current_password" name="current_password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-transparent transition-colors <?= isInvalid('current_password') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your current password">
                    <p class="mt-1 text-xs text-gray-500">Required only when changing password.</p>
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('current_password') ?></p>
                    </div>
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        New Password
                    </label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-transparent transition-colors <?= isInvalid('password') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Leave blank to keep current password">
                    <p class="mt-1 text-xs text-gray-500">Minimum 6 characters. Leave blank to keep your current password.</p>
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('password') ?></p>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm New Password
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-transparent transition-colors  <?= isInvalid('password_confirmation') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Confirm your new password">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('password_confirmation') ?></p>
                    </div>
                </div>

                <!-- Account status -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Account Status</h4>
                    <div class="flex items-center">
                        <?php if ($users->email_verified_at): ?>
                            <div class="flex items-center text-green-600">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">Email Verified</span>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center text-yellow">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm">Email Not Verified</span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form action -->
        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
            <a href="/customer/profile" class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-[#815331] text-white font-medium rounded-lg hover:bg-[#6b4428] transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Update Profile
            </button>
        </div>
    </form>
</div>

<script>
    // Profile picture preview
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.querySelector('.w-24.h-24 img') || document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';

                const container = document.querySelector('.w-24.h-24');
                container.innerHTML = '';
                container.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });

    // Password confirmation validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmation = this.value;

        if (password && confirmation && password !== confirmation) {
            this.setCustomValidity('Passwords do not match');
            this.classList.add('border-red-500');
        } else {
            this.setCustomValidity('');
            this.classList.remove('border-red-500');
        }
    });
</script>

<?php layout('customer/footer') ?>