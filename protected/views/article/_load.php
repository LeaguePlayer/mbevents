<section id="post-content">
	<article>
		<header>
			<div class="post-info">
				<div class="post-date"><?=date('j F Y', $model->date_public)?></div>
				<div class="post-views">0</div>
				<div class="post-comments">0</div>
                <?$counter = 0;?>
                <?foreach ($model->categories as $category):?>
                    <?if ( ((++$counter) % 2) == 0):?>
                        <span class="yellow"><?=$category->name?></span>
                    <?else:?>
                        <span class="grey"><?=$category->name?></span>
                    <?endif;?>
                <?endforeach;?>				
			</div>
			<div class="clear"></div>
			<h1><?=$model->title?></h1>
		</header>
		<div class="post-body">
			<img src="images/tmp/post_img2.jpg" alt="">
			<?=$model->full_description?>
		</div>
		<div class="post-social">Соц сети</div>
	</article>
	<h2>Интересно? Расскажи другу!</h2>
	<div class="shared-form">
		<form name="" type="POST" action="">
			<input class="email blue-style" type="text" value="braisy@yandex.ru" name="">
			<input class="submit" type="submit" name="">
			<div class="notice">плохой e-mail</div>
			<div class="clear"></div>
		</form>
	</div>
    <!--
	<h2>Что думаешь об этом?</h2>
	<div class="reviews">
		<div class="review-item">
			<div class="author">
				<img src="images/tmp/comment-author.png" alt="">
				<div class="name">Лев Николаевич, <span>мыслитель</span></div>
				<div class="date">14 апреля</div>
			</div>
			<div class="review-text">С вечера, на последнем переходе, был получен приказ, что главноС вечера, на последнем переходе, был получен приказ, что главно С вечера, на последнем переходе, был получен приказ, что главно</div>
			<div class="clear"></div>
		</div>
		<div class="review-item">
			<div class="author">
				<img src="images/tmp/comment-author.png" alt="">
				<div class="name">Лев Николаевич, <span>мыслитель</span></div>
				<div class="date">14 апреля</div>
			</div>
			<div class="review-text">С вечера, на последнем переходе, был получен приказ, что главноС вечера, на последнем переходе, был получен приказ, что главно С вечера, на последнем переходе, был получен приказ, что главно</div>
			<div class="clear"></div>
		</div>
	</div>
    -->
	<h2>Хочу высказаться</h2>
	<div class="question">
		<form>
			<textarea class="blue-style">Комментарий к материалу</textarea>
			<div class="who">
				<img src="images/tmp/aristotel.png" alt="">
				<span>Вы выскажетесь, как Аристотель</span>
			</div>
			<input type="submit" class="submit" name="">
			<a class="auth" href="#auth"></a>
			<div class="clear"></div>
		</form>
	</div>
</section>