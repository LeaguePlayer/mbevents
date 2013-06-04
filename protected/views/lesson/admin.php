<?php
/* @var $this LessonController */
/* @var $model Lesson */

$this->menu=array(
	array('label'=>'Добавить сессию', 'url'=>array('create')),
    array('label'=>'Назад', 'url'=>array('/admin/index')),
);
?>

<h1>Управление видесессиями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lesson-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link($data->name, Yii::app()->urlManager->createUrl("/lesson/update", array("id"=>$data->id)))',
        ),
        array(
            'name'=>'course_id',
            'type'=>'raw',
            'value'=>'$data->OwnerName()'
        ),
		'date_public',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update}{delete}',
		),
	),
)); ?>
