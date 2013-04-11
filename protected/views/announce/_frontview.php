<?php
//    print_r($model);
//    die();
?>

<?php if ($model): ?>
    <div class="announce">
        <?php foreach ($model->components as $component): ?>
            <div class="component_container">
                <?php echo $component->getTitle(); ?>
                <?php $component->render(); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>