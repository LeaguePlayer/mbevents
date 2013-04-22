
<div id="look_video" class="promo">
                        
    <div class="content_promo">
        <div class="close_video"><a class="close_fancybox" href="javascript:;"></a></div>
        <h2>Введите промо-код</h2>
        
        <div class="message_for_user">Введите промо-код, полученный на мероприятии и получите уникальную возможность для получения уникальной возможности.</div>
        
        <?php $form=$this->beginWidget('CActiveForm', array(
        	'id'=>'lesson-form',
        	'enableAjaxValidation'=>false,
        )); ?>
            
            <div class="div_with_inputs">
                <?php $promoLabels = $model->attributeLabels() ?>
        		<?php echo $form->textField($model,'promoCode',array('size'=>60,'maxlength'=>255, 'placeholder'=>$promoLabels['promoCode'])); ?>
            
                <?if ( null!==$regModel ):?>
                    <?php $regLabels = $regModel->attributeLabels() ?>
                	<?php echo $form->textField($regModel,'email', array('placeholder'=>$regLabels['email'])); ?>
                	<?php echo $form->passwordField($regModel,'password', array('placeholder'=>$regLabels['password'])); ?>
                	<?php echo $form->passwordField($regModel,'verifyPassword', array('placeholder'=>$regLabels['verifyPassword'])); ?>
                <?endif;?>
            
            </div>
            <div class="div_with_steps">
                <a href="javascript:;" class="next_step promocode_enter"></a>
                <a href="javascript:;" class="cancel_step close_fancybox">Не хочу ничего вводить</a>
            </div>
        
        <?php $this->endWidget(); ?>
    </div>
    
</div>