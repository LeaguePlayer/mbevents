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

<article>
    <div class="title-photo">
		<h3><a href="#post"><?=$data->categories[0]->name;?></a></h3>
		<a href="#post"><img src="/images/tmp/post_img.jpg" alt="" width="215" height="127"></a>
	</div>
	<div>
		<div class="post-info">
			<a href="#post"><?=$data->title;?></a>
			<p><?=Functions::extractIntro($data->short_description, 100, '...');?></p>
		</div>
		<div class="stat">
			<div class="post-date"><?=date('j F Y', $data->date_public);echo $date->date_public?></div>
			<div class="post-views">0</div>
			<div class="post-comments">0</div>
		</div>
		<div class="clear"></div>
	</div>
</article>