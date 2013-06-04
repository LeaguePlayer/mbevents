<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
    //array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    //array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    //array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    //array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Назад'), 'url'=>array('/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

Yii::app()->clientScript->registerScript('changeStatus', "
function changeStatus() {
    $('select[id|=UserStatus]').change(function() {
        var self = $(this);
        var thisId = self.data('id');
        $.ajax({
            type: 'POST',
            url: '".$this->createUrl('/user/admin/changeStatus')."',
            data: {
                UserModeration: {
                    id: thisId,
                    value: self.val(),
                }
            },
            dataType: 'json',
        });
    });
}
changeStatus();
");

?>
<h1><?php echo UserModule::t("Зарегестрированные пользователи"); ?></h1>

<p><?php echo UserModule::t("You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done."); ?></p>

<?php echo CHtml::link(UserModule::t('Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate'=>'changeStatus',
    'rowHtmlOptionsExpression' => function($row, $data) {
        $class = empty( $row['htmlOptions']['class'] ) ? '' : $row['htmlOptions']['class'];
        if ( $data->status == User::STATUS_ACTIVE ) {
            return array(
                'class' => 'active '.$class,
            );
        }
        return array();
    },
	'columns'=>array(
//		array(
//			'name' => 'id',
//			'type'=>'raw',
//			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
//		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
		),
		'create_at',
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>User::itemAlias("AdminStatus"),
		),
        array(
            'header' => 'Ссылка на соц сеть',
            'type' => 'raw',
            'value' => 'CHtml::link($data->profile->verify_link, $data->profile->verify_link, array("target"=>"_blank"))',
            'filter' => CHtml::textField("User[verify_link]", $data->profile->verify_link),
        ),
        array(
            'header' => 'Промо-код',
            'type' => 'raw',
            'value' => '$data->promocodes[0]->code',
        ),
        array(
            'header' => 'Дата активации промо-кода',
            'type' => 'raw',
            'value' => '$data->promocodes[0]->use_date ? date("d F Y", strtotime($data->promocodes[0]->use_date)) : ""',
        ),
        array(
			'name'=>'status',
            'type'=>'raw',
			'value'=>'CHtml::activeDropDownList($data, "status", User::itemAlias("UserStatus"), array("id"=>"UserStatus-".$data->id, "data-id"=>$data->id))',
			'filter' => User::itemAlias("UserStatus"),
		),
//		array(
//			'class'=>'CButtonColumn',
//		),
	),
)); ?>
