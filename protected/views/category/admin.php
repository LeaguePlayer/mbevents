<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Управление категориями',
);

$this->menu=array(
	//array('label'=>'Все категории', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
    array('label'=>'Назад', 'url'=>array('/admin/index')),
);
?>

<h1>Управление категориями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'descripion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
