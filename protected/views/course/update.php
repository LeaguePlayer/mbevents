<?php
$this->menu=array(
	array('label'=>'Назад', 'url'=>array('admin')),
);
?>

<h1>Редактирование курса «<?=$model->title?>»</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>