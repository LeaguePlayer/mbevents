<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */

$this->breadcrumbs=array(
	'Promo Codes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PromoCode', 'url'=>array('index')),
	array('label'=>'Create PromoCode', 'url'=>array('create')),
	array('label'=>'Update PromoCode', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PromoCode', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PromoCode', 'url'=>array('admin')),
);
?>

<h1>View PromoCode #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'expire',
		'last_update',
		'status',
	),
)); ?>
