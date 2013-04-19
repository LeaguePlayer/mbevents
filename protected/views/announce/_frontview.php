
<?php if ($model): ?>
    <?php foreach ($model->components as $component): ?>
        <?php $component->render(); ?>
    <?php endforeach; ?>
<?php endif; ?>