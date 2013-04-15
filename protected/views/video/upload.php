<?php
/* @var $this VideoController */
/* @var $model Video */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'video-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="row">
		<?php
            $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                'id'=>'uploadFile',
                'config'=>array(
                    'action'=>Yii::app()->createUrl('/video/ajaxUpload'),
                    'allowedExtensions'=>array("flv","avi","mpeg","mp4"),//array("jpg","jpeg","gif","exe","mov" and etc...
                    'sizeLimit'=>1000*1024*1024,// maximum file size in bytes
                    'minSizeLimit'=>1*1024*1024,// minimum file size in bytes
                    'onComplete'=>"js:function(id, fileName, responseJSON){
                        jQuery('#file-grid').yiiGridView('update');
                    }",
                    'messages'=>array(
                                      'typeError'=>"{file} имеет неизвестное расширение. Разрешены следующие расширения: {extensions}.",
                                      'sizeError'=>"размер файла {file} превышает предельно допустимую величину {sizeLimit}.",
                    //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
                    //                  'emptyError'=>"{file} is empty, please select files again without it.",
                    //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                     ),
                    'showMessage'=>"js:function(message){ alert(message); }"
                )
            ));
        ?>
	</div>

<?php $this->endWidget(); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'file-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
            'name' => 'Имя файла',
            'value' => '$data["name"]'
        ),
        array(
            'name' => 'Размер файла',
            'value' => '$data["size"]'
        ),
	),
));
?>

</div><!-- form -->