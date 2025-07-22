<?php layout('header') ?>

<form action="/loginForm" method="POST">
    <!-- In every post method, you need too add this to prevent CSRF attacks -->
    <!-- If you don't add this it will throw a 419 status code -->
    <?= csrf_token() ?>

    <label for="username">Username</label>
    <!-- This keeps the old username (old()), shows red border if there's an error (isInvalid()), and displays the error message (error()) -->
    <input type="text" name="username" id="username" value="<?= old('username') ?>" <?= isInvalid('username') ?>>
    <small><?= error('username') ?></small>

</form>

<?php layout('footer') ?>