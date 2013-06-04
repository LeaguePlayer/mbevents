<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<header id="top-header" <?if ($this->header_small) echo 'data-hide="true" style="position: absolute; top: 0;"'?>>
	<div class="lines">
		<div class="header-small" style="<?if (!$this->header_small) echo 'display:none;'?>">
			<div class="center">
				<div id="header-left-block">
					<div id="hide-btn" class="<?=($this->header_small) ? 'show' : 'hide'?>">&nbsp;</div>
					<nav class="top-menu">
						<ul>
                            <li><a href="/">Семинары</a></li>
                            <li><a href="<?=$this->topCourse->url;?>">Видео-уроки</a></li>
                            <? if (!Yii::app()->user->isGuest): ?>
                                <!--<li><a href="<?=$this->createUrl('/course/my');?>">Мои видеокурсы</a></li>-->
                            <? endif ?>
							<!--<li><a href="#">Партнерская система</a></li>-->
						</ul>
					</nav>
                    <div class="name-callback">
                        <div class="name-mini">
        					Академия
        					<div>Брайaна <div>Трейси</div></div>
        				</div>
                        <div class="callback-mini">
                            <p class="phone">8 800 1004635</p>
                            <a class="yellow_button_2 callback_button" href="#"><span class="icon"></span></a>
                        </div>
                    </div>
					<div class="video-mini">
                        <!--
						<div class="social-mini">
							<a class="fb" href="#"></a>
							<a class="tw" href="#"></a>
							<a class="vk" href="#"></a>
						</div>
                        -->
						<a class="watch" href="<?=$this->topCourse->url;?>"><span>Посмотреть все видео</span></a>
						<div class="clear"></div>
						<div class="video">
							<div class="big">
								<div class="play open_lesson" data-lesson_id="13"></div>
								<div class="date">3 марта</div>
                                <img src="<?=$this->getAssetsBase()?>/images/tmp/img1.jpg"/>
							</div>
							<div class="small">
								<div class="play open_lesson" data-lesson_id="15"></div>
								<img src="<?=$this->getAssetsBase()?>/images/tmp/img3.jpg">
							</div>
							<div class="small">
								<div class="play" onclick="javascript:window.location.href = '<?=$this->topCourse->url?>';"></div>
								<img src="<?=$this->getAssetsBase()?>/images/tmp/img2.jpg">
							</div>
						</div>
					</div>
				</div>
				<div id="header-right-block">
					<section class="login-block">
                        <?if (Yii::app()->user->isGuest):?>
    						<header>
    							<h2>Войти на сайт</h2>
    							<a class="fogot-pass" href="<?=$this->createUrl('/user/recovery');?>">Забыли пароль?</a>
    							<div class="clear"></div>
    						</header>
    						<form class="login-form" action="/user/login" method="POST">
    							<div class="cell">
    								<label>Логин:</label>
    								<input class="login blur" name="UserLogin[username]" type="text" value="" placeholder="Ваш E-mail">
    							</div>
    							<div class="cell">
    								<label>Пароль:</label>
    								<input class="pass" name="UserLogin[password]" type="password" value="">
    							</div>
                                <button class="submit yellow_button_2" type="submit"><span class="icon"></span></button>
    							<div class="clear"></div>
    						</form>
                            
    						<div class="registration_box">
                                <div class="fraza"></div>
                                <a class="reg-button yellow_button" href="#reg">Регистрация</a>
                            </div>
                                 
                        <?else:?>
                            <header>
    							<h2>Личный кабинет</h2>
    							<div class="clear"></div>
    						</header>
                            <div class="email_label">Ваш email</div>
                            <div class="email"><?=Yii::app()->user->email;?></div>
                            <a class="yellow_button_2 user_cabinett" href="<?=$this->createUrl('/user/profile/edit');?>"><span class="icon"></span>Личные настройки</a><br />
                            <a class="logout_button" href="<?=$this->createUrl('/user/logout');?>">Выход</a>
                        <?endif;?>
					</section>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="header-big" style="<?if ($this->header_small) echo 'display:none;'?>">
			<nav id="top-menu">
				<div class="center">
					<ul>
                        <li><a href="/">Семинары</a></li>
                        <li><a href="<?=$this->topCourse->url;?>">Видео-уроки</a></li>
                        <? if (!Yii::app()->user->isGuest): ?>
                            <!--<li><a href="<?=$this->createUrl('/course/my');?>">Мои видеокурсы</a></li>-->
                        <? endif ?>
						<!--<li><a href="#">Семинары</a></li>
						<li><a href="#">Партнерская система</a></li>-->
					</ul>
				</div>	
			</nav>
			<section id="traicy" class="center">
				<img class="traicy" src="<?=$this->getAssetsBase()?>/images/traicy.png" alt="Трейси" />
				<div id="hide-btn" class="<?=($this->header_small) ? 'hide' : 'show'?>">&nbsp;</div>
				<div class="name">
					Академия
					<div>Брайaна <div>Трейси</div></div>
				</div>
                <!--
				<div class="social">
					<a class="fb" href="#"></a>
					<a class="tw" href="#"> </a>
					<a class="vk" href="#"> </a>
				</div>
                -->
                <div class="callback">
                    <p class="email"><?//=Yii::app()->params['SUPPORT_EMAIL']?></p>
                    <p class="phone">8 800 100 46 35</p>
                    <a class="yellow_button_2 callback_button" href="#"><span class="icon"></span>Написать нам</a>
                </div>
				<div class="clear"></div>
				<section id="video-block">
					<header>
						<h2>Видеоматериалы</h2>
						<a class="watch" href="<?=$this->topCourse->url;?>"><span>Посмотреть все видео</span></a>
					</header>
					<div class="clear"></div>
					<div id="video-preview">
						<div class="big">
							<div class="play open_lesson" data-lesson_id="13"></div>
							<div class="date">23 апреля</div>
							<p>Брайан Трейси. Видео-курс "Успех в продажах"</p>
							<img src="<?=$this->getAssetsBase()?>/images/tmp/img1.jpg">
						</div>
						<div class="small">
							<div class="play open_lesson" data-lesson_id="15"></div>
							<div class="date">23 апреля</div>
							<img src="<?=$this->getAssetsBase()?>/images/tmp/img3.jpg">
						</div>
						<div class="small">
							<div class="play" onclick="javascript:window.location.href = '<?=$this->topCourse->url?>';"></div>
							<div class="date">23 апреля</div>
							<img src="<?=$this->getAssetsBase()?>/images/tmp/img2.jpg">
						</div>
					</div>
				</section>
				<section id="login-block">
                    <?if (Yii::app()->user->isGuest):?>
    					<header>
    						<h2>Войти на сайт</h2>
							<a class="fogot-pass" href="<?=$this->createUrl('/user/recovery');?>">Забыли пароль?</a>
    						<div class="clear"></div>
    					</header>
    					<form id="login-form" action="/user/login" method="POST">
							<div class="cell">
								<label>Логин:</label>
								<input class="login blur" name="UserLogin[username]" type="text" value="" placeholder="Ваш E-mail">
							</div>
							<div class="cell">
								<label>Пароль:</label>
								<input class="pass" name="UserLogin[password]" type="password" value="">
							</div>
                            <button class="submit yellow_button_2" type="submit">Войти</button>
							<div class="clear"></div>
						</form>
                        
                        <div class="registration_box">
                            <div class="fraza"></div>
                            <a class="reg-button yellow_button" href="#reg">Регистрация</a>
                        </div>
                        
                    <?else:?>
                        <header>
    							<h2>Личный кабинет</h2>
    							<div class="clear"></div>
						</header>
                        <div class="email_label">Ваш email</div>
                        <div class="email"><?=Yii::app()->user->email;?></div>
                        <a class="yellow_button_2 user_cabinett" href="<?=$this->createUrl('/user/profile/edit');?>"><span class="icon"></span>Личные настройки</a><br />
                        <a class="logout_button" href="<?=$this->createUrl('/user/logout');?>">Выход</a>
                    <?endif?>
				</section>
			</section>
		</div>
	</div>
</header>

<div class="center">

    <section id="main-block" class="scroll-content">
        <div class="scroll-wrapper">
            <div class="scroller fit-window">
                <div class="scroll-container">
                    <?php echo $content; ?>
                    <div class="scroller__bar"></div>
                </div>
            </div>
        </div>
    </section>
    
    <?php // showSideArticles defined in Controller
    if ( $this->showSideArticles ) : ?>
        <aside id="blog">
            <div class="scroll-wrapper">
                <div class="scroller fit-window">
                    <div class="scroll-container">
                        <div class="blog-content white-box">
                    		<h2>ОФИЦИАЛЬНЫЙ БЛОГ БРАЙАНА ТРЕЙСИ</h2>
                            <p class="note">на русском языке</p>
                            
                    		<div class="filter form">
                    			<form method="POST">
                    				<div class="checkbox">
                                        <? $articleSearch = $this->blogDataProvider->model; ?>
                                        <?=CHtml::activeCheckBoxList($articleSearch, 'searchCategories', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array(
                                            'container'=>'div',
                                            'separator'=>'',
                                        ))?>
                    				</div>
                                        
                    				<div class="select">
                    					<? echo CHtml::activeDropDownList($articleSearch, 'searchTags', CHtml::listData(Tag::model()->findAll(), 'name', 'name'), array(
                                            'multiple'=>true,
                                            'data-placeholder'=>'Выберите ключевое слово',
                                            'style'=>'width: 100%',
                                        ));?>
                    				</div>
                                    
                                    <div class="input">
                                        <? echo CHtml::activeTextField($articleSearch, 'searchString', array('placeholder'=>'ПОИСК ПО БЛОГУ')); ?><span class="clear_string">x</span>
                                    </div>
                                    <button type="submit" name="Article[isSearch]"></button>
                    			</form>
                    		</div>
                            
                            <?php
                                // blogDataProvider инициализируется в behavior'е components/behaviors/AutoLoadArticleBehavior
                                // там же обрабатываются поисковые запросы
                                // запуск behavior'а произвдится в beforeAction базового контроллера
                                if ( $this->blogDataProvider ) {
                                    echo $this->renderPartial('application.views.site._loop', array(
                                        'dataProvider'=>$this->blogDataProvider,
                                        'itemView'=>'application.views.article._view',
                                        'feed_id'=>'posts',
                                        'totalCount'=>$this->blogDataProvider->totalItemCount.' '.Functions::plurar($this->blogDataProvider->totalItemCount, array('материал','материала','материалов')),
                                        'successAjaxLoad'=>"
                                            onLoadBlog();
                                        "
                                    ));
                                }
                            ?>
                            <div class="scroller__bar"></div>
                        </div>
                    </div>
                </div>
            </div>
    	</aside>
    <? endif; //$this->showSideArticles ?>
    
    
</div>

<?php $this->endContent(); ?>