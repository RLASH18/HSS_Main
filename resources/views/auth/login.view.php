<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>
    <form action="/loginForm" method="post">

        <?= csrf_token() ?>

        <?= flash('success') ?>

        <?= flash('error') ?>


        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>" <?= isInvalid('email') ?>>
            <div class="text-red-500">
                <p><?= error('email') ?></p>
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
</body>

</html>