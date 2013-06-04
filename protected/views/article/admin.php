<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Управление статьями',
);

$this->menu=array(
	array('label'=>'Создать статью', 'url'=>array('create')),
    array('label'=>'Назад', 'url'=>array('/admin/index')),
);
?>

<h1>Управление статьями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'article-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'header'=>'',
            'type'=>'raw',
            'value'=>'$data->getThumb()',
        ),
        array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'CHtml::link($data->title, Yii::app()->urlManager->createUrl("/article/update", array("id"=>$data->id)))',
        ),
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
