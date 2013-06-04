<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'component_slider-form',
	'enableAjaxValidation'=>true,
    'htmlOptions'=>array(
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
        <?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>60,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'position'); ?>
    </div>
    
    <fieldset>
        <legend>Слайды</legend>
        <? foreach ($model->slides as $item): ?>
            <div class="slide_item">
                <a class="remove_item" href="javascript:;" data-id="<?=$item->id?>">Удалить</a>
            <? echo $item->getThumb(370, 220); ?>
            </div>
        <? endforeach; ?>
    </fieldset>
    
    <div class="row">
        <?php $slide = new Slides; ?>
		<?php echo $form->labelEx($slide,'source'); ?>
        <div class="row_values">
            <?php
                $this->widget('CMultiFileUpload', array(
                    'model'=>$slide,
                    'attribute'=>'source',
                    'name'=>'ComponentSlider[sources][]',
                    'accept'=>'jpg|gif|png',
                    //'maxSize' => 5 * (1024 * 1024),
                    'max'=>20,
                    'duplicate'=>'Этот файл уже выбран',
                    'denied'=>'Неподдерживаемый формат файла',
                ));
            ?>
    		<?php echo $form->error($slide,'source'); ?>
        </div>
	</div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
        <?php
            if ( $backUrl != false ) {
                echo CHtml::link('Отмена', $backUrl);
            }
        ?>
	</div>

<?php $this->endWidget(); ?>
        
</div><!-- form -->