
<?
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'reg_on_event-form',
    'action'=>$this->createUrl('/componentRegOnEvent/registration'),
    'enableAjaxValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        //'afterValidate'=>'',
    ),
    'htmlOptions'=>array(
        'class'=>'reg-event-form',
    )
));?>
    <?php echo CHtml::activeHiddenField($model, 'announce_id'); ?>
    
    <div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model, 'name'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone'); ?>
        <?php echo $form->error($model, 'phone'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model, 'company'); ?>
		<?php echo $form->textField($model, 'company'); ?>
        <?php echo $form->error($model, 'company'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model, 'job'); ?>
		<?php echo $form->textField($model, 'job'); ?>
        <?php echo $form->error($model, 'job'); ?>
	</div>
    
    <!--
    <div class="row">
		<?php //echo $form->labelEx($model, 'secretkey'); ?>
		<?php //echo $form->textField($model, 'secretkey'); ?>
        <?php //echo $form->error($model, 'secretkey'); ?>
	</div>
    -->
    
    <div class="clear"></div>
    
    <? if (Yii::app()->user->hasFlash('SUCCESS_EVENT_MESSAGE')): ?>
    <div class="success_message">
        <?=Yii::app()->user->getFlash('SUCCESS_EVENT_MESSAGE');?>
    </div>
    <? endif; ?>
    
	<div>
        <?php
            // подавления регистрации скриптов при ajax-загрузке
            if ( Yii::app()->request->isAjaxRequest )
                echo CHtml::submitButton('Забронировать',  array('class'=>'reserve'));
            else
                echo CHtml::ajaxSubmitButton('Забронировать', Yii::app()->createUrl('/componentRegOnEvent/registration'),
                    array('update'=>'.event_form'),
                    array('class'=>'reserve'
                ));
        ?>
		<div class="clear"></div>
	</div>
<?$this->endWidget();?>