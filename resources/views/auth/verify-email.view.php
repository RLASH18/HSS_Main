<?php layout('auth/header') ?>
    <div class="register-page-container">
        <div class="register-container">
            <div class="register-title">
                <div class="signup-header">
                    <h1>Verify Your Email</h1>
                </div>
                <p>We've sent a 6-digit verification code to your email address.</p>
            </div>

            <form action="/verify-email-code" method="post">
                <?= csrf_token() ?>
                <?= flash('success') ?>
                <?= flash('error') ?>

                <div class="register-input-label">
                    <div>
                        <input type="text" name="verification_code"  id="verification_code" placeholder="Enter 6-digit code"
                            maxlength="6" pattern="[0-9]{6}" value="<?= old('verification_code') ?>"  <?= isInvalid('verification_code') ?>>
                        <div class="text-red-500 text-xs text-left mb-2">
                            <p><?= error('verification_code') ?></p>
                        </div>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="first">Verify Email</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php layout('auth/footer') ?>