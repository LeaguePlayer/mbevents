<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");?>

<div class="white-box">
    <h2>Восстановление пароля</h2>
    
    <div class="form stat">
        <?php echo CHtml::beginForm(); ?>
        	
        	<div class="row">
        	<?php echo CHtml::activeLabelEx($form,'password'); ?>
        	<?php echo CHtml::activePasswordField($form,'password'); ?>
            <?php echo CHtml::error($form,'password'); ?>
        	</div>
        	
        	<div class="row">
        	<?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
        	<?php echo CHtml::activePasswordField($form,'verifyPassword'); ?>
            <?php echo CHtml::error($form,'verifyPassword'); ?>
        	</div>
        	
        	
        	<div class="row submit">
                <label></label>
        		<button type="submit" class="blue_button">Сохранить</button>
        	</div>
        
        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>