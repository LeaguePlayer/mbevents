<?php
/* @var $this CommentController */
/* @var $data Comment */
?>

<div class="review-item">
	<div class="author">
        <!--
		<img src="images/tmp/comment-author.png" alt="">
        -->
		<div class="name"><?=$data->author->profile->firstname.' '.$data->author->profile->lastname?>,<br /><span>мыслитель</span></div>
		<div class="date"><?=Functions::getCalendarDay(strtotime($data->date_create), false)?></div>
	</div>
	<div class="review-text"><?=$data->content?></div>
	<div class="clear"></div>
</div>