<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
	<section id="main-block">
    
        <?$announce->render();?>
        
        <!--
		<div class="big-more"><a href="">Подробная программа</a></div>
        -->
        
		<div class="white-box">
			<div class="reviews">
				<h2>Отзывы клиентов</h2>
				<div id="review-slider">
					<div class="slider-box">
						<div class="slider">
							<div class="review">
								<div class="r-image">
									<img src="/images/tmp/review_img.jpg" alt="">
									<div class="round-frame"></div>
								</div>
								<h3>Эд Таусиг</h3>
								<div class="whois">вице-президент компании «Объединенное правовое обеспечение»</div>
								<div class="clear"></div>
								<div class="r-text">
									<img src="/images/lt.gif" alt="<<">
									Спасибо вам за ваш вдохновляющий семинар по продажам. Наши менеджеры до сих пор находятся под впечатлением и высоко оценили  системность и содержание программы. Наши продажи снижались на 22% по отношению к предыдущему году. Через 3 месяца после семинара, в апреле и мае, объемы продаж достигли рекордных в истории нашей компании и теперь по нашим прогнозам  мы растем в 2,08  раза
									<img src="/images/rt.gif" alt=">>">
								</div>
							</div>
							<div class="review">
								<div class="r-image">
									<img src="/images/tmp/review_img.jpg" alt="">
									<div class="round-frame"></div>
								</div>
								<h3>Бет Колтз</h3>
								<div class="whois">Hewlett-Packard</div>
								<div class="clear"></div>
								<div class="r-text">
									<img src="/images/lt.gif" alt="<<">
									Нил раскрыл  очень сложную тему и показал лучший мировой опыт. Наши ТОП-менеджеры -  нетерпеливые и требовательные люди, но  в  конце  долгого дня они не желали отпускать его, и просили поделился еще и еще своим экспертным мнением 
									<img src="/images/rt.gif" alt=">>">
								</div>
							</div>
							<div class="review">
								<div class="r-image">
									<img src="/images/tmp/review_img.jpg" alt="">
									<div class="round-frame"></div>
								</div>
								<h3>Эд Таусиг</h3>
								<div class="whois">вице-президент компании «Объединенное правовое обеспечение»</div>
								<div class="clear"></div>
								<div class="r-text">
									<img src="/images/lt.gif" alt="<<">
									…мои продажи увеличились более чем на $ 200.000 за 3 месяца ... мой менеджер очень доволен ... Я связываю это с конкретными приемами, которые я узнал на Вашем семинаре по продажам
									<img src="/images/rt.gif" alt=">>">
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="slider-nav">
						<ul>
							<li class="active"></li>
							<li></li>
						</ul>
					</div>
				</div>
			</div>
            <!--
			<div id="rounder">
				<h2>Как проходит мероприятие</h2>
				<div class="rounder">
					<ul>
						<li>
							<div class="left"></div>
							<a href="#r"><img src="/images/tmp/cycle.jpg" alt=""></a>
							<div class="right"></div>
						</li>
						<li><a href="#r"><img src="/images/tmp/cycle.jpg" alt=""></a></li>
						<li><a href="#r"><img src="/images/tmp/cycle.jpg" alt=""></a></li>
						<li><a href="#r"><img src="/images/tmp/cycle.jpg" alt=""></a></li>
						<li><a href="#r"><img src="/images/tmp/cycle.jpg" alt=""></a></li>
						<div class="clear"></div>
					</ul>
				</div>
				<p>Оставив работу чернорабочего, Трейси занялся продажами. Сначала</p>
			</div>
            -->
            <!--
			<div id="registration-on-event">
				<h2>Регистрация на мероприятие</h2>
                <?$form = $this->beginWidget('CActiveForm', array(
                    'htmlOptions'=>array(
                        'class'=>'reg-event-form',
                    )
                ));?>
                    <div class="row">
						<?php echo $form->labelEx($eventForm, 'name'); ?>
						<?php echo $form->textField($eventForm, 'name'); ?>
					</div>
                    
                    <div class="row">
						<?php echo $form->labelEx($eventForm, 'phone'); ?>
						<?php echo $form->textField($eventForm, 'phone'); ?>
					</div>
                    
                    <div class="row">
						<?php echo $form->labelEx($eventForm, 'company'); ?>
						<?php echo $form->textField($eventForm, 'company'); ?>
					</div>
                    
                    <div class="row">
						<?php echo $form->labelEx($eventForm, 'email'); ?>
						<?php echo $form->textField($eventForm, 'email'); ?>
					</div>
                    
                    <div class="row">
						<?php echo $form->labelEx($eventForm, 'office'); ?>
						<?php echo $form->textField($eventForm, 'office'); ?>
					</div>
                    
                    <div class="row">
						<?php echo $form->labelEx($eventForm, 'secretcode'); ?>
						<?php echo $form->textField($eventForm, 'secretcode'); ?>
					</div>
                    <div class="clear"></div>
					<div>
						<input type="button" name="reserve" class="reserve" value="Забронировать" onclick="javascript:;">
						<div class="clear"></div>
					</div>
                <?$this->endWidget();?>
			</div>
            -->
		</div>
	</section>
	<aside id="blog" class="white-box">
		<h2 style="font-size: 22px;">ОФИЦИАЛЬНЫЙ БЛОГ БРАЙАНА ТРЕЙСИ</h2>
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
        <? echo $this->renderPartial('_loop', array(
            'dataProvider'=>$blogDataProvider,
            'itemView'=>'/article/_view',
            'feed_id'=>'posts',
            'totalCount'=>$blogDataProvider->totalItemCount.' '.Functions::plurar($blogDataProvider->totalItemCount, array('материал','материала','материалов')),
            'successAjaxLoad'=>"
                onLoadBlog();
            "
        ));?>
	</aside>
	<div class="clear"></div>
    
    <!--
	<section id="event-info">
		<div class="schedule">
			<h2>Расписание мероприятия</h2>
			<div class="table">
				<div class="row">
					<div class="sep"></div>
					<span class="image"><img src="/images/pencil.gif" alt=""></span>
					<span class="time">10:00-11:00</span>
					<span class="text">Запись на мероприятие</span>
				</div>
				<div class="row">
					<div class="sep"></div>
					<span class="image"><img src="/images/time.gif" alt=""></span>
					<span class="time">10:00-11:00</span>
					<span class="text">Запись на мероприятие</span>
				</div>
				<div class="row">
					<span class="image"><img src="/images/coffee.gif" alt=""></span>
					<span class="time">10:00-11:00</span>
					<span class="text">Запись на мероприятие</span>
				</div>
			</div>
		</div>
		<div class="place">
			<h2>Место проведения</h2>
			<img src="/images/tmp/map.jpg" alt="">
			<p>Г. Тюмень, улица Садовая, дом 15</p>
		</div>
		<div class="clear"></div>
	</section>
    -->

<?php
    //$this->renderPartial('/announce/_frontview', array('model'=>$announce));
?>

<?php
    //$this->widget('SiteSearch');
?>

<?php
//    $this->renderPartial('_loop', array(
//        'dataProvider'=>$coursesData,
//        'itemView'=>'/course/_view',
//        'feed_id'=>'feed_course',
//    ));
//
?>