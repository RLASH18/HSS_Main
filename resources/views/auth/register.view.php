<?php layout('auth/header') ?>
    <div class="register-page-container">
        <div class="register-container">
                <form action="/registerForm" method="post">

                <?= csrf_token() ?>

                <div class="register-title">
                    <div class="signup-header">
                        <h1>Sign Up</h1>
                    </div>
                    <p>Create your account to get started.</p>
                </div>

                <div class="register-input-label">
                    <div>
                        <input type="text" name="username" id="username" placeholder="Username" value="<?= old('username') ?>" <?= isInvalid('username') ?>>
                        <div class="text-red-500">
                            <p><?= error('username') ?></p>
                        </div>
                    </div>

                    <div>
                        <input type="email" name="email" id="email" placeholder="Email" value="<?= old('email') ?>" <?= isInvalid('email') ?>>
                        <div class="text-red-500">
                            <p><?= error('email') ?></p>
                        </div>
                    </div>

                    <div>
                        <input type="password" name="password" id="password" placeholder="Password" <?= isInvalid('password') ?>>
                        <div class="text-red-500">
                            <p><?= error('password') ?></p>
                        </div>
                    </div>

                    <div>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" <?= isInvalid('confirmPassword') ?>>
                        <div class="text-red-500">
                            <p><?= error('confirmPassword') ?></p>
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button class="sign-up">Sign Up</button>
                        <h4><span>OR</span></h4>
                    <button class="sign-in">Sign In</button>
                </div>

                <div>
                    <p class="have-account">
                    Already have an Account? Signin your account <a href="#">here</a>
                    </p>
                </div>

            </form>
        </div>
        
    </div>

    
<?php layout('auth/footer') ?>