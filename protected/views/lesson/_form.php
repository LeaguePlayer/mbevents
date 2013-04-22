<?php
/* @var $this LessonController */
/* @var $model Lesson */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lesson-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'source'); ?>
		<?php $this->widget('ext.elFinder.ServerFileInput', array(
            'model'=>$model,
            'attribute'=>'source',
            //'path' => '/uploads', // path to your uploads directory, must be writeable 
            //'url' => 'http://mbevents.loc/uploads/', // url to uploads directory 
            //'action' => $this->createUrl('/elfinder/connector') // the connector action (we assume we are pasting this code in the sitecontroller view file)
            'connectorRoute'=>'/elfinder/connector',
        )); ?>
		<?php echo $form->error($model,'source'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'poster'); ?>
		<?php $this->widget('ext.elFinder.ServerFileInput', array(
            'model'=>$model,
            'attribute'=>'poster',
            //'path' => '/uploads', // path to your uploads directory, must be writeable 
            //'url' => 'http://mbevents.loc/uploads/', // url to uploads directory 
            //'action' => $this->createUrl('/elfinder/connector') // the connector action (we assume we are pasting this code in the sitecontroller view file)
            'connectorRoute'=>'/elfinder/connector',
        )); ?>
		<?php echo $form->error($model,'poster'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php
        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'description',
            // Optional config
            'compressorRoute' => '/tinyMce/compressor',
        ));
        ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_public'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'date_public',
		    'language'=>'ru',
		    // additional javascript options for the date picker plugin
		    'options'=>array(
		        'showAnim'=>'fold',
		    ),
		    'htmlOptions'=>array(
		        'style'=>'height:20px;'
		    ),
		)); ?>
		<?php echo $form->error($model,'date_public'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->