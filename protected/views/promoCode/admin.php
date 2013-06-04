<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */
?>

<?php


$this->menu=array(
	array('label'=>'Назад', 'url'=>array('/admin/index')),
	//array('label'=>'Для печати', 'url'=>array('index')),
);


Yii::app()->clientScript->registerScript('codegenerator', "
$('.generator-button').click(function(){
	$('.generator-form').toggle();
	return false;
});

//$('.delete-all').click(function(){
//	if ( confirm('Подтвердите удаление ВСЕХ кодов!') ) {
//        $.ajax({
//            url: '/promoCode/delete/all?ajax=1',
//            type: 'POST',
//            success: function() {
//                $('#promo-code-grid').yiiGridView('update');
//            }
//        });
//	}
//	return false;
//});

$('.generator-form form').submit(function() {
    $.ajax({
        url: '/promoCode/generate',
        type: 'POST',
        data: $(this).serialize(),
        success: function(data) {
            $('#promo-code-grid').yiiGridView('update');
            $('.generator-form').toggle();
        }
    });
	return false;
});

//$(.current_status).click(function() {
//    openContextMenu( $(this) );
//});
//
//var contextMenu = new ContextMenu();
//function openContextMenu( button ) {
//    
//}
//
//function ContextMenu = function() {
//    this.items = [];
//    
//}
");
?>
<!--
<div class="context_menu" style="">
    <ul>
        <?php foreach(PromoCode::getAllStatuses() as $key=>$status): ?>
            <li class="item" rel="<?=$key?>"><?=$status?></li>
        <?php endforeach; ?>
    </ul>
</div>
-->


<h1>Управление промо-кодами для доступа к видеоурокам</h1>


<?php echo CHtml::link('Генератор кодов...', '#', array('class'=>'generator-button')); ?>
<?php //echo CHtml::link('Удалить все...', '#', array('class'=>'delete-all', 'style'=>'margin-left: 20px;')); ?>

<div class="generator-form" style="display:none">
    <?php echo $this->renderPartial('_generator', array('model'=>new PromoCode('generate'))); ?>
</div>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'promo-code-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'code',
        array(
            'name'=>'expire',
            'type'=>'raw',
            'value'=>'($data->expire==0) ? "Не указано" : date("d.m.Y", $data->expire)'
        ),
		array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>'CHtml::link($data->getStatus(), "#", array("class"=>"current_status", "rel"=>$data->id))',
            'filter'=>PromoCode::getAllStatuses()
        ),
        array(
            'header'=>'Пользователь',
            'type'=>'raw',
            'value'=>'($data->status==$data::STATUS_USED) ? $data->user->email : "-"',
        ),
        array(
            'name'=>'use_date',
            'type'=>'raw',
            'value'=>'($data->status==$data::STATUS_USED) ? $data->getFormattedDate("use_date") : "-"'
        ),
//		array(
//			'class'=>'CButtonColumn',
//            'template'=>'{delete}',
//            'htmlOptions'=>array('width'=>'50px'),
//		),
	),
)); ?>
