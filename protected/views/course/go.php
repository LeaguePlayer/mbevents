
    <article id="anonce" class="white-box" style="padding-bottom: 15px;">
        <h1>Учебный курс «<?=$model->title?>»</h1>
    
        <div class="body">
            <p><?=$model->description;?></p>
        </div>
        
        <div class="dotted_block">
            <div id="scissors"></div>
            <div class="white_space">
                <a href="javascript:void();">Купленных уроков (<?=$model->countAvailableLessons?> из <?=5?>)</a>
            </div>
        </div>
        
        <div class="body end_element">
            <?if ( !empty($model->video_preview) ):?>
                <div class="preview">
                	<div class="play"></div>
                	<img src="images/tmp/anonce_img.jpg" alt=""/>
                </div>
            <?endif?>
            <div>
            	<p><?=$model->preview_description?></p>
            </div>
            <div class="clear"></div>
        </div>
        
        <h2 class="end_element">Что Вас интересует?</h2>
        <div id="list_angle"></div>
    </article>
    
    


    
    <div class="change_lessons">
        <div class="small_info_about_lessons">
            <div class="caption">Базовый курс</div>
            <div class="about_lesson_text">
                <?//=$model->basic_description;?>
            </div>
            <div class="enter_in_lesson">Что входит в курс:</div>
            <ul>
                <li><?=$model->getBasicLessonsCount()?> видеосессий</li>
                <li><?=$model->getTotalBasicSourcesCount();?> PDF-файлов<?//=Functions::plurar($model->getCountSources('basic'), array('файл','файла','файлов'));?></li>
                
            </ul>
            <a class="blue_button look_about_lesson" href="#basic_block">Подробнее<span class="icon"></span></a>
        </div>
        
        <div class="small_info_about_lessons">
            <div class="caption">Расширенный курс</div>
            <div class="about_lesson_text">
                <!--<p>Состоит из 21 урока и включает в себя 7 базовых разделов и  14 дополнительных. Программа курса освещает все аспекты технологии, необходимые эксперту-профессионалу в продажах.
С целью получения наибольшего эффекта от обучения к данному курсу предоставляется специально разработанная Брайаном рабочая тетрадь, которую Вы можете распечатать и заполнять в процессе обучения.</p>
                <?//=$model->adv_description;?>
                -->
            </div>
            <div class="enter_in_lesson">Что входит в курс:</div>
            <ul>
                <li><?//=$model->getAdvLessonsCount()?>21 видеоурок</li>
                <li><?//=$model->getTotalAdvancedSourcesCount()?>21 PDF-файл<?//=Functions::plurar($model->getCountSources('advanced'), array('файл','файла','файлов'));?></li>
                
            </ul>
            <a class="blue_button look_about_lesson" href="#basic_block">Подробнее<span class="icon"></span></a>
            <div class="about_lesson_text" style="display: none;">
                <p style="margin: 10px 0;">Полное описание расширенного курса и видео-уроки появятся на сайте в ближайшее время</p>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    
    
    <article id="basic_block" class="white-box anonce">
        <h2>Базовый курс "Успех в продажах"</h2>
        
        <div class="block_description">
            <p><?=$model->getBasicLessonsCount()?> видеосессий, входящих в базовый курс:</p>
            <ul>
                <?foreach($model->freeBasicLessons as $lesson):?>
                    <li><?=$lesson->name?></li>
                <?endforeach;?>
                <?foreach($model->paydBasicLessons as $lesson):?>
                    <li><?=$lesson->name?></li>
                <?endforeach;?>
           </ul>
           <?=$model->basic_description;?>
           <a class="blue_button hide_block_description" href="#">Скрыть описание</a>
        </div>
        
        <div style="font-size: 24px; color: #BBBBBB; text-align: center; margin: 15px 0 20px; padding: 0 50px;">Сделайте вывод сами, посмотрите два первых видео-урока</div>
        
        <div class="change_lessons">
            <div class="how_to_see">
                <h2 class="caption">Рекомендации Брайана Трейси по обучению:</h2>
                
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
        
        <div class="create_line">
           <div class="im_line"></div>
        </div>
       
        <div class="video_block_for_look">
            <?foreach ($model->freeBasicLessons as $lesson):?>
                
                <div class="body its_video">
                    <div class="preview">
                    	<div class="play open_lesson" data-lesson_id="<?=$lesson->id?>" <?=( $lesson->status==Lesson::STATUS_FOR_REGISTERED && Yii::app()->user->isGuest ) ? 'data-closed="1"' : '' ?> ></div>
                        <div class="time"><?=date('j F', strtotime($lesson->date_public))?></div>
                    	<img src="<?=$lesson->poster?>" alt="" width="370" height="220"/>
                    </div>
                    
                    <div>
                        <div class="caption"><?=$lesson->name?></div>
                    	<p><?=$lesson->description?></p>
                    </div>
                    <div class="clear"></div>
                                    
                    <div class="actions_video">
            
                        <?foreach( $lesson->sources as $source ):?>
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
            <?endforeach;?>
        </div>
    </article>

    <? if ($model->acessLevel >= Course::BLOCK_TYPE_PAY_BASIC): ?>
    <?// если куплены платные уроки платного базового блока?>

        <?if(count($model->basicSources) > 0):?>
            <div class="materials_for_videoblock">
                <div class="small_desc">Материалы к базовому курсу:</div>
                <div class="materials_block">
                    <?foreach( $model->basicSources as $source ):?>
                        <div class="s_pdf">
                            <div class="s_image"></div>
                            <div class="s_text">
                                <a target="_blank" href="<?=$source->downloadUrl;?>"><?=( empty($source->name) ) ? 'Рабочие материалы к курсу' : $source->name;?></a>
                                <p><?=$source->getSize();?></p>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        <?endif;?>
        
        <article class="white-box anonce">
            <div class="video_block_for_look">
                <?foreach ($model->paydBasicLessons as $lesson):?>
                    <div class="body its_video">
                        <div class="preview">
                            <div class="play open_lesson" data-lesson_id="<?=$lesson->id?>"></div>
                            <div class="time"><?=date('j F', strtotime($lesson->date_public))?></div>
                            <img src="<?=$lesson->poster?>" alt="" width="370" height="220"/>
                        </div>
                        
                        <div>
                            <div class="caption"><?=$lesson->name?></div>
                            <p><?=$lesson->description?></p>
                        </div>
                        <div class="clear"></div>
                                        
                        <div class="actions_video">
                            <?foreach( $lesson->sources as $source ):?>
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
                <?endforeach;?>
            </div>
        </article>
    <?else:?>
    <?// если не доступны?>
        <div class="block_for_sell">
            <form class="invite_to_buy">
                <div class="caption">Базовый курс "Успех в продажах"</div>
                <input name="BuyForm[course_id]" type="hidden" style="display: none;" value="<?=$model->id?>" />
                <input name="BuyForm[block_type]" type="hidden" style="display: none;" value="<?=Course::BLOCK_TYPE_PAY_BASIC?>" />
                
                <a class="blue_button pay_course" data-user-autorized="<?=!Yii::app()->user->isGuest?>" data-course-id="<?=$model->id?>" data-course-type="<?=Course::BLOCK_TYPE_PAY_BASIC?>" href="http://tracyacademy01.ticketforevent.com" target="_blank">Купить курс</a>
                
                <button class="blue_button show_in_cart" type="submit">Ввести промо-код</button>
                <!--<button class="blue_button pay_course" type="submit">Купить</button>-->
            </form>
            <div class="top_part"></div>
                <div class="middle_part">
                    <div class="content_block_for_sell">
                        <div class="video_blocks_for_sell">
                            <?foreach ($model->getPaydBasicLessons() as $lesson):?>
                                <div class="video_block">
                                    <div class="preview">
                                        <div class="play"></div>
                                        <div class="time"><?=date('j F', strtotime($lesson->date_public))?></div>
                                        <img alt="" src="<?=$lesson->poster?>" width="220" height="128"/>
                                    </div>
                                    <div class="link_on_buy">
                                        <a class="" href="javascript:;"><?=$lesson->name?></a>
                                    </div>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
            <div class="bottom_part"></div>
            <div class="in_cart">
                <a class="show_in_cart" href="javascript:void();"></a>
            </div>
        </div>
    <?endif;?>
    
    <!--
    <h2 class="clone_h2">Расширенный курс</h2>
       <div class="create_line">
           <div class="im_line"></div>
       </div>
    
    <div class="block_for_sell">
        <form class="invite_to_buy">
            <div class="caption">Платная часть курсов за 10000 рублей</div>
            <input class="buy_lessons" type="submit" />
        </form>
        <div class="top_part"></div>
        <div class="middle_part">
            <div class="content_block_for_sell">
                <div class="small_desc">БАЗОВЫЙ КУРС +</div>
                
                <div class="video_blocks_for_sell">
                    <?//foreach ($model->getPaydAdvancedLessons() as $lesson):?>
                        <div class="video_block">
                            <div class="preview">
                                <div class="play"></div>
                                <div class="time">12 апреля</div>
                                <img alt="" src="images/tmp/small_bruce.png">
                            </div>    
                            <div class="link_on_buy">
                                <a href="<?//=$lesson->url;?>"><?//=$lesson->name?></a>
                            </div>
                        </div>
                    <?//endforeach;?>
                </div>
            </div>
        </div>
        <div class="bottom_part"></div>
        <div class="in_cart">
            <a href="javascript:void();"></a>
        </div>
    </div>
    -->