<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
    'action'=>$this->createUrl('/course/view', array('id'=>$model->id, 'operation'=>'edit')),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <fieldset>
        <legend>Общая информация</legend>
        <div class="row">
    		<?php echo $form->labelEx($model,'category_id'); ?>
    		<?php echo $form->dropDownList($model,'category_id', CHtml::listData(Category::model()->findAll(), 'id', 'name')); ?>
    		<?php echo $form->error($model,'category_id'); ?>
    	</div>
    
    	<div class="row">
    		<?php echo $form->labelEx($model,'title'); ?>
    		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
    		<?php echo $form->error($model,'title'); ?>
    	</div>
    
    	<div class="row">
    		<?php echo $form->labelEx($model,'video_preview'); ?>
    		<?php echo $form->textField($model,'video_preview',array('cols'=>60,'maxlength'=>255)); ?>
    		<?php echo $form->error($model,'video_preview'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'description'); ?>
    		<?php echo $form->textArea($model,'description'); ?>
    		<?php echo $form->error($model,'description'); ?>
    	</div>
        
        <fieldset>
            <legend>Базовая часть</legend>
            <div class="row">
        		<?php echo $form->labelEx($model,'basic_cost'); ?>
        		<?php echo $form->textField($model,'basic_cost'); ?>
        		<?php echo $form->error($model,'basic_cost'); ?>
        	</div>
            
            <div class="row">
        		<?php echo $form->labelEx($model,'basic_description'); ?>
        		<?php echo $form->textArea($model,'basic_description'); ?>
        		<?php echo $form->error($model,'basic_description'); ?>
        	</div>
        </fieldset>
        
        <fieldset>
            <legend>Расширенная часть</legend>
            <div class="row">
        		<?php echo $form->labelEx($model,'advanced_cost'); ?>
        		<?php echo $form->textField($model,'advanced_cost'); ?>
        		<?php echo $form->error($model,'advanced_cost'); ?>
        	</div>
            
            <div class="row">
        		<?php echo $form->labelEx($model,'adv_description'); ?>
        		<?php echo $form->textArea($model,'adv_description'); ?>
        		<?php echo $form->error($model,'adv_description'); ?>
        	</div>
        </fieldset>
        
        
    </fieldset>
    
    
    <?php echo $form->hiddenField($model, 'id', array('style'=>'display:none;')); ?>
    <div id="tabs" class="tabs">
    
        <ul>
            <li><a href="#tabs-1">Бесплатные</a></li>
            <li><a href="#tabs-2">Платные</a></li>
            <li><a href="#tabs-3">Расширенные</a></li>
        </ul>
    
        <div id="tabs-1" class="tab-content free-basic" blockType="<?=Course::BLOCK_TYPE_FREE_BASIC;?>">
            <div class="lessons">
                <?foreach($model->getFreeBasicLessons() as $lesson ):?>
                    <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                        <?=$lesson->name;?>
                        <a href='#' title='Удалить' class='removeButton'>&rarr;</a>
                    </div>
                <?endforeach;?>
            </div>
            <div class="sources">
                <a href="#">Прикрепить учебный материал</a>
            </div>
        </div>
        
        <div id="tabs-2" class="tab-content pay-basic" blockType="<?=Course::BLOCK_TYPE_PAY_BASIC;?>">
            <div class="lessons">
                <?foreach($model->getPaydBasicLessons() as $lesson ):?>
                    <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                        <?=$lesson->name;?>
                        <a href='#' title='Удалить' class='removeButton'>&rarr;</a>
                    </div>
                <?endforeach;?>
            </div>
            <div class="sources">
                <a href="#">Прикрепить учебный материал</a>
            </div>
        </div>
    
        <div id="tabs-3" class="tab-content advanced" blockType="<?=Course::BLOCK_TYPE_PAY_ADVANCED;?>">
            <div class="lessons">
                <?foreach($model->getPaydAdvancedLessons() as $lesson ):?>
                    <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                        <?=$lesson->name;?>
                        <a href='#' title='Удалить' class='removeButton'>&rarr;</a>
                    </div>
                <?endforeach;?>
            </div>
            <div class="sources">
                <a href="#">Прикрепить учебный материал</a>
            </div>
        </div>
        
    </div>
    
    <div class="lesson-list">
        <?foreach(Lesson::getAll() as $lesson):?>
            <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                <?=$lesson->name;?>
            </div>
        <?endforeach;?>
    </div>
    

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
        <?php echo CHtml::link('Отмена', $this->createUrl('/course/cancel', array('id'=>$model->id, 'operation'=>$operation))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->