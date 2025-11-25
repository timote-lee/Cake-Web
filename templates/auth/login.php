<?php $this->extend('/layout/auth'); ?>
<?php $this->assign('title', 'Login'); ?>

<?php $this->start('main'); ?>
<div class="font-medium text-3xl mb-3">Login Here</div>
<div class="mb-5">Please enter your login credentials below.</div>

<form id="form-login" action="<?= $this->Url->build(['_name' => 'login']) ?>" method="POST">
    <label class="floating-label mb-4">
        <input type="text" class="input input-lg w-full" name="email" placeholder="Email">
        <span>Email</span>
    </label>

    <label class="floating-label mb-4">
        <input type="password" class="input input-lg w-full" name="password" placeholder="Password">
        <span>Password</span>
    </label>

    <div class="text-right">
        <a href="<?= $this->Url->build(['_name' => 'register.form']) ?>" class="btn btn-ghost">New here? Become a member!</a>

        <button type="submit" class="btn btn-primary">Log In</button>
    </div>
</form>
<?php $this->end(); ?>

<?php $this->start('js'); ?>
<script>
    $('#form-login').submit(function(e)
    {   
        e.preventDefault();

        const form = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
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
<?php $this->end(); ?>
