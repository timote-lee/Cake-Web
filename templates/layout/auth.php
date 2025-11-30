<!doctype html>
<html lang="en">
    <head>
        <title>Cake - <?= $this->fetch('title') ?></title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">

        <!-- CSS -->
        <link rel="stylesheet" href="<?= $this->Url->css('auth.css'); ?>">
    </head>

    <body data-theme="light">
        <div class="main">
            <div class="body">
                <?= $this->fetch('main') ?>
            </div>
        </div>

        <!-- JS  -->
        <script src="<?= $this->Url->script('auth.js'); ?>"></script>

        <?= $this->fetch('js') ?>
    </body>
</html>
