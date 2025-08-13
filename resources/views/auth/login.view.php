<?php layout('auth/header') ?>
    <div class="login-page-container">
        <div class="login-container">
            <div class="header-container">
                <div class="sign-in-container">
                    <h1>Sign In</h1>
                </div>
                <p>Welcome back to ABG Prime Builders Supplies Inc.</p>
            </div>

            <form action="/loginForm" method="post">
                <?= csrf_token() ?>
                <?= flash('success') ?>
                <?= flash('error') ?>
                <?= flash('info') ?>

                <div class="input-container">
                    <div>
                        <input type="text" name="login" id="login" placeholder="username/email" value="<?= old('login') ?>" <?= isInvalid('login') ?>>
                        <div class="text-red-500 text-xs text-left mb-2">
                            <p><?= error('login') ?></p>
                        </div>
                    </div>

                    <div>
                        <input type="password" name="password" id="password" placeholder="password" <?= isInvalid('password') ?>>
                        <div class="text-red-500 text-xs text-left mb-2">
                            <p><?= error('password') ?></p>
                        </div>
                    </div>
                    <div class="remember">
                        <label><input type="checkbox" />Remember me</label>
                    </div>
                </div>

                <div class="buttons">
                    <button class="first">Sign In</button>
                    <h4><span>OR</span></h4>
                    <a href="/register" class="second">Sign Up</a>

                    <div class="have-account">
                        <p>
                            Don't have an account? Create your account, it takes less than a
                            minute.
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php layout('auth/footer') ?>
