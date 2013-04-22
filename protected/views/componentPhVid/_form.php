<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'component_phvid-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'video_source'); ?>
		<?php echo $form->textField($model,'video_source',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'video_source'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'photo_source'); ?>
		<?php $this->widget('ext.elFinder.ServerFileInput', array(
            'model'=>$model,
            'attribute'=>'photo_source',
            //'path' => '/uploads', // path to your uploads directory, must be writeable 
            //'url' => 'http://mbevents.loc/uploads/', // url to uploads directory 
            //'action' => $this->createUrl('/elfinder/connector') // the connector action (we assume we are pasting this code in the sitecontroller view file)
            'connectorRoute'=>'/elfinder/connector',
        )); ?>
		<?php echo $form->error($model,'photo_source'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php
        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'description',
            // Optional config
            'compressorRoute' => '/tinyMce/compressor',
            //'spellcheckerUrl' => array('tinyMce/spellchecker'),
            // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
            //'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
        ));
        ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        <?php
            if ( $backUrl != false ) {
                echo CHtml::link('Отмена', $backUrl);
            }
        ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->