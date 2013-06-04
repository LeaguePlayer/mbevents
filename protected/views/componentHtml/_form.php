<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'component_html-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">    
		<?php echo $form->labelEx($model,'description'); ?>
		<?php
        
        $this->widget('ext.tinymce.TinyMce', array(
            'model' => $model,
            'attribute' => 'description',
            //'compressorRoute' => '/tinyMce/compressor',
            'settings' => array(
                'content_css'=>$this->getAssetsBase().'/css/style.css',
                'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview",
                'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,spellchecker",
                'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor",
            ),
            'fileManager' => array(
                'class' => 'ext.elFinder.TinyMceElFinder',
                'connectorRoute'=>'/elfinder/connector',
            ),
        ));
        ?>
		<?php echo $form->error($model,'descripion'); ?>
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