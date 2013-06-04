<?php
/* @var $this CourseController */
/* @var $model Course */

$this->menu=array(
	array('label'=>'Добавить курс', 'url'=>array('create')),
    array('label'=>'Назад', 'url'=>array('/admin/index')),
);
?>

<h1>Управление видео-курсами</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'CHtml::link($data->title, Yii::app()->urlManager->createUrl("/course/update", array("id"=>$data->id)))'
        ),
        array(
            'name'=>'category_id',
            'type'=>'raw',
            'value'=>'$data->category->name',
            'filter'=>Category::items()
        ),
		'video_preview',
		'basic_cost',
		'advanced_cost',
        array(
            'type'=>'raw',
            'value'=>'CHtml::link("Вложения", Yii::app()->urlManager->createUrl("/course/manage", array("id"=>$data->id)))',
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}',
		),
	),
)); ?>
