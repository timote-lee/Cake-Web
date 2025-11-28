<!doctype html>
<html lang="en">
    <head>
        <title>JY Store - <?= $this->fetch('title') ?></title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">

        <!-- CSS libraries -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daisyui@5" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer">

        <!-- custom CSS -->
        <link rel="stylesheet" href="<?= $this->Url->css('auth.css'); ?>">
    </head>

    <body>
        <div class="main">
            <div class="body">
                <?= $this->fetch('main') ?>
            </div>
        </div>

        <!-- JS libraries -->
        <script src="//cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="//code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="<?= $this->Url->script('base.js'); ?>"></script>

        <!-- custom JS -->
        <?= $this->fetch('js') ?>
    </body>
</html>
