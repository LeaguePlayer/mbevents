<?php
/* @var $this EmailNotificationController */
/* @var $model EmailNotification */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-notification-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php if ($model->isNewRecord): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'note_type'); ?>
		<?php echo $form->dropDownList($model,'note_type', $types); ?>
		<?php echo $form->error($model,'note_type'); ?>
	</div>
    <?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php
        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'text',
            // Optional config
            //'compressorRoute' => '/tinyMce/compressor',
            //'spellcheckerUrl' => array('tinyMce/spellchecker'),
            // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
            //'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
            'settings'=>array(
                'content_css' => $this->getAssetsBase().'/css/style.css',
            ),            
            'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                'connectorRoute'=>'/elfinder/connector',
            ),
            'htmlOptions' => array(
                'rows' => 6,
                'cols' => 60,
            ),
        ));
        ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'status'); ?>
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->