<?php layout('auth/header') ?>

<div>
    <div>
        <div>
            <h2>
                Verify Your Email
            </h2>
            <p>
                We've sent a 6-digit verification code to your email address.
            </p>
        </div>

        <form action="/verify-email-code" method="post">
            <?= csrf_token() ?>

            <?= flash('success') ?>
            <?= flash('error') ?>

            <div>
                <label for="verification_code" class="sr-only">Verification Code</label>
                <input id="verification_code" name="verification_code" type="text"
                    required
                    placeholder="Enter 6-digit code" maxlength="6" pattern="[0-9]{6}">
            </div>

            <div>
                <button type="submit">
                    Verify Email
                </button>
            </div>

            <div>
                <p>
                    Didn't receive the code?
                    <a href="/resend-verification" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Resend Code
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>



<?php layout('auth/footer') ?>