<?php
/* @var $this LessonController */
/* @var $model Lesson */

$this->breadcrumbs=array(
	'Lessons'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Добавить новую', 'url'=>array('create')),
	//array('label'=>'View Lesson', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление сессиями', 'url'=>array('admin')),
);
?>

<h1>Редактирование сессии «<?php echo $model->name; ?>»</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>