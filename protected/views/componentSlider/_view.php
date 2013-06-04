
<div class="white-box">
    
    <div id="rounder">
		<h2><?=$model->getTitle();?></h2>
		<div class="rounder">
			<ul>
                <? foreach ($model->slides as $item): ?>
    				<li>
    					<a href="#r"><?=$item->getThumb(370, 220)?></a>
    				</li>
                <? endforeach; ?>                
				<div class="clear"></div>
			</ul>
		</div>
	</div>
    
</div>

<?php

    
?>