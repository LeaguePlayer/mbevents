<div class="form stat">   
    <fieldset>
        <legend><?= $model->isNewRecord ? 'Новый спикер' : 'Редактирование' ?></legend>
            <?php $form=$this->beginWidget('CActiveForm', array(
            	'id'=>'spieker_form-form',
            	'enableAjaxValidation'=>false,
                'action'=>$this->createUrl('/componentSpiekers/addSpieker', array('id'=>$model->id)),
            )); ?>
            
            	<?php echo $form->errorSummary($model); ?>
            
            	<div class="row">
            		<?php echo $form->labelEx($model,'fio'); ?>
            		<?php echo $form->textField($model,'fio',array('size'=>60,'maxlength'=>255)); ?>
            		<?php echo $form->error($model,'fio'); ?>
            	</div>
            
            	<div class="row">
            		<?php echo $form->labelEx($model,'photo'); ?>
            		<?php $this->widget('ext.elFinder.ServerFileInput', array(
                        'model'=>$model,
                        'attribute'=>'photo',
                        //'path' => '/uploads', // path to your uploads directory, must be writeable 
                        //'url' => 'http://mbevents.loc/uploads/', // url to uploads directory 
                        //'action' => $this->createUrl('/elfinder/connector') // the connector action (we assume we are pasting this code in the sitecontroller view file)
                        'connectorRoute'=>'/elfinder/connector',
                        'htmlOptions'=>array(
                            'style'=>'',
                            //'data-attribute'=>'photo',
                        ),
                        'contHtmlOptions'=>array(
                            'style'=>'display:inline-block;'
                        ),
                    )); ?>
            		<?php echo $form->error($model,'photo'); ?>
            	</div>
                
                <div class="row">
            		<?php echo $form->labelEx($model,'description'); ?>
            		<?php echo $form->textarea($model,'description'); ?>
            		<?php echo $form->error($model,'description'); ?>
            	</div>
                
                <div class="row">
            		<?php echo $form->labelEx($model,'position'); ?>
            		<?php echo $form->textField($model,'position'); ?>
            		<?php echo $form->error($model,'position'); ?>
            	</div>
            
            	<div class="row buttons">
            		<a class="access" href="javascript:void();">Подтвердить</a>
                    <a class="cancel" href="javascript:void();">Отмена</a>
            	</div>
            
            <?php $this->endWidget(); ?>
    </fieldset>
</div><!-- form -->