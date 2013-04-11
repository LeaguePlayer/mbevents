<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */
?>

<?php


$this->menu=array(
	array('label'=>'Для печати', 'url'=>array('index')),
);


Yii::app()->clientScript->registerScript('codegenerator', "
$('.generator-button').click(function(){
	$('.generator-form').toggle();
	return false;
});

$('.generator-form form').submit(function() {
    $.ajax({
        url: '/promoCode/generate',
        type: 'POST',
        data: $(this).serialize(),
        success: function(data) {
            $('#promo-code-grid').yiiGridView('update', {
        		data: $(this).serialize()
        	});
            $('.generator-form').toggle();
        }
    });
	return false;
});
");
?>


<h1>Управление промо-кодами для доступа к видеоурокам</h1>


<?php echo CHtml::link('Генератор кодов...', '#', array('class'=>'generator-button')); ?>
<div class="generator-form" style="display:none">
    <?php echo $this->renderPartial('_generator', array('model'=>new PromoCode('generate'))); ?>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'promo-code-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'code',
		'expire',
		'last_update',
		'status',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
