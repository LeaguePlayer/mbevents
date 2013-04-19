<?php
/* @var $this AnnounceController */
/* @var $model Announce */

//$this->breadcrumbs=array(
//	'Announces'=>array('index'),
//	$model->id,
//);

//$this->menu=array(
//	array('label'=>'List Announce', 'url'=>array('index')),
//	array('label'=>'Create Announce', 'url'=>array('create')),
//	array('label'=>'Update Announce', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Announce', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Announce', 'url'=>array('admin')),
//);
?>
<?php echo CHtml::activeHiddenField($model, 'id'); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'announce-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->textField($model, 'title', array('class'=>'title')); ?>
    
    <div id="components_panel">
        <?php foreach ($model->components as $component): ?>
            <div id="component-<?=$component->id.'_'.$component->getTypeId();?>" class="component_container">
                <?php $component->render(); ?>
                <a href="javascript:;" class="delete_component" component_id="<?=$component->id;?>" component_type="<?=$component->typeId;?>">Удалить</a>
                <a href="<?=$this->createUrl('/announceComponent/update', array(
                    'id'=>$component->id,
                    'typeId'=>$component->getTypeId(),
                    'backUrl'=>Yii::app()->request->url
                ));?>" class="update_component">Редактировать</a>
            </div>
        <?php endforeach; ?>
        
        <div class="component_container empty" style="display: none;">
            <div id="select_component_box">
                <h3>Выберите тип компонента</h3>
                <?php echo CHtml::dropDownList('', '', AnnounceComponent::getTypeNames(), array('id'=>'selected_type')); ?>
                <br />
                <a href="javascript:;" class="accept" url="<?=$this->createUrl('/announceComponent/create')?>">Ок</a>
                <a href="javascript:;" class="cancel">Отмена</a>
            </div>
        </div>
        
        <div class="component_container new">
            <a class="add_component" href="#select_component_box">Добавить копонент</a>
        </div>
    </div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
        <?php echo CHtml::link( ($operation == 'new') ? 'Отмена' : 'Назад', $this->createUrl('/announce/cancel', array('announceId'=>$model->id, 'operation'=>$operation))); ?>
    </div>

<?php $this->endWidget();