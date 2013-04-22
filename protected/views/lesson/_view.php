
<div id="look_video">
    <div class="close_video" data-element="player-for-ajax-lesson-<?=$model->id?>"><a href="javascript:;"></a></div>
    <h2><?=$model->name?></h2>
    <div id="video_play">
        <?$isAvailable = $model->isAvailable();?>
        <?if($isAvailable):?>
            <div id="player-for-ajax-lesson-<?=$model->id?>" class="player" data-source="<?=$model->mediaUrl?>" data-image="<?=$model->poster?>"></div>
        <?else:?>
            <div style="width: 100%; height: 300px; background: #000;"></div>
        <?endif;?>
    </div>
    <div id="bord_under_video">
        <?if ($isAvailable):?>
            <div id="video_status">
                <div class="looks_video">
                    <?$userViews = ($model->isFree()) ? $model->views : $model->userViews;?>
                    Просмотров: <?=$userViews;?>
                    <span>(доступно еще <?=($model->isFree()) ? 'Неограниченно' : UserLessons::MAX_VIEWS_VALUE - $userViews;?>)</span>
                </div>
                <div class="enable_video">Действителен до: 11 декабря 2014 <span>(доступно еще 50)</span></div>
            </div>
            <form>
                <textarea class="blue-style">Комментарий к видео</textarea>
            </form>
            
            <div class="next_action">
                
                <div class="smm"> 
                    <span>Поделиться в</span>
                    <ul>
                        <li class="vk"><a href="javascript:void();"></a></li>
                        <li class="fb"><a href="javascript:void();"></a></li>
                        <li class="tw"><a href="javascript:void();"></a></li>
                        <li class="gl"><a href="javascript:void();"></a></li>
                        <li class="pf"><a href="javascript:void();"></a></li>
                        <li class="in"><a href="javascript:void();"></a></li>
                    </ul>
                </div>
                <div id="next_lesson">
                    <a href="javascript:void();"></a>
                </div>
            </div>
        <?endif;?>
       
    </div>
</div>