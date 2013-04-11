<?php
/* @var $this ArticleController */
/* @var $model Article */
/* @var $form CActiveForm */
?>

<div class="form">

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
    
    <fieldset>
        <legend>Категории</legend>
        <?php
            $allCategories = Category::getAll();
            foreach ($allCategories as $category) {
                $checked = $model->belongsToCategory($category->id);
                echo CHtml::label($category->name, 'Article_categories_'.$category->id);
                echo CHtml::checkBox("Article[categories][{$category->id}]", $checked);
            }
        ?>
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
            'compressorRoute' => '/tinyMce/compressor',
            'spellcheckerUrl' => array('tinyMce/spellchecker'),
            // or use yandex spell: http://api.yandex.ru/speller/doc/dg/tasks/how-to-spellcheck-tinymce.xml
            //'spellcheckerUrl' => 'http://speller.yandex.net/services/tinyspell',
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

    <fieldset>
        <legend>Изображение</legend>
        <div class="row">
    		<?php echo $form->labelEx($model,'image'); ?>
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
    </fieldset>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textArea($model,'tags',array('rows'=>1, 'cols'=>50)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Article::statuses()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->