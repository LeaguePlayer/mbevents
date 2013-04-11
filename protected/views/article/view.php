<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Управление статьями'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Создать статью', 'url'=>array('create')),
	array('label'=>'Изменить статью', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить статью', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Удалить эту статью?')),
	array('label'=>'Управление статьями', 'url'=>array('admin')),
);
?>

<h1>View Article #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'short_description',
		'full_description',
		'date_public',
		'date_create',
		'image',
		'tags',
		'status',
		'user_id',
	),
)); ?>
