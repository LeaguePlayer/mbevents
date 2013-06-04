<section id="post-content">
	<article>
		<header>
			<div class="post-info">
				<div class="post-date"><?=Functions::getCalendarDay(strtotime($model->date_public))?></div>
				<div class="post-views"><?=$model->views?></div>
				<div class="post-comments"><?=$model->commentCount?></div>
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
			<?=$model->getImage(380)?>
			<?=$model->full_description?>
		</div>
		<!--<div class="post-social">Соц сети</div>-->
	</article>
    
    <? if (!Yii::app()->user->isGuest): ?>
    	<h2>Интересно? Расскажи другу!</h2>
    	<div class="shared-form form">
            <?php
                $form=$this->beginWidget('CActiveForm', array(
                    'action'=>$this->createUrl('/article/sendArticle'),
                	'id'=>'send_article-form',
                	'enableAjaxValidation'=>false,
                ));
                $sendForm = new SendArticleForm;
                $sendForm->article_id = $model->id;
            ?>
                <?php echo $form->hiddenField($sendForm, 'article_id'); ?>
                <?php echo $form->textField($sendForm, 'email', array('class'=>'email blue-style')); ?>
    			<button class="blue_button" type="submit" name="">Поделиться</button>
    			<div class="notice" style="display: none;"></div>
    			<div class="clear"></div>
    		<?php $this->endWidget(); ?>
    	</div>
    <? endif; ?>
    
    <?php if ( $model->commentCount > 0 ): ?>
    	<h2>Комментарии</h2>
    	<div class="reviews">
            <div class="scroll-wrapper">
            <div class="scroller">
            <div class="scroll-container" style="padding-right: 0;">
        		<?php foreach($model->comments as $item): ?>
                    <? $this->renderPartial('/comment/_view', array('data'=>$item)); ?>
                <?php endforeach; ?>
                <div class="scroller__bar"></div>
            </div>
            </div>
            </div>
    	</div>
     <?php endif; ?>
    
    <? if ( !Yii::app()->user->isGuest ): ?>
    	<h2>Вы можете оставить здесь своё мнение</h2>
    	<div class="question">
    		<?php $form=$this->beginWidget('CActiveForm', array(
                'action'=>$this->createUrl('/comment/create'),
            	'id'=>'comment-form',
            	'enableAjaxValidation'=>false,
            )); ?>
                
                <?php echo $form->hiddenField($comment,'article_id'); ?>
            
                <div class="row">
            		<?php echo $form->textArea($comment,'content', array('class'=>'blue-style')); ?>
            		<?php echo $form->error($comment,'content'); ?>
            	</div>
                <!--
    			<div class="who">
    				<img src="images/tmp/aristotel.png" alt="">
    				<span>Вы выскажетесь, как Аристотель</span>
    			</div>
                -->
    			<button type="submit" class="blue_button submit"><span class="icon"></span></button>
                <!--
    			<a class="auth" href="#auth"></a>
                -->
    			<div class="clear"></div>
    		<?php $this->endWidget(); ?>
    	</div>
     <? endif ?>
     <a class="close_box" href="#">Закрыть</a>
</section>