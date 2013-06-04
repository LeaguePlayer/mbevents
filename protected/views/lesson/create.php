<?php
/* @var $this LessonController */
/* @var $model Lesson */

$this->menu=array(
	array('label'=>'Назад', 'url'=>array('admin')),
);
?>

<h1>Новая видеосессия</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>