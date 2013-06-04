

<div class="white-box">
    
	<div id="registration-on-event">
		<h2><?=$model->title;?></h2>
        <div class="event_form form">
            <? $view = $disableSubmit ? '_disabledForm' : '_eventform'; ?>
            <? $this->renderPartial($view, array('model'=>$eventForm)); ?>
        </div>
	</div>
    
</div>

<?php

//    Yii::app()->clientScript->registerScript('reg_on_event', "
//        $('#registration-on-event .reserve').click(function() {
//            alert(1);
//        });
//    ", CClientScript::POS_LOAD);
    
?>