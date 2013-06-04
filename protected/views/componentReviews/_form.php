<?php
?>

<div class="form">

    <fieldset id="reviews">
        <legend>Отзывы</legend>
        <? foreach($model->getReviews() as $review): ?>
            <div class="one_review">
                <? $this->renderPartial('_review', array('model'=>$review)); ?>
                <div class="operations">
                    <a class="remove_review" href="javascript:;" data-id="<?=$review->id?>">Удалить</a>
                </div>
            </div>
        <? endforeach; ?>
    </fieldset>

    <div id="newreview_wrap">
        <ul class="nav">
            <li><a class="add_review" href="<?=$this->createUrl('/componentReviews/addReview')?>">Добавить отзыв</a></li>
            <li>
                <a class="select_review" href="javascript:;">Выбрать отзыв</a>
                <span class="select" style="display: none;">
                    <?php $reviews = Reviews::model()->findAll(); ?>
                    <?php echo CHtml::dropDownList('change_review', 'id', CHtml::listData($reviews, 'id', 'fio')); ?>
                    <a class="add_review" href="<?=$this->createUrl('/componentReviews/addReview')?>" data-id="<?=$reviews[0]->id?>">Ок</a>
                </span>
            </li>
        </ul>
        
        <div id="newreview_form" style="display: none;">
            <?=$this->renderPartial('_review_form', array('model'=>new Reviews))?>
        </div>
    </div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'component_reviews-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->hiddenField($model, 'reviews_ids'); ?>
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