<!doctype html>
<html lang="en">
    <head>
        <title>Cake - <?= $this->fetch('title') ?></title>
        <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?= $this->request->getAttribute('csrfToken') ?>">

        <!-- CSS libraries -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/daisyui@5" type="text/css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    </head>

    <body class="min-h-screen bg-base-300">
        <!-- navbar -->
        <div class="navbar bg-neutral text-neutral-content shadow-md">       
            <div class="flex-1">
                <a href="<?= $this->Url->build(['_name' => 'home']) ?>" class="btn btn-ghost text-xl">Cake</a>
            </div>

            <div class="flex-none">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <i class="fas fa-2xl fa-user-circle"></i>
                    </div>

                    <ul class="menu dropdown-content bg-base-200 text-neutral z-1 mt-3 w-52 p-2 shadow">
                        <li>
                            <a href="<?= $this->Url->build(['_name' => 'users.show']) ?>">Profile</a>
                        </li>

                        <li>
                            <a href="<?= $this->Url->build(['_name' => 'logout']) ?>" id="logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>

            <form id="form-logout" action="<?= $this->Url->build(['_name' => 'logout']) ?>" method="POST">
            </form>
        </div>

        <!-- main -->
        <div class="main p-5">
            <?= $this->fetch('main') ?>
        </div>

        <!-- JS libraries -->
        <script src="//cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="//code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- custom JS -->
        <script src="<?= $this->Url->script('base.js'); ?>"></script>
        <script>
            $('#logout').click(function(e)
            {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    text: 'Proceed to logout?'
                })
                .then(function(result)
                {   
                    if (result.isConfirmed)
                    {
                        $('#form-logout').submit();
                    }
                });
            });

            $('#form-logout').submit(function(e)
            {
                e.preventDefault();

                const form = $(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    dataType: 'json'
                })
                .done(function(res)
                {
                    if (res.status == 'error')
                    {
                        Swal.fire({
                            icon: res.status,
                            text: res.message
                        });
                    }
                        
                    else 
                    {
                        // backend handle the redirection upon page reload
                        window.location.reload();
                    }
                });
            });
        </script>
        <?= $this->fetch('js') ?>
    </body>
</html>
