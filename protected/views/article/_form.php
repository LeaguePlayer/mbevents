<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form stat">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    ),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
        <div class="row_values">
            <?=$model->getImage(380);?>
            <?php
                $this->widget('CMultiFileUpload', array(
                    'model'=>$model,
                    'attribute'=>'image',
                    'name'=>'image',
                    'accept'=>'jpg|gif|png',
                    //'maxSize' => 5 * (1024 * 1024),
                    'max'=>1,
                    'duplicate'=>'Этот файл уже выбран',
                    'denied'=>'Неподдерживаемый формат файла',
                ));
            ?>
    		<?php echo $form->error($model,'image'); ?>
        </div>
	</div>
    
    <fieldset>
        <label>Категории</label>
        <div class="row_values">
        <?php
            $allCategories = Category::model()->findAll();
            foreach ($allCategories as $category) {
                $checked = $model->belongsToCategory($category->id);
                echo CHtml::checkBox("Article[categories][{$category->id}]", $checked);
                echo CHtml::label($category->name, 'Article_categories_'.$category->id);
            }
        ?>
        </div>
    </fieldset>

	<div class="row">
		<?php echo $form->labelEx($model,'short_description'); ?>
		<?php echo $form->textArea($model,'short_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'short_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'full_description'); ?>
		<?php
        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'full_description',
            // Optional config
            //'compressorRoute' => '/tinyMce/compressor',
            //'spellcheckerUrl' => array('tinyMce/spellchecker'),
            // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
            //'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
            'settings'=>array(
                'content_css' => $this->getAssetsBase().'/css/style.css',
            ),            
            'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                'connectorRoute'=>'/elfinder/connector',
            ),
            'htmlOptions' => array(
                'rows' => 6,
                'cols' => 60,
            ),
        ));
        ?>
		<?php echo $form->error($model,'full_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_public'); ?>
        <?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',array(
            'model'=>$model,
            'attribute'=>'date_public',
            'language'=>'ru',
            // additional javascript options for the date picker plugin
            'options'=>array(
                'showAnim'=>'fold',
            ),
            'htmlOptions'=>array(
            ),
        ));
        ?>
		<?php echo $form->error($model,'date_public'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textArea($model,'tags',array('rows'=>1, 'cols'=>50)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>
    
    
    <fieldset>
        <legend>Параметры рассылки</legend>
            
        <div class="row">
    		<?php echo $form->checkBox($model,'send_notifyces'); ?>
            <?php echo $form->labelEx($model,'send_notifyces'); ?>
            <p class="note">Этот параметр будет проигнорирован для статьи со статусом "Черновик"</p>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'subject_message'); ?>
    		<?php echo $form->textField($model,'subject_message',array('size'=>60,'maxlength'=>255)); ?>
    	</div>
        
        <div class="row">
    		<?php echo $form->labelEx($model,'notification_message'); ?>
    		<?php
            $this->widget('ext.tinymce.TinyMce', array(
                'model' => $model,
                'attribute' => 'notification_message',
                // Optional config
                //'compressorRoute' => '/tinyMce/compressor',
                //'spellcheckerUrl' => array('tinyMce/spellchecker'),
                // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
                //'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
                'settings'=>array(
                    'content_css' => $this->getAssetsBase().'/css/style.css',
                ),
                'fileManager' => array(
                    'class' => 'ext.elFinder.TinyMceElFinder',
                    'connectorRoute'=>'/elfinder/connector',
                ),
                'htmlOptions' => array(
                    'rows' => 6,
                    'cols' => 60,
                ),
            ));
            ?>
    	</div>
    </fieldset>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Article::statuses()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
                <button type="submit" name="Article[status]" value="<?=Article::STATUS_SHARED_ACCESS?>">Опубликовать</button>
                <button type="submit" name="Article[status]" value="<?=Article::STATUS_DRAFT?>">Сохранить</button>
                <a href="<?=$this->createUrl('/article/admin')?>">Отмена</a>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->