<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
?>
<div class="white-box">
    <h2>Восстановление пароля</h2>
    
    <div class="form stat">
    
    <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success_message">
    <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
    <?php else: ?>
    
    <?php echo CHtml::beginForm(); ?>
    	
    	<div class="row">
    		<?php echo CHtml::activeLabel($form,'login_or_email'); ?>
    		<?php echo CHtml::activeTextField($form,'login_or_email') ?>
            <?php echo CHtml::error($form,'login_or_email'); ?>
    		<p class="hint">Пожалуйста, введите Ваш адрес электронной почты.</p>
    	</div>
    	
    	<div class="row submit">
            <label></label>
    		<button type="submit" class="blue_button">Восстановить</button>
    	</div>
    
    <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>
<?php endif; ?>
