<?php
/* @var $this PromoCodeController */
/* @var $dataProvider CActiveDataProvider */

$this->menu=array(
	array('label'=>'Генератор промо-кодов', 'url'=>array('admin')),
);
?>

<h1 style="margin-bottom: 50px;">Доступные промо-коды</h1>

<?php
    $counter = 0;
    foreach ($models as $model): ?>
    <div style="font-size: 24px; font-weight: bold; line-height: 120%;">
        <?=++$counter.'. '.$model->code;?>
    </div>
<?php endforeach; ?>
