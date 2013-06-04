<?php
/* @var $data Article */
?>

<?php
    if ( isset($_GET['searchString']) ) {
        $searchString = $_GET['searchString'];
        $pizza = explode('>', $data->short_description);
        $s = '';
        for ($i = 0; $i < count($pizza); $i++) {
            $piece = explode('<', $pizza[$i]);
            $replace = preg_replace('/('.$searchString.')/i', '<b><span style="background:yellow;">${1}</span></b>', $piece[0]);
            if (count($piece) == 2) {
                $s .= $replace.'<'.$piece[1].'>';
            } else if (count($piece) == 1) {
                $s .= $replace;
            }
        }
        $data->short_description = $s;
    }
?>

<article data-id="<?=$data->id?>">
    <div class="title-photo">
		<h3><a href="<?=$data->getUrl();?>"><?=$data->categories[0]->name;?></a></h3>
		<a href="<?=$data->getUrl();?>"><?=$data->getImage(215)?></a>
	</div>
	<div>
		<div class="post-info">
			<a href="<?=$data->getUrl();?>"><?=$data->title;?></a>
			<p><?=Functions::extractIntro($data->short_description, 100, '...');?></p>
		</div>
		<div class="stat">
			<div class="post-date"><?=Functions::getCalendarDay(strtotime($data->date_public))?></div>
			<div class="post-views"><?=$data->views?></div>
			<div class="post-comments"><?=$data->commentCount?></div>
		</div>
		<div class="clear"></div>
	</div>
</article>