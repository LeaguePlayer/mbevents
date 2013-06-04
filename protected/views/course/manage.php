<?php
$this->menu=array(
	array('label'=>'Назад', 'url'=>array('admin')),
);
?>

<div class="form">
    <fieldset>
        <legend>Распределение уроков</legend>
        <?php echo CHtml::activeHiddenField($model, 'id', array('style'=>'display:none;')); ?>
        <div id="tabs" class="tabs">
            <ul>
                <li><a href="#tabs-1">Бесплатные</a></li>
                <li><a href="#tabs-2">Платные</a></li>
                <li><a href="#tabs-3">Расширенные</a></li>
            </ul>
            <div id="tabs-1" class="tab-content free-basic" blockType="<?=Course::BLOCK_TYPE_FREE_BASIC;?>">
                <div class="lessons">
                    <?foreach($model->getFreeBasicLessons() as $lesson ):?>
                        <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                            <?=$lesson->name;?>
                            <a href='#' title='Удалить' class='removeButton'>&rarr;</a>
                        </div>
                    <?endforeach;?>
                </div>
                <div class="sources">
                    <a href="#">Прикрепить учебный материал</a>
                </div>
            </div>
            <div id="tabs-2" class="tab-content pay-basic" blockType="<?=Course::BLOCK_TYPE_PAY_BASIC;?>">
                <div class="lessons">
                    <?foreach($model->getPaydBasicLessons() as $lesson ):?>
                        <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                            <?=$lesson->name;?>
                            <a href='#' title='Удалить' class='removeButton'>&rarr;</a>
                        </div>
                    <?endforeach;?>
                </div>
                <div class="sources">
                    <a href="#">Прикрепить учебный материал</a>
                </div>
            </div>
            <div id="tabs-3" class="tab-content advanced" blockType="<?=Course::BLOCK_TYPE_PAY_ADVANCED;?>">
                <div class="lessons">
                    <?foreach($model->getPaydAdvancedLessons() as $lesson ):?>
                        <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                            <?=$lesson->name;?>
                            <a href='#' title='Удалить' class='removeButton'>&rarr;</a>
                        </div>
                    <?endforeach;?>
                </div>
                <div class="sources">
                    <a href="#">Прикрепить учебный материал</a>
                </div>
            </div>
        </div>
        <div class="lesson-list">
            <? $lessons = Lesson::detached(); ?>
            <? if (count($lessons)==0): ?>
                <p>Нет уроков</p>
            <? endif; ?>
            <?foreach($lessons as $lesson):?>
                <div class="lesson-item" lessonId="<?=$lesson->id;?>">
                    <?=$lesson->name;?>
                </div>
            <?endforeach;?>
        </div>
    </fieldset>
</div>