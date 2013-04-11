<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<h1>Регистрация в 3 шага</h1>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>


    <div class="step-1">
    
        <?php $profileFields = $profile->getFields(); ?>
        
        <div class="row">
    	<?php echo $form->labelEx($model,'email'); ?>
    	<?php echo $form->textField($model,'email'); ?>
    	<?php echo $form->error($model,'email'); ?>
    	</div>
    	
    	<div class="row">
    	<?php echo $form->labelEx($model,'password'); ?>
    	<?php echo $form->passwordField($model,'password'); ?>
    	<?php echo $form->error($model,'password'); ?>
    	<p class="hint">
    	<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
    	</p>
    	</div>
    	
    	<div class="row">
    	<?php echo $form->labelEx($model,'verifyPassword'); ?>
    	<?php echo $form->passwordField($model,'verifyPassword'); ?>
    	<?php echo $form->error($model,'verifyPassword'); ?>
    	</div>
    	
    <?php
    		if ($profileFields) {
    			foreach($profileFields as $field) {
    			?>
    	<div class="row">
    		<?php echo $form->labelEx($profile,$field->varname); ?>
    		<?php 
    		if ($widgetEdit = $field->widgetEdit($profile)) {
    			echo $widgetEdit;
    		} elseif ($field->range) {
    			echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
    		} elseif ($field->field_type=="TEXT") {
    			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
    		} else {
    			echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
    		}
    		 ?>
    		<?php echo $form->error($profile,$field->varname); ?>
    	</div>	
    			<?php
    			}
    		}
    ?>
    
        <div class="row">
            <?php echo CHtml::label('Род деятельности', ''); ?>
            <?php echo $form->checkBoxList($model, 'careersArray', CHtml::listData(Career::model()->findAll(), 'id', 'name')); ?>
        </div>
    
        <div class="row">
    	<?php echo $form->labelEx($model,'verify_link'); ?>
    	<?php echo $form->textField($model,'verify_link'); ?>
    	<?php echo $form->error($model,'verify_link'); ?>
    	</div>
    
    	<?php if (UserModule::doCaptcha('registration')): ?>
    	<div class="row">
    		<?php echo $form->labelEx($model,'verifyCode'); ?>
    		
    		<?php $this->widget('CCaptcha'); ?>
    		<?php echo $form->textField($model,'verifyCode'); ?>
    		<?php echo $form->error($model,'verifyCode'); ?>
    		
    		<p class="hint"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
    		<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
    	</div>
    	<?php endif; ?>
    
    </div>
    
    <div class="step-2">
        <div class="row">
            <?php echo CHtml::label('Отметьте наиболее интересные для вас темы', ''); ?>
            <?php echo $form->checkBoxList($model, 'categoriesArray', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::label('Получать уведомления на почту по следующим темам', ''); ?>
            <?php echo $form->checkBoxList($model, 'notifyCatsArray', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
        </div>
        
        <div class="row">
    	<?php echo $form->checkBox($model,'send_notify'); ?>
        <?php echo $form->labelEx($model,'send_notify'); ?>
    	<?php echo $form->error($model,'send_notify'); ?>
    	</div>
    </div>
    
    <a href="#">Отмена</a>
    <a href="#">Дальше</a>
	
	<div class="row submit">
		<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>