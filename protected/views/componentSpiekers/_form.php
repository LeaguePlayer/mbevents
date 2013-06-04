<?php
?>

<div class="form">

    <fieldset id="speakers">
        <legend>Спикеры</legend>
        <? foreach($model->getSpiekers() as $spieker): ?>
            <div class="one_spieker">
                <? $this->renderPartial('_spieker', array('model'=>$spieker)); ?>
                <div class="operations">
                    <a class="remove_spieker" href="javascript:;" data-id="<?=$spieker->id?>">Удалить</a>
                </div>
            </div>
        <? endforeach; ?>
    </fieldset>

    <div id="newspieker_wrap">
        <ul class="nav">
            <li><a class="add_spieker" href="<?=$this->createUrl('/componentSpiekers/addSpieker')?>">Добавить спикера</a></li>
            <li>
                <a class="select_spieker" href="javascript:;">Выбрать спикера</a>
                <span class="select" style="display: none;">
                    <?php $spiekers = Spiekers::model()->findAll(); ?>
                    <?php echo CHtml::dropDownList('change_spieker', 'id', CHtml::listData($spiekers, 'id', 'fio')); ?>
                    <a class="add_spieker" href="<?=$this->createUrl('/componentSpiekers/addSpieker')?>" data-id="<?=$spiekers[0]->id?>">Ок</a>
                </span>
            </li>
        </ul>
        
        <div id="newspieker_form" style="display: none;">
            <?=$this->renderPartial('_spieker_form', array('model'=>new Spiekers));?>
        </div>
    </div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'component_spiekers-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->hiddenField($model, 'spieker_ids'); ?>
    </div>
    
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