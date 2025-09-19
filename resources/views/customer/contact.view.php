<?php layout('customer/header') ?>

<!-- Header Section -->
<div class="flex items-start justify-between mb-8">
    <div class="flex-1">
        <h1 class="mb-2 text-3xl font-bold leading-tight text-gray-900">Contact Support</h1>
        <p class="text-base font-normal text-gray-600">Send us a message and we'll get back to you as soon as possible</p>
    </div>
    <div class="flex space-x-3">
        <a href="/customer/profile" class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors bg-gray-600 rounded-lg hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Profile
        </a>
    </div>
</div>

<!-- Contact Information Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Email Card -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-[#815331] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                <p class="text-sm text-gray-600">Send us an email</p>
            </div>
        </div>
        <p class="text-gray-700">abgprimebuilderssuppliesinc4@gmail.com</p>
        <p class="text-xs text-gray-500 mt-2">We'll respond within 24 hours</p>
    </div>

    <!-- Phone Card -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-[#815331] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Phone</h3>
                <p class="text-sm text-gray-600">Call us directly</p>
            </div>
        </div>
        <p class="text-gray-700">+63 912 345 6789</p>
        <p class="text-xs text-gray-500 mt-2">Mon-Sat: 8AM-6PM</p>
    </div>

    <!-- Location Card -->
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm p-6">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 bg-[#815331] rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">Visit Us</h3>
                <p class="text-sm text-gray-600">Our store location</p>
            </div>
        </div>
        <p class="text-gray-700">L28, Block 11, km 17 Commonwealth Ave, Quezon City, 1127 Metro Manila</p>
        <p class="text-xs text-gray-500 mt-2">Open daily 8AM-6PM</p>
    </div>
</div>

<!-- Contact Form Section -->
<div class="bg-white border border-gray-100 rounded-lg shadow-sm p-8">
    <form action="/customer/send-contact" method="post">
        <?= csrf_token() ?>

        <!-- 2-Column Grid Layout -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

            <!-- Left Column -->
            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Contact Information</h3>

                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="<?= old('name') ?: (isset($user) ? $user->name : '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('name') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your full name">
                    <div class="mt-2 text-xs text-left text-red-500">
                        <p><?= error('name') ?></p>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="<?= old('email') ?: (isset($user) ? $user->email : '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('email') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your email address">
                    <div class="mt-2 text-xs text-left text-red-500">
                        <p><?= error('email') ?></p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="<?= old('phone') ?: (isset($user) ? $user->contact_number : '') ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors <?= isInvalid('phone') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Enter your phone number">
                    <div class="mt-2 text-xs text-left text-red-500">
                        <p><?= error('phone') ?></p>
                    </div>
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label for="subject" class="block mb-2 text-sm font-medium text-gray-700">Subject <span class="text-red-500">*</span></label>
                    <select name="subject" id="subject"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors bg-white <?= isInvalid('subject') ? 'border-red-300 bg-red-50' : '' ?>">
                        <option value="" disabled selected>-- Select a subject --</option>
                        <option value="General Inquiry" <?= old('subject') === 'General Inquiry' ? 'selected' : '' ?>>General Inquiry</option>
                        <option value="Product Question" <?= old('subject') === 'Product Question' ? 'selected' : '' ?>>Product Question</option>
                        <option value="Order Issue" <?= old('subject') === 'Order Issue' ? 'selected' : '' ?>>Order Issue</option>
                        <option value="Delivery Problem" <?= old('subject') === 'Delivery Problem' ? 'selected' : '' ?>>Delivery Problem</option>
                        <option value="Payment Issue" <?= old('subject') === 'Payment Issue' ? 'selected' : '' ?>>Payment Issue</option>
                        <option value="Technical Support" <?= old('subject') === 'Technical Support' ? 'selected' : '' ?>>Technical Support</option>
                        <option value="Complaint" <?= old('subject') === 'Complaint' ? 'selected' : '' ?>>Complaint</option>
                        <option value="Suggestion" <?= old('subject') === 'Suggestion' ? 'selected' : '' ?>>Suggestion</option>
                        <option value="Other" <?= old('subject') === 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                    <div class="mt-2 text-xs text-left text-red-500">
                        <p><?= error('subject') ?></p>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-gray-900 border-b border-gray-200">Message Details</h3>

                <!-- Message -->
                <div class="form-group">
                    <label for="message" class="block mb-2 text-sm font-medium text-gray-700">Message <span class="text-red-500">*</span></label>
                    <textarea name="message" id="message" rows="12"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors resize-none <?= isInvalid('message') ? 'border-red-300 bg-red-50' : '' ?>"
                        placeholder="Please describe your inquiry or issue in detail..."><?= old('message') ?></textarea>
                    <p class="mt-1 text-xs text-gray-500">Please provide as much detail as possible to help us assist you better</p>
                    <div class="mt-2 text-xs text-left text-red-500">
                        <p><?= error('message') ?></p>
                    </div>
                </div>

                <!-- Priority -->
                <div class="form-group">
                    <label for="priority" class="block mb-2 text-sm font-medium text-gray-700">
                        Priority Level
                    </label>
                    <select name="priority" id="priority"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-colors bg-white <?= isInvalid('priority') ? 'border-red-300 bg-red-50' : '' ?>">
                        <option value="Low" <?= old('priority') === 'Low' ? 'selected' : '' ?>>Low - General inquiry</option>
                        <option value="Medium" <?= old('priority') === 'Medium' ? 'selected' : '' ?> selected>Medium - Standard request</option>
                        <option value="High" <?= old('priority') === 'High' ? 'selected' : '' ?>>High - Urgent issue</option>
                        <option value="Critical" <?= old('priority') === 'Critical' ? 'selected' : '' ?>>Critical - Emergency</option>
                    </select>
                    <div class="mt-2 text-xs text-left text-red-500">
                        <p><?= error('priority') ?></p>
                    </div>
                </div>

                <!-- Response Method -->
                <div class="form-group">
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Preferred Response Method
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="response_method" value="Email" <?= old('response_method') === 'Email' || !old('response_method') ? 'checked' : '' ?>
                                class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                            <span class="ml-2 text-sm text-gray-700">Email (Recommended)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="response_method" value="Phone" <?= old('response_method') === 'Phone' ? 'checked' : '' ?>
                                class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                            <span class="ml-2 text-sm text-gray-700">Phone Call</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="response_method" value="Both" <?= old('response_method') === 'Both' ? 'checked' : '' ?>
                                class="w-4 h-4 text-[#815331] border-gray-300 focus:ring-[#815331]">
                            <span class="ml-2 text-sm text-gray-700">Either Email or Phone</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="pt-6 mt-8 border-t border-gray-200">
            <div class="flex items-center justify-end space-x-4">
                <a href="/customer/profile"
                    class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#815331] hover:bg-[#6b4428] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#815331] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Send Message
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Additional Information -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Response Time Information</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>Critical/High Priority:</strong> Within 2-4 hours during business hours</li>
                    <li><strong>Medium Priority:</strong> Within 24 hours</li>
                    <li><strong>Low Priority:</strong> Within 48 hours</li>
                    <li><strong>Business Hours:</strong> Monday-Saturday, 8:00 AM - 6:00 PM (GMT+8)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php layout('customer/footer') ?>