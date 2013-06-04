<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
//$this->breadcrumbs=array(
//	UserModule::t("Registration"),
//);
?>

<div class="registration_form">

    <h2 class="title">Регистрация</h2>
    
    <div class="steps">
        <ul>
            <li class="current first"><span class="label">Личные данные</span></li>
            <li class="last"><span class="label">Выбор подписок</span></li>
            <!--<li class="last"><span class="label">Партнерская система</span></li>-->
        </ul>
    </div>
    
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
                <a href="#" class="dot_button toggle_password"></a>
            	<?php echo $form->error($model,'password'); ?>
            	<p class="hint"><?php echo UserModule::t("Minimal password length 4 symbols."); ?></p>
        	</div>
        	
        	<div class="row">
        	<?php echo $form->labelEx($model,'verifyPassword'); ?>
        	<?php echo $form->passwordField($model,'verifyPassword'); ?>
            <a href="#" class="dot_button toggle_password"></a>
        	<?php echo $form->error($model,'verifyPassword'); ?>
        	</div>
        	
        <?php
        		if ($profileFields) {
        			foreach($profileFields as $field) {
                        if ( $field->varname == 'send_notify' ) {
                            continue;
                        }
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
                <?php if ( $field->varname == 'verify_link' ): ?>
                    <p class="hint">Ссылка нужна для подтверждения вашей личности</p>
                <?php endif; ?>
        	</div>	
        			<?php
        			}
        		}
        ?>
        
            <div class="row">
                <?php echo CHtml::label('Выберите род Вашей деятельности', ''); ?>
                <?php echo $form->checkBoxList($model, 'careersArray', CHtml::listData(Career::model()->findAll(), 'id', 'name'), array(
                    'separator'=>'',
                    'template'=>'{input}{label}',
                    'hidden'=>'hidden'
                )); ?>
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
            
            <? if (Yii::app()->request->isAjaxRequest): ?>
                <div class="row submit">
                    <label></label>
                    <button type="submit" class="blue_button step_one" data-current="1" data-next="2">Продолжить<span class="icon"></span></button>
                    <a class="cancel_step close_fancybox close_box" href="#">Не хочу регистрироваться</a>
            	</div>
             <? endif ?>
        
        </div>
        
        <div class="step-2" style="<? if(Yii::app()->request->isAjaxRequest) echo 'display: none;';?>">
            <div class="cell interest">
                <?php echo CHtml::label('Интересные темы', ''); ?>
                <p class="hint">Отметьте наиболее интересные для вас темы</p>
                <?php echo $form->checkBoxList($model, 'categoriesArray', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
            </div>
            
            <div class="cell notify">
                <?php echo CHtml::label('Уведомленя на почту', ''); ?>
                <p class="hint">Получать уведомления на почту по следующим темам</p>
                <?php echo $form->checkBoxList($model, 'notifyCatsArray', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
            </div>
            
            <div class="row check_notify">
            <? //$field = $profileFields['send_notify']; ?>
        	<?php echo $form->checkBox($profile,'send_notify'); ?>
            <?php echo $form->labelEx($profile,'send_notify'); ?>
        	<?php echo $form->error($profile,'send_notify'); ?>
        	</div>
            
            <div class="row submit">
                <a class="goto_step" href="#" data-target="1">Назад к первому шагу</a>
                <button type="submit" class="blue_button step_two" data-current="2" data-next="finish">Продолжить<span class="icon"></span></button>
        	</div>
            
        </div>
    
    <?php $this->endWidget(); ?>
    </div><!-- form -->
    <?php endif; ?>
    
</div>