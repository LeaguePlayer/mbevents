<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */

$this->breadcrumbs=array(
	'Promo Codes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PromoCode', 'url'=>array('index')),
	array('label'=>'Create PromoCode', 'url'=>array('create')),
	array('label'=>'View PromoCode', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PromoCode', 'url'=>array('admin')),
);
?>

<h1>Update PromoCode <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>