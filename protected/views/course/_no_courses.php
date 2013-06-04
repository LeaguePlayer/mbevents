
<div id="mycourses" class=" white-box">
    <h1>Мои видеокурсы</h1>
    <div class="relative" style="position: relative;">
        <div class="empty_message">
            <div>Купленных видекурсов нет</div>
        </div>
        <div class="left_arrow red"></div>
        <div class="right_arrow red"></div>
    </div>
</div>

<article id="basic_block" class="white-box anonce">
    <h2>Самые просматриваемые сессии</h2>
    <div class="video_block_for_look">
        <?foreach ($outLessons as $lesson):?>
            <? $this->renderPartial('/lesson/_lesson', array('model'=>$lesson)); ?>
        <?endforeach;?>
    </div>
</article>