<?php $this->extend('/layout/auth'); ?>
<?php $this->assign('title', 'Register'); ?>

<?php $this->start('main'); ?>
<div class="font-medium text-3xl mb-3">New Member</div>
<div class="mb-5">Please fill up the following information.</div>

<form id="form-register" action="<?= $this->Url->build(['_name' => 'register']) ?>" method="POST">
    <label class="floating-label mb-4">
        <input type="text" class="input input-lg w-full" name="name" placeholder="Name">
        <span>Name</span>
    </label>

    <label class="floating-label mb-4">
        <input type="text" class="input input-lg w-full" name="email" placeholder="Email">
        <span>Email</span>
    </label>

    <label class="floating-label mb-4">
        <input type="password" class="input input-lg w-full" name="password" placeholder="Password">
        <span>Password</span>
    </label>

    <label class="floating-label mb-4">
        <input type="password" class="input input-lg w-full" name="confirm_password" placeholder="Confirm Password">
        <span>Confirm Password</span>
    </label>

    <div class="text-right">
        <a href="<?= $this->Url->build(['_name' => 'login.form']) ?>" class="btn btn-ghost">Already a member? Login instead.</a>

        <button type="submit" class="btn btn-primary">Register</button>
    </div>
</form>
<?php $this->end(); ?>

<?php $this->start('js'); ?>
<script>
    $('#form-register').submit(function(e)
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
            Swal.fire({
                icon: res.status,
                text: res.message
            });

            if (res.status == 'success')
            {
                form[0].reset();
            }
        });
    });
</script>
<?php $this->end(); ?>

