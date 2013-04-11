<?php
/* @var $this SourceController */
/* @var $model Source */

$this->breadcrumbs=array(
	'Manage',
);
?>

<h1>Manage Sources</h1>


<div class="upload_pane">
    <a id="upload_sources" href="#">Загрузить...</a>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'source-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'path',
		'owner_id',
		'owner_type',
		'date_create',
		'date_update',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'            
		),
	),
)); ?>
