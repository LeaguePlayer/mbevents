<?php
/* @var $this CourseController */
/* @var $model Course */

$this->menu=array(
	array('label'=>'Create Course', 'url'=>array('view', 'operation'=>'new')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#course-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Courses</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'CHtml::link($data->title, "/course/view?operation=edit&id=".$data->id)'
        ),
		'category_id',
		'video_preview',
		'basic_cost',
		'advanced_cost',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
)); ?>
