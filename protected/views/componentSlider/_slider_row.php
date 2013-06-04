

    <div class="row">
		<?php echo CHtml::label('Путь к файлу', ''); ?>
		<?php $this->widget('ext.elFinder.ServerFileInput', array(
            'model'=>$model,
            'attribute'=>'source',
            'name'=>'ComponentSlider[slides][]',
            //'path' => '/uploads', // path to your uploads directory, must be writeable 
            //'url' => 'http://mbevents.loc/uploads/', // url to uploads directory 
            //'action' => $this->createUrl('/elfinder/connector') // the connector action (we assume we are pasting this code in the sitecontroller view file)
            'connectorRoute'=>'/elfinder/connector',
            'htmlOptions'=>array(
                'style'=>'',
                //'data-attribute'=>'photo',
            ),
            'contHtmlOptions'=>array(
                'style'=>'display:inline-block;'
            ),
        )); ?>
		<?php echo CHtml::error($model,'source'); ?>
	</div>