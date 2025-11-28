<?php $this->extend('/layout/app'); ?>
<?php $this->assign('title', 'Home'); ?>

<?php $this->start('main'); ?>
<div class="grid gap-4 sm:grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
    <?php foreach ($products as $product): ?>
    <div class="card bg-base-100 shadow-xl">
         <div class="h-50 overflow-hidden">
            <img src="<?= $product->image_url ?>" class="w-full h-full object-cover" alt="<?= $product->title ?>">
        </div>

        <div class="card-body">
            <div class="flex items-center justify-between">
                <div class="font-medium text-lg"><?= $product->title ?></div>
                <div class="text-xl"><?= $this->Number->currency($product->price / 1000, 'MYR'); ?></div>
            </div>

            <p><?= $this->Text->truncate($product->description, 100, ['ellipsis' => '...']) ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php $this->end(); ?>