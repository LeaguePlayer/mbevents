
<article id="anonce" class="white-box">
	<h2>Анонс мероприятия Брайана Трейси</h2>
	<div class="body">
		<div class="preview">
            <?if( !empty($model->video_source) ):?>
    		    <div class="play"></div>
            <?endif;?>
			<img src="<?=$model->photo_source?>" alt=""/>
		</div>
		<div>
			<p><?=$model->description?></p>
		</div>
		<div class="clear"></div>
	</div>
</article>