<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Категории'=>array('admin'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Управление категориями', 'url'=>array('admin')),
);
?>

<h1>Create Category</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>