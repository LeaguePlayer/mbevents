


<section id="main-block">
    <article id="anonce" class="white-box">
        <div class="body">
            <p><?=$model->description;?></p>
        </div>
        
        <h1><?=$model->title;?></h1>
        
        <div class="dotted_block">
            <div id="scissors"></div>
            <div class="white_space">
                <a href="javascript:void();">Купленных уроков (<?=$model->countAvailableLessons?> из <?=$model->countLessons()?>)</a>
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
            <?
                $countBasicLessons = $model->countLessons(array('scopes'=>'free_basic')) + $model->countLessons(array('scopes'=>'pay_basic'));
            ?>
            <div class="caption">Базовый курс</div>
            <div class="about_lesson_text">
                <?=$model->basic_description;?>
            </div>
            <div class="enter_in_lesson">Что входит в курс:</div>
            <ul>
                <li><?=$countBasicLessons?> видеоуроков</li>
                <li><?=$model->getCountSources('basic');?> PDF-<?=Functions::plurar($model->getCountSources('basic'), array('файл','файла','файлов'));?></li>
                <li>Мастер-класс по продажам</li>
            </ul>
            <a id="look_small_lesson" class="look_more_about_lesson" href="javascript:void();"></a>
        </div>
        <div class="small_info_about_lessons">
            <?
                $countAdvLessons = $model->countLessons(array('scopes'=>'pay_advanced'));
            ?>
            <div class="caption">Расширенный курс</div>
            <div class="about_lesson_text">
                <?=$model->adv_description;?>
            </div>
            <div class="enter_in_lesson">Что входит в курс:</div>
            <ul>
                <li><?=$countAdvLessons?> видеоуроков</li>
                <li><?=$model->getCountSources('advanced');?> PDF-<?=Functions::plurar($model->getCountSources('advanced'), array('файл','файла','файлов'));?></li>
                <li>Мастер-класс по продажам</li>
            </ul>
            <a id="look_big_lesson" class="look_more_about_lesson" href="javascript:void();"></a>
        </div>
    </div>
    
    
    
    <article class="white-box anonce">
        <h2>Базовый курс</h2>
        <div class="create_line">
           <div class="im_line"></div>
        </div>
       
        <div class="video_block_for_look">
            <?foreach ($model->freeBasicLessons as $lesson):?>
                
                <div class="body its_video">
                    <div class="preview">
                    	<div class="play open_lesson" data-lesson_id="<?=$lesson->id?>"></div>
                        <div class="time"><?=date('j F', strtotime($lesson->date_public))?></div>
                    	<img src="<?=$lesson->poster?>" alt=""/>
                    </div>
                    
                    <div>
                        <div class="caption"><?=$lesson->name?></div>
                    	<p><?=$lesson->description?></p>
                    </div>
                    <div class="clear"></div>
                                    
                    <div class="actions_video">
                        <div class="s_play">
                            <div class="s_image"></div>
                            <div class="s_text"><a class="open_lesson" href="javascript:;" data-lesson_id="<?=$lesson->id?>"><?=$lesson->name?></a></div>
                        </div>
            
                        <?foreach( $lesson->sources as $source ):?>
                            <div class="s_pdf">
                                <div class="s_image"></div>
                                <div class="s_text">
                                    <a href="<?=$source->downloadUrl;?>">Ссылка на просмотр</a>
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

        <?if($model->getCountSources('basic') > 0):?>
            <div class="materials_for_videoblock">
                <div class="small_desc">Материалы к базовому курсу:</div>
                <div class="materials_block">
                    <?foreach( $model->basic_sources as $source ):?>
                        <div class="s_pdf">
                            <div class="s_image"></div>
                            <div class="s_text">
                                <a href="<?=$source->downloadUrl;?>">Ссылка на просмотр</a>
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
                            <img src="<?=$lesson->poster?>" alt=""/>
                        </div>
                        
                        <div>
                            <div class="caption"><?=$lesson->name?></div>
                            <p><?=$lesson->description?></p>
                        </div>
                        <div class="clear"></div>
                                        
                        <div class="actions_video">
                            <div class="s_play">
                                <div class="s_image"></div>
                                <div class="s_text">
                                    <a class="open_lesson" href="javascript:;" data-lesson_id="<?=$lesson->id?>"><?=$lesson->name?></a>
                                </div>
                            </div>
                            <?foreach( $lesson->sources as $source ):?>
                                <div class="s_pdf">
                                    <div class="s_image"></div>
                                    <div class="s_text">
                                        <a href="<?=$source->downloadUrl;?>">Ссылка на просмотр</a>
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
                <div class="caption">Платная часть курсов за <?=$model->basic_cost?> рублей</div>
                <input name="BuyForm[course_id]" type="hidden" style="display: none;" value="<?=$model->id?>" />
                <input name="BuyForm[block_type]" type="hidden" style="display: none;" value="<?=Course::BLOCK_TYPE_PAY_BASIC?>" />
                <input class="buy_lessons" type="submit" />
            </form>
            <div class="top_part"></div>
                <div class="middle_part">
                    <div class="content_block_for_sell">
                        <div class="video_blocks_for_sell">
                            <?foreach ($model->getPaydBasicLessons() as $lesson):?>
                                <div class="video_block">
                                    <div class="preview">
                                        <div class="play open_lesson" data-lesson_id="<?=$lesson->id?>"></div>
                                        <div class="time"><?=date('j F', strtotime($lesson->date_public))?></div>
                                        <img alt="" src="<?=$lesson->poster?>" width="220" height="128"/>
                                    </div>
                                    <div class="link_on_buy">
                                        <a class="open_lesson" href="javascript:;" data-lesson_id="<?=$lesson->id?>"><?=$lesson->name?></a>
                                    </div>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
            <div class="bottom_part"></div>
            <div class="in_cart">
                <a href="javascript:void();"></a>
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
                    <?foreach ($model->getPaydAdvancedLessons() as $lesson):?>
                        <div class="video_block">
                            <div class="preview">
                                <div class="play"></div>
                                <div class="time">12 апреля</div>
                                <img alt="" src="images/tmp/small_bruce.png">
                            </div>    
                            <div class="link_on_buy">
                                <a href="<?=$lesson->url;?>"><?=$lesson->name?></a>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
        <div class="bottom_part"></div>
        <div class="in_cart">
            <a href="javascript:void();"></a>
        </div>
    </div>
    -->
</section>

<aside id="blog" class="white-box">
	<h2>Блог Б.Трейси</h2>
    <!--
	<div class="filter" style="display: none;">
		<form action="" type="POST">
			<div class="checkbox">
				<table class="checked"><tr><td class="img"></td><td>Развитие бизнеса</td><tr></table>
				<table class="unchecked"><tr><td class="img"></td><td>Продажи</td><tr></table>
				<table class="checked"><tr><td class="img"></td><td>Развитие бизнеса</td><tr></table>
				<table class="unchecked"><tr><td class="img"></td><td>Продажи</td><tr></table>
				<table class="checked"><tr><td class="img"></td><td>Развитие бизнеса</td><tr></table>
				<table class="unchecked"><tr><td class="img"></td><td>Продажи</td><tr></table>
			</div>
			<div>
				Доделать инпуты
			</div>
		</form>
	</div>
    -->
    <? echo $this->renderPartial('/site/_loop', array(
        'dataProvider'=>$blogData,
        'itemView'=>'/article/_view',
        'feed_id'=>'posts',
        'totalCount'=>$blogData->totalItemCount.' '.Functions::plurar($blogData->totalItemCount, array('материал','материала','материалов')),
        'successAjaxLoad'=>"
            onLoadBlog();
        "
    ));?>
</aside>
<div class="clear"></div>