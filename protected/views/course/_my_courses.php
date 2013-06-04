

<div id="mycourses" class=" white-box">
    <h1>Мои видеокурсы</h1>
    <div class="relative" style="position: relative;">
        <div class="categories">
            <h3>Выберите категорию:</h3>
            <ul>
                <? foreach (Category::model()->findAll() as $category): ?>
                    <li><a href="<?=$this->createUrl('/course/my', array('cat'=>$category->id))?>"><?=$category->name?></a></li>
                <? endforeach; ?>
                <li><a href="<?=$this->createUrl('/course/my')?>">ВСЕ</a></li>
            </ul>
        </div>
        <div class="left_arrow"></div>
        <div class="right_arrow"></div>
    </div>
    <?
        $currentCat = 0;
    ?>
    <? foreach ($courses as $course): ?>
        <? if ($currentCat != $course->category->id): ?>
            <h2><?=$course->category->name;?></h2>
            <?
                $currentCat = $course->category->id;
            ?>
        <? endif; ?>
        <div class="anonce">
            <div class="body its_video">
                <div class="preview">
                    <? if ($course->isNew()): ?>
                        <div class="new_course"></div>
                    <? endif; ?>
                    <?
                        $freeLessons = $course->getFreeBasicLessons();
                        $currLesson = $freeLessons[0];
                    ?>
                	<div class="play open_lesson" data-lesson_id="<?=$currLesson->id?>"></div>
                    <div class="time"><?=date('j F', strtotime($currLesson->date_public))?></div>
                	<img src="<?=$currLesson->poster?>" alt="" width="370" height="220"/>
                </div>
                <div>
                    <div class="caption"><?=$course->title?></div>
                	<p><?=Functions::extractIntro($course->preview_description, 300);?></p>
                </div>
                <div class="clear"></div>
                <div class="course_statistic">
                    <label>Просмотрено уроков:  </label>
                    <ul class="progress">
                        <? $fillCount = $course->getViewedLessonsCount(); ?>
                        <? for ($i = 0; $i < $course->getTotalLessonsCount(); $i++): ?>
                            <li <? if ($i < $fillCount) echo 'class="fill"'; ?>></li>
                        <? endfor; ?>
                    </ul>
                    <span class="numeric">
                        <span class="viewed"> <?=$fillCount?></span>/
                        <span class="all"><?=$course->getTotalLessonsCount();?></span>
                    </span>
                </div>
                <a href="<?=$course->url?>" class="play_course">Посмотреть весь курс</a>
            </div>
        </div>
    <? endforeach; ?>
</div>

<article id="basic_block" class="white-box anonce">
    <h2>Недавно просмотренные видеосессии</h2>
    <div class="video_block_for_look">
        <?foreach ($outLessons as $lesson):?>
            <? $this->renderPartial('/lesson/_lesson', array('model'=>$lesson)); ?>
        <?endforeach;?>
    </div>
</article>