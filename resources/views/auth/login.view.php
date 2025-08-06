<?php layout('auth/header') ?>

    <form action="/loginForm" method="post">

        <?= csrf_token() ?>

        <?= flash('success') ?>

        <?= flash('error') ?>


        <div>
            <label for="login">login</label>
            <input type="text" name="login" id="login" value="<?= old('login') ?>" <?= isInvalid('login') ?>>
            <div class="text-red-500">
                <p><?= error('login') ?></p>
            </div>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" <?= isInvalid('password') ?>>
            <div class="text-red-500">
                <p><?= error('password') ?></p>
            </div>
        </div>

        <div>
            <button type="submit">submit</button>
        </div>

    </form>

<?php layout('auth/footer') ?>
