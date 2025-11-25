<?php $this->extend('/layout/app'); ?>
<?php $this->assign('title', 'My Profile'); ?>

<?php $this->start('main'); ?>
<div class="card bg-white shadow-lg rounded-none">
    <div class="card-body">
        <div class="card-title font-medium text-3xl mb-4">My Profile</div>
            
        <div class="flex justify-between">
            <div class="font-medium">Name</div>
            <div class="pl-3"><?= $user->name ?></div>
        </div>

        <div class="flex justify-between">
            <div class="font-medium">Email</div>
            <div class="pl-3"><?= $user->email ?></div>
        </div>

        <div class="flex justify-between">
            <div class="font-medium">Member Since</div>
            <div class="pl-3"><?= date('d F Y', strtotime($user->created_at)) ?></div>
        </div>

        <div class="card-actions justify-end mt-5">
            <a href="<?= $this->Url->build(['_name' => 'users.edit']) ?>" class="btn btn-primary">Edit</a>
            <a href="<?= $this->Url->build(['_name' => 'users.password']) ?>" class="btn btn-primary">Change Password</a>
        </div>
    </div>
</div>
<?php $this->end(); ?>