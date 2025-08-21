<?php layout('auth/header') ?>

<div class="register-page-container">
    <div class="register-container">
        <div class="register-title">
            <div class="signup-header">
                <h1>Sign Up</h1>
            </div>
            <p>Create your account to get started.</p>
        </div>

        <form action="/registerForm" method="post">
            <?= csrf_token() ?>
            <?= flash('success') ?>
            <?= flash('error') ?>
            <?= flash('info') ?>

            <div class="register-input-label">
                <div>
                    <input type="text" name="username" id="username" placeholder="Username" value="<?= old('username') ?>" <?= isInvalid('username') ?> class="focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-all">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('username') ?></p>
                    </div>
                </div>

                <div>
                    <input type="email" name="email" id="email" placeholder="Email" value="<?= old('email') ?>" <?= isInvalid('email') ?> class="focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-all">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('email') ?></p>
                    </div>
                </div>

                <div>
                    <input type="password" name="password" id="password" placeholder="Password" <?= isInvalid('password') ?> class="focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-all">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('password') ?></p>
                    </div>
                </div>

                <div>
                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" <?= isInvalid('confirmPassword') ?> class="focus:ring-2 focus:ring-[#815331] focus:border-[#815331] transition-all">
                    <div class="text-red-500 text-xs text-left mb-2">
                        <p><?= error('confirmPassword') ?></p>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button class="first">Sign Up</button>
                <h4><span>OR</span></h4>
                <a href="/login" class="second">Sign In</a>

                <div class="have-account">
                    <p>
                        Already have an Account? Signin your account here
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

<?php layout('auth/footer') ?>