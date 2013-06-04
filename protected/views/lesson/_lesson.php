<div class="body its_video">
    <div class="preview">
    	<div class="play open_lesson" data-lesson_id="<?=$model->id?>" <?=( $model->status==Lesson::STATUS_FOR_REGISTERED && Yii::app()->user->isGuest ) ? 'data-closed="1"' : '' ?> ></div>
        <div class="time"><?=date('j F', strtotime($model->date_public))?></div>
    	<img src="<?=$model->poster?>" alt="" width="370" height="220"/>
    </div>
    
    <div>
        <div class="caption"><?=$model->name?></div>
    	<p><?=$model->description?></p>
    </div>
    <div class="clear"></div>
                    
    <div class="actions_video">

        <?foreach( $model->sources as $source ):?>
            <div class="s_pdf">
                <div class="s_image"></div>
                <div class="s_text">
                    <a target="_blank" href="<?=$source->downloadUrl;?>"><?=( empty($source->name) ) ? 'Рабочие материалы к сессии' : $source->name;?></a>
                    <p><?=$source->getSize();?></p>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>