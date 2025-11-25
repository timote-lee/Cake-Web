<?php $this->extend('/layout/app'); ?>
<?php $this->assign('title', 'Edit Profile'); ?>

<?php $this->start('main'); ?>
<div class="card bg-white shadow-lg rounded-none">
    <div class="card-body">
        <div class="card-title font-medium text-3xl mb-5">Edit Profile</div>

        <form id="form-edit" action="<?= $this->Url->build(['_name' => 'users.update']) ?>" method="POST">     
            <label class="input w-full">
                <span class="label">Name</span>
                <input type="text" name="name" value="<?= $user->name ?>">
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
    $('#form-edit').submit(function(e)
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
