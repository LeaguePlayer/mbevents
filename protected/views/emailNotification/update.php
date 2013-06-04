<?php
/* @var $this EmailNotificationController */
/* @var $model EmailNotification */


$this->menu=array(
	array('label'=>'Создать уведомление', 'url'=>array('create')),
	array('label'=>'Назад', 'url'=>array('admin')),
);
?>

<h1>Update EmailNotification <?php echo EmailNotification::itemAlias("NoteType", $model->note_type); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'types'=>$types,)); ?>