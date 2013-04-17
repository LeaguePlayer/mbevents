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
    <h2><?=$data->title;?></h2>
    <?php
        echo $data->short_description;
    ?>
</article>