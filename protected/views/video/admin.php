<?php
/* @var $this VideoController */
/* @var $model Video */
/* @var $form CActiveForm */
?>

<?php
//$form=$this->beginWidget('CActiveForm', array(
//	'id'=>'video-form',
//	'enableAjaxValidation'=>false,
//));
?>
		<?php
        $this->widget('xupload.XUpload', array(
            'url' => Yii::app()->createUrl("video/upload"),
            'model' => $model,
            'attribute' => 'file',
            'multiple' => true,
            'registerBootstrap'=>true,
        ));
        
            /*$this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                'id'=>'uploadFile',
                'config'=>array(
                    'action'=>Yii::app()->createUrl('/video/ajaxUpload'),
                    'allowedExtensions'=>array("flv","avi","mpeg","mp4"),
                    'sizeLimit'=>1000*1024*1024,
                    'minSizeLimit'=>1*1024*1024,
                    'onComplete'=>"js:function(id, fileName, responseJSON){
                        jQuery('#file-grid').yiiGridView('update');
                    }",
//                    'messages'=>array(
//                                      'typeError'=>"{file} имеет неизвестное расширение. Разрешены следующие расширения: {extensions}.",
//                                      'sizeError'=>"размер файла {file} превышает предельно допустимую величину {sizeLimit}.",
//                                      'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
//                                      'emptyError'=>"{file} is empty, please select files again without it.",
//                                      'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
//                                     ),
//                    'showMessage'=>"js:function(message){ alert(message); }"
                )
            ));*/
        ?>

<?php
    //$this->endWidget();
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'file-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
            'name' => 'Имя файла',
            'type' => 'raw',
            'value' => 'CHtml::link($data["name"], Yii::app()->urlManager->createUrl( "/video/out", array("alias"=>$data["name"])) )'
        ),
        array(
            'name' => 'Размер файла',
            'value' => '$data["size"]'
        ),
	),
));
?>

<div id="demo"></div>

<script>
    $(document).ready(function() {
        jwplayer('demo').setup({
            file: '/video/out/f_003dd8.flv',
            provider: 'video',
            write: 'mediaspace',
        });
    });
</script>
                                     

