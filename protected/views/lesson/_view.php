
<div id="look_video">
    <div class="close_video" data-element="player-for-ajax-lesson-<?=$model->id?>"><a href="javascript:;"></a></div>
    <h2><?=$model->name?></h2>
    <div id="video_play">
        <?$isAvailable = $model->isAvailable();?>
        <?if($isAvailable):?>
            <div id="player-for-ajax-lesson-<?=$model->id?>" class="player" data-source="<?=$model->mediaUrl?>" data-image="<?=$model->poster?>"></div>
        <?else:?>
            <div style="width: 100%; background: #EFEFEF; padding: 150px 0; text-align: center; font-size: 32px; color: #FA5454">Видео не доступно</div>
        <?endif;?>
    </div>
    <div id="bord_under_video">
        <?if ($isAvailable):?>
            <div id="video_status">
                <div class="looks_video">
                    Просмотров: <?=$model->getViewsCounter();?>
                    <span>(доступно еще <?=$model->getLeftViewsCounter();?>)</span>
                </div>
                <? if ( $model->getCloseDate() ): ?>
                    <div class="enable_video">Действителен до: <?=$model->getCloseDate();?></div>
                <? endif; ?>
            </div>
        <?endif;?>
        <div style="color: #F77B7B;font-size: 16px;font-weight: bold;line-height: 120%;padding: 0 30px;text-align: center;">
            Если у вас возникнут проблемы при воспроизведении видео-урока, воспользуйтесь браузером Mozilla Firefox или Opera. 
            В настоящий момент просмотр видео недоступен на переносных устройствах, работающих под управлением iOs (iPad, iPhone).
        </div>
        
        <a class="yellow_button_2 callback_button" href="#"><span class="icon"></span>Написать нам</a>
        <div class="clear"></div>
        
        <div class="change_lessons" style="margin-top: 0;">
            <div class="how_to_see">
                <h2 class="caption" style="font-size: 22px;">Рекомендации Брайана Трейси по обучению:</h2>
                
                <ul>
                    <li>Проведите оценку компетенций методом 360</li>
                    <li>Распечатайте рабочие материалы</li>
                    <li>
                        Выделите 45-60 минут в день на просмотр сессии и работу с материалами:
                        <ul>
                            <li>посмотрите одно видео</li>
                            <li>в рабочем материале отметьте тезисы, которые показались вам наиболее важными</li>
                            <li>письменно ответьте на вопросы в конце каждого раздела рабочих материалов</li>
                            <li>в течение 3-5 дней практикуйте, перечитывайте рабочие материалы и отмечайте то, что используете</li>
                        </ul>
                    </li>
                    <li>Переходите к работе по следующей сессии.</li>
                    <li>Через 30 дней после прохождения всего курса проведите заново оценку 360</li>
                </ul>
                <p class="citate">Никто не лучше вас. Никто не умнее вас. Они просто раньше начали. <span class="autor">Брайан Трейси</span></p>
                <div class="clear"></div>
            </div>
        </div>
        
        <?if ($isAvailable):?>
            
            <div class="form stat">
                <h3>Заметка к видео</h3>
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'action'=>$this->createUrl('/lesson/sendNote'),
                	'id'=>'lesson_note-form',
                	'enableAjaxValidation'=>false,
                ));
                    $note = new NoteForm;
                    $note->email = Yii::app()->user->isGuest ? '' : Yii::app()->user->email;
                    $note->lesson_id = $model->id;
                ?>
                    <?php echo $form->hiddenField($note,'lesson_id'); ?>
                
                    <div class="row">
                		<?php echo $form->textArea($note,'note', array('class'=>'blue-style')); ?>
                		<?php echo $form->error($note,'note'); ?>
                	</div>
                    <div class="right-rows">
                        <div class="row inline">
                            <button type="submit" class="blue_button submit">Отправить на email</button>
                        </div>
                        <div class="row inline">
                    		<?php echo $form->textField($note,'email'); ?>
                    		<?php echo $form->error($note,'email'); ?>
                    	</div>
                     </div>
                   
                    <div class="clear"></div>
        		<?php $this->endWidget(); ?>
            </div>
            
            <!--
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
            -->
        <?endif;?>
       
    </div>
    
</div>