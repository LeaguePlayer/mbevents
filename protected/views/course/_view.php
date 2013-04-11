<?php
/* @var $this CourseController */
/* @var $data Course */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('video_preview')); ?>:</b>
	<?php echo CHtml::encode($data->video_preview); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('basic_cost')); ?>:</b>
	<?php echo CHtml::encode($data->basic_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('advanced_cost')); ?>:</b>
	<?php echo CHtml::encode($data->advanced_cost); ?>
	<br />


</div>