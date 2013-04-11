<?php
/* @var $this AnnounceController */
/* @var $model Announce */

$this->breadcrumbs=array(
	'Announces'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Announce', 'url'=>array('view', 'operation'=>'new')),
);
?>

<h1>Manage Announces</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'announce-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'CHtml::link($data->title, "/announce/view?operation=edit&id=".$data->id)',
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
