<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'component_eventform-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'position'); ?>
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