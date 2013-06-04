<div class="white-box">
    <article id="anonce">
    	<h2><?=$model->getTitle();?></h2>
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
</div>