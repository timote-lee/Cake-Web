<?php $this->extend('/layout/app'); ?>
<?php $this->assign('title', 'Change Password'); ?>

<?php $this->start('main'); ?>
<div class="card bg-base-100 shadow-lg max-w-xl mx-auto">
    <div class="card-body">
        <div class="card-title font-medium text-3xl mb-4">Change Password</div>

        <form id="form-password" action="<?= $this->Url->build(['_name' => 'users.password.update']) ?>" method="POST">     
            <label class="input w-full mb-4">
                <span class="label">Current Password</span>
                <input type="password" name="current_password">
            </label>

            <label class="input w-full mb-4">
                <span class="label">New Password</span>
                <input type="password" name="new_password">
            </label>

            <label class="input w-full">
                <span class="label">Confirm New Password</span>
                <input type="password" name="confirm_new_password">
            </label>

            <div class="card-actions justify-end mt-5">
                <a href="<?= $this->Url->build(['_name' => 'users.show']) ?>" class="btn btn-soft btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
<?php $this->end(); ?>

<?php $this->start('js'); ?>
<script>
    $('#form-password').submit(function(e)
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
        });
    });
</script>
<?php $this->end(); ?>
