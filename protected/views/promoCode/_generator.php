<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promo-code-form',
	'enableAjaxValidation'=>true,
    'action'=>'/promoCode/generate'
)); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'count'); ?>
		<?php echo $form->textField($model,'count',array('size'=>20,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'expire_date'); ?>
		<?php
        $this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'expire_date',
            'language'=>'ru',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
            ),
        ));
        ?>
		<?php echo $form->error($model,'expire_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сгенерировать'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->