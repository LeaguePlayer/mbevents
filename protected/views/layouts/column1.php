<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<header id="top-header">
	<div class="lines">
		<div class="header-small" style="display:none">
			<div class="center">
				<div id="header-left-block">
					<div id="hide-btn" class="hide">&nbsp;</div>
					<nav class="top-menu">
						<ul>
							<li><a href="/">Главная</a></li>
							<li><a href="#">Семинары</a></li>
							<li><a href="#">Видео-уроки</a></li>
							<li><a href="#">Партнерская система</a></li>
						</ul>
					</nav>
					<div class="name-mini">
						<div>Брайaн <div>Трейси</div></div>
						Бизнес-тренер экстра-класса
					</div>
					<div class="video-mini">
						<div class="social-mini">
							<a class="fb" href="#"></a>
							<a class="tw" href="#"></a>
							<a class="vk" href="#"></a>
						</div>
						<a class="watch" href="<?=$this->topCourse->url;?>"><span>Посмотреть все видео</span></a>
						<div class="clear"></div>
						<div class="video">
							<div class="big">
								<div class="play"></div>
								<div class="date">3 марта</div>
                                <img src="/images/tmp/img1.jpg"/>
							</div>
							<div class="small">
								<div class="play"></div>
								<img src="/images/tmp/img3.jpg">
							</div>
							<div class="small">
								<div class="play"></div>
								<img src="/images/tmp/img2.jpg">
							</div>
						</div>
					</div>
				</div>
				<div id="header-right-block">
					<section class="login-block">
                        <?if (Yii::app()->user->isGuest):?>
    						<header>
    							<h2>Войти на сайт</h2>
    							<a class="fogot-pass" href="#">Забыли пароль?</a>
    							<div class="clear"></div>
    						</header>
    						<form class="login-form" action="" type="POST">
    							<div class="cell">
    								<label>Логин:</label>
    								<input class="login blur" name="" type="text" value="login">
    							</div>
    							<div class="cell">
    								<label>Пароль:</label>
    								<input class="pass" name="" type="password" value="pass">
    							</div>
    							<input class="submit" type="submit" value="">
    							<div class="clear"></div>
    						</form>
                            <!--
    						<div class="fraza"></div>
    						<a class="reg-button" href="#reg"></a>
                            -->
                        <?else:?>
                            <header>
    							<h2><?=Yii::app()->user->email?></h2>
                                <a class="fogot-pass" href="<?=$this->createUrl('/user/logout');?>">Выход</a>
    							<div class="clear"></div>
    						</header>
                        <?endif;?>
					</section>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="header-big">
			<nav id="top-menu">
				<div class="center">
					<ul class="center">
						<li><a href="/">Главная</a></li>
						<li><a href="#">Семинары</a></li>
						<li><a href="#">Видео-уроки</a></li>
						<li><a href="#">Партнерская система</a></li>
					</ul>
				</div>	
			</nav>
			<section id="traicy" class="center">
				<img class="traicy" src="/images/traicy.png" alt="Трейси" />
				<div id="hide-btn" class="hide">&nbsp;</div>
				<div class="name">
					Бизнес-тренер экстра-класса
					<div>Брайaн <div>Трейси</div></div>
				</div>
				<div class="social">
					<a class="fb" href="#"></a>
					<a class="tw" href="#"> </a>
					<a class="vk" href="#"> </a>
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
							<div class="play"></div>
							<div class="date">3 марта</div>
							<p>Брайан Трейси - 7 способов, которыми думают миллионеры</p>
							<img src="/images/tmp/img1.jpg">
						</div>
						<div class="small">
							<div class="play"></div>
							<div class="date">3 марта</div>
							<img src="/images/tmp/img3.jpg">
						</div>
						<div class="small">
							<div class="play"></div>
							<div class="date">3 марта</div>
							<img src="/images/tmp/img2.jpg">
						</div>
					</div>
				</section>
				<section id="login-block">
                    <?if (Yii::app()->user->isGuest):?>
    					<header>
    						<h2>Войти на сайт</h2>
    						<a class="fogot-pass" href="#">Забыли пароль?</a>
    						<div class="clear"></div>
    					</header>
    					<form id="login-form" action="" type="POST">
    						<div>
    							<label>Логин:</label>
    							<input class="login blur" name="" type="text" value="login">
    						</div>
    						<div>
    							<label>Пароль:</label>
    							<input class="pass" name="" type="password" value="pass">
    							<input class="submit" type="submit" value="">
    							<div class="clear"></div>
    						</div>
    					</form>
                        <!--
    					<div class="fraza"></div>
    					<a class="reg-button" href="#reg"></a>
                        -->
                    <?else:?>
                        <header>
							<h2><?=Yii::app()->user->email?></h2>
                            <a class="fogot-pass" href="<?=$this->createUrl('/user/logout');?>">Выход</a>
							<div class="clear"></div>
						</header>
                    <?endif?>
				</section>
			</section>
		</div>
	</div>
</header>

<div class="center">
	<?php echo $content; ?>
</div>

<?php $this->endContent(); ?>