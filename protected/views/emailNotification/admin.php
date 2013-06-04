<?php
/* @var $this EmailNotificationController */
/* @var $model EmailNotification */


$this->menu=array(
	array('label'=>'Создать уведомление', 'url'=>array('create')),
    array('label'=>'Назад', 'url'=>array('/admin/index')),
);
?>

<h1>Управление уведомлениями</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'email-notification-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
            'name'=>'note_type',
            'type'=>'raw',
            'value'=>'CHtml::link(emailNotification::itemAlias("NoteType", $data->note_type), $data->updateUrl)',
        ),
        'subject',
	),
)); ?>
