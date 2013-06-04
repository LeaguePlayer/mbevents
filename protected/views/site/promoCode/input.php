
<div id="look_video" class="promo">
                        
    <div class="content_promo">
        <div class="close_video"><a class="close_fancybox" href="javascript:;"></a></div>
        <h2>Введите промо-код</h2>
        
        <div class="message_for_user">Для получения доступа к базовому курсу "Успех в продажах" необходимо ввести специальный код-доступа и заполнить информационные поля.</div>
        
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'lesson-form',
        	'enableAjaxValidation'=>false,
        )); ?>
            
            <div class="div_with_inputs">
                <?php $promoLabels = $model->attributeLabels() ?>
        		<?php echo $form->textField($model,'promoCode',array('size'=>60,'maxlength'=>255, 'placeholder'=>$promoLabels['promoCode'], 'style'=>'letter-spacing: 2px;')); ?>
            
                <?if ( null!==$regModel ):?>
                    <?php $regLabels = $regModel->attributeLabels() ?>
                	<?php echo $form->textField($regModel,'email', array('placeholder'=>$regLabels['email'], 'style'=>'letter-spacing: 2px;')); ?>
                	<?php echo $form->passwordField($regModel,'password', array('placeholder'=>$regLabels['password'], 'style'=>'letter-spacing: 2px;')); ?>
                	<?php echo $form->passwordField($regModel,'verifyPassword', array('placeholder'=>$regLabels['verifyPassword'], 'style'=>'letter-spacing: 2px;')); ?>
                <?endif;?>
            
            </div>
            <div class="div_with_steps">
                <a href="javascript:;" class="next_step promocode_enter"></a>
                <a href="javascript:;" class="cancel_step close_fancybox">Не хочу ничего вводить</a>
            </div>
        
        <?php $this->endWidget(); ?>
    </div>
    
</div>