

<div>Купленных уроков (<?=$model->countAvailableLessons?> из <?=$model->countLessons()?>)</div>

<?if ( !empty($model->video_preview) ):?>
    <div id="course-preview-<?=$model->id?>" class="player" source="<?=$model->video_preview?>"></div>
<?endif;?>
<div class="description">
    <?=$model->description;?>
</div>

<div class="course_map">
    <div class="basic_map">
        <h3>Базовый курс</h3>
        <ul>
            <li><?=$model->countLessons(array('scopes'=>'pay_basic'))?> видео-уроков</li>
        </ul>
        <div><?=$model->basic_description;?></div>
    </div>
    <div class="adv_map">
        <h3>Расширенный курс</h3>
        <ul>
            <li><?=$model->countLessons(array('scopes'=>'pay_advanced'))?> видео-уроков</li>
        </ul>
        <div><?=$model->adv_description;?></div>
    </div>
</div>


<div class="basic_part">
    <h1>Базовый курс</h1>
    <?foreach ($model->freeBasicLessons as $lesson):?>
        <a href="<?=$lesson->url;?>"><?=$lesson->url;?></a>
        
        <div id="player-for-lesson-<?=$lesson->id?>" class="player" source="<?=$lesson->url;?>"></div>
        <div class="description"><?=$lesson->description?></div>
    <?endforeach;?>
</div>