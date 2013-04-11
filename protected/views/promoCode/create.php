<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */

$this->breadcrumbs=array(
	'Promo Codes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PromoCode', 'url'=>array('index')),
	array('label'=>'Manage PromoCode', 'url'=>array('admin')),
);
?>

<h1>Create PromoCode</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>