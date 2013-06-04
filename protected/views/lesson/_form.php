<?php
/* @var $this LessonController */
/* @var $model Lesson */
/* @var $form CActiveForm */
?>

<div class="form stat">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lesson-form',
	'enableAjaxValidation'=>true,
)); ?>

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
            'htmlOptions'=>array(
                'style'=>''
            ),
            'contHtmlOptions'=>array(
                'style'=>'display:inline-block;'
            ),
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
            'htmlOptions'=>array(
                'style'=>''
            ),
            'contHtmlOptions'=>array(
                'style'=>'display:inline-block;'
            ),
        )); ?>
		<?php echo $form->error($model,'poster'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php
        $this->widget('tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'description',
            // Optional config
            'compressorRoute' => '/tinyMce/compressor',
            'settings' => array(
                'content_css'=>$this->getAssetsBase().'/css/style.css',
                'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
                'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor",
            ),
            'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                'connectorRoute'=>'/elfinder/connector',
            ),
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
		<?php echo CHtml::submitButton('Сохранить'); ?>
        <a href="<?=$this->createUrl('admin')?>">Отмена</a>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->