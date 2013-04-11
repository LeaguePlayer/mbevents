<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Управление статьями'=>array('admin'),
	'Создание статьи',
);

$this->menu=array(
	array('label'=>'Управление статьями', 'url'=>array('admin')),
);
?>

<h1>Добавление статьи</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>