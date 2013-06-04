<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Profile'), 'url'=>array('/user/profile')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
?>
<div class="form <? if (!Yii::app()->request->isAjaxRequest) echo 'stat'?>">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'profile-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<div class="white">    
        <h1>Личные настройки</h1>
        
        <?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
        <div class="success">
        <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
        </div>
        <?php endif; ?>
        
        <h2 class="underline">Личные данные</h2>
        
        <?php $profileFields = $profile->getFields(); ?>
        
        <div class="row">
    	<?php echo $form->labelEx($model,'email'); ?>
    	<?php echo $form->textField($model,'email'); ?>
    	<?php echo $form->error($model,'email'); ?>
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
            <?php if ( $field->varname == 'verify_link' ): ?>
                <p class="hint">Ссылка нужна для подтверждения вашей личности</p>
            <?php endif; ?>
    		<?php echo $form->error($profile,$field->varname); ?>
    	</div>	
    			<?php
    			}
    		}
    ?>
    
        <div class="row">
            <?php echo CHtml::label('Род деятельности', ''); ?>
            <?php echo $form->checkBoxList($model, 'careersArray', CHtml::listData(Career::model()->findAll(), 'id', 'name'), array(
                'separator'=>'',
                'template'=>'{input}{label}',
                'hidden'=>'hidden'
            )); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($changePassword,'oldPassword'); ?>
            <?php echo $form->passwordField($changePassword,'oldPassword'); ?>
            <a href="#" class="dot_button toggle_password"></a>
            <?php echo $form->error($changePassword,'oldPassword'); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($changePassword,'password'); ?>
            <?php echo $form->passwordField($changePassword,'password'); ?>
            <a href="#" class="dot_button toggle_password"></a>
            <?php echo $form->error($changePassword,'password'); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($changePassword,'verifyPassword'); ?>
            <?php echo $form->passwordField($changePassword,'verifyPassword'); ?>
            <a href="#" class="dot_button toggle_password"></a>
            <?php echo $form->error($changePassword,'verifyPassword'); ?>
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
    
    <h2 class="underline">Мои подписки</h2>
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
    	<?php echo $form->checkBox($profile,'send_notify'); ?>
        <?php echo $form->labelEx($profile,'send_notify'); ?>
    	<?php echo $form->error($profile,'send_notify'); ?>
	</div>
    
    <div class="row submit align_center">
        <button type="submit" class="blue_button">Сохранить<span class="icon"></span></button>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
