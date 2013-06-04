
<div class="reg-event-form">
    <? $labels = $model->attributeLabels(); ?>

    <div class="row">
		<?php echo CHtml::label($labels['name'], ''); ?>
		<?php echo CHtml::activeTextField($model, 'name'); ?>
        <?php echo CHtml::error($model, 'name'); ?>
	</div>
    
    <div class="row">
		<?php echo CHtml::label($labels['phone'], ''); ?>
		<?php echo CHtml::activeTextField($model, 'phone'); ?>
        <?php echo CHtml::error($model, 'phone'); ?>
	</div>
    
    <div class="row">
		<?php echo CHtml::label($labels['company'], ''); ?>
		<?php echo CHtml::activeTextField($model, 'company'); ?>
        <?php echo CHtml::error($model, 'company'); ?>
	</div>
    
    <div class="row">
		<?php echo CHtml::label($labels['email'], ''); ?>
		<?php echo CHtml::activeTextField($model, 'email'); ?>
        <?php echo CHtml::error($model, 'email'); ?>
	</div>
    
    <div class="row">
		<?php echo CHtml::label($labels['job'], ''); ?>
		<?php echo CHtml::activeTextField($model, 'job'); ?>
        <?php echo CHtml::error($model, 'job'); ?>
	</div>
    
    <!--
    <div class="row">
		<?php //echo CHtml::labelEx($model, 'secretkey'); ?>
		<?php //echo CHtml::textField($model, 'secretkey'); ?>
        <?php //echo CHtml::error($model, 'secretkey'); ?>
	</div>
    -->
    
    <div class="clear"></div>
    
	<div>
        <a class="reserve" href="javascript:;">Забронировать</a>
		<div class="clear"></div>
	</div>
 </div>