<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/loginForm" method="POST">
        <?= csrf_token() ?>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= old('email') ?>" <?= isInvalid('email') ?>>
            <small><?= error('email') ?></small>

        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?= old('password') ?>" <?= isInvalid('password') ?>>
            <small><?= error('password') ?></small>
        </div>

        <button type="submit">Submit</button>


    </form>

</body>

</html>