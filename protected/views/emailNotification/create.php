<?php
/* @var $this EmailNotificationController */
/* @var $model EmailNotification */


$this->menu=array(
	array('label'=>'Назад', 'url'=>array('admin')),
);
?>

<h1>Создание уведомления</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'types'=>$types,)); ?>