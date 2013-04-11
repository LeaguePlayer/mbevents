<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Категории'=>array('admin'),
	"Редактирование категории «{$model->name}",
);

$this->menu=array(
	array('label'=>'Добавить новую', 'url'=>array('create')),
	array('label'=>'Категории', 'url'=>array('admin')),
);
?>

<h1>Редактирование категории «<?php echo $model->name; ?>»</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>