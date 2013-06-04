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

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model, 'id', array('style'=>'display:none;')); ?>

    <fieldset>
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
    		<?php echo $form->labelEx($model,'description'); ?>
    		<?php
            $this->widget('tinymce.TinyMce', array(
                'model' => $model,
                'attribute' => 'description',
                'settings' => array(
                    'content_css'=>$this->getAssetsBase().'/css/style.css',
                    'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                    'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
                    'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor",
                ),
                'fileManager' => array(
                    'class' => 'ext.elFinder.TinyMceElFinder',
                    'connectorRoute'=>'/elfinder/connector',
                ),
            ));
            ?>
    		<?php echo $form->error($model,'description'); ?>
    	</div>
        <div class="row buttons">
    		<?php echo CHtml::submitButton('Сохранить'); ?>
            <?php echo CHtml::link('Отмена', $this->createUrl('/course/cancel', array('id'=>$model->id, 'operation'=>$operation))); ?>
    	</div>
    </fieldset>
    
    <fieldset>
        <legend>Видео-обращение</legend>
        <div class="row">
    		<?php echo $form->labelEx($model,'video_preview'); ?>
    		<?php echo $form->textField($model,'video_preview',array('cols'=>60,'maxlength'=>255)); ?>
    		<?php echo $form->error($model,'video_preview'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'preview_description'); ?>
    		<?php
            $this->widget('ext.tinymce.TinyMce', array(
                'model' => $model,
                'attribute' => 'preview_description',
                'settings' => array(
                    'content_css'=>$this->getAssetsBase().'/css/style.css',
                    'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                    'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
                    'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor",
                ),
                'fileManager' => array(
                    'class' => 'ext.elFinder.TinyMceElFinder',
                    'connectorRoute'=>'/elfinder/connector',
                ),
            ));
            ?>
    		<?php echo $form->error($model,'preview_description'); ?>
    	</div>
        <div class="row buttons">
    		<?php echo CHtml::submitButton('Сохранить'); ?>
            <?php echo CHtml::link('Отмена', $this->createUrl('/course/cancel', array('id'=>$model->id, 'operation'=>$operation))); ?>
    	</div>
    </fieldset>
        
    <fieldset>
        <legend>Базовая часть</legend>
        <div class="row">
    		<?php echo $form->labelEx($model,'basic_cost'); ?>
    		<?php echo $form->textField($model,'basic_cost'); ?>
    		<?php echo $form->error($model,'basic_cost'); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'basic_description'); ?>
    		<?php
            $this->widget('ext.tinymce.TinyMce', array(
                'model' => $model,
                'attribute' => 'basic_description',
                'settings' => array(
                    'content_css'=>$this->getAssetsBase().'/css/style.css',
                    'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                    'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
                    'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor",
                ),
                'fileManager' => array(
                    'class' => 'ext.elFinder.TinyMceElFinder',
                    'connectorRoute'=>'/elfinder/connector',
                ),
            ));
            ?>
    		<?php echo $form->error($model,'basic_description'); ?>
    	</div>
        <div class="row buttons">
    		<?php echo CHtml::submitButton('Сохранить'); ?>
            <?php echo CHtml::link('Отмена', $this->createUrl('/course/cancel', array('id'=>$model->id, 'operation'=>$operation))); ?>
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
    		<?php
            $this->widget('ext.tinymce.TinyMce', array(
                'model' => $model,
                'attribute' => 'adv_description',
                'settings' => array(
                    'content_css'=>$this->getAssetsBase().'/css/style.css',
                    'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                    'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                    'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
                    'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor",
                ),
                'fileManager' => array(
                    'class' => 'ext.elFinder.TinyMceElFinder',
                    'connectorRoute'=>'/elfinder/connector',
                ),
            ));
            ?>
    		<?php echo $form->error($model,'adv_description'); ?>
    	</div>
        <div class="row buttons">
    		<?php echo CHtml::submitButton('Сохранить'); ?>
            <?php echo CHtml::link('Отмена', $this->createUrl('/course/cancel', array('id'=>$model->id, 'operation'=>$operation))); ?>
    	</div>
    </fieldset>
    
    <fieldset>
        <legend>Распределение уроков</legend>
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
    </fieldset>
    

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
        <?php echo CHtml::link('Отмена', $this->createUrl('/course/cancel', array('id'=>$model->id, 'operation'=>$operation))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->