<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Управление статьями'=>array('index'),
	$model->title=>$model->url,
	'Редактирование',
);

$this->menu=array(
	array('label'=>'Просмотр', 'url'=>$model->url),
	array('label'=>'Создать статью', 'url'=>array('create')),
	array('label'=>'Управление статьями', 'url'=>array('admin')),
);
?>

<h1>Редактирование статьи «<?php echo $model->title; ?>»</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>