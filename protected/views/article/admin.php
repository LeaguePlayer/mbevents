<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Управление статьями',
);

$this->menu=array(
	array('label'=>'Создать статью', 'url'=>array('create')),
);
?>

<h1>Управление статьями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'article-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'short_description',
		'date_public',
		array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>'Article::statuses($data->status)',
            'filter'=>Article::statuses(),
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
