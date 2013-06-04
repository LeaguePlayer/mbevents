<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">
    <h2>Форма обратной связи</h2>
    <p class="message_for_user">У Вас появился вопрос? Задайте его прямо сейчас  и мы ответим на него на указанный e-mail адрес в течение 24 часов.</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'callback-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fio'); ?>
		<?php echo $form->textField($model,'fio',array('size'=>60,'maxlength'=>256)); ?>
		<div class="errorMessage" style="display: none; width: 200px"></div>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>256)); ?>
		<div class="errorMessage" style="display: none; width: 200px;"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
		<div class="errorMessage" style="display: none; width: 200px"></div>
	</div>

	<div class="row buttons">
        <label></label>
		<button class="blue_button send_callback">Отправить</button>
        <? if (Yii::app()->request->isAjaxRequest ): ?>
            <a class="close_contentbox" href="#">Закрыть форму</a>
        <? endif; ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->