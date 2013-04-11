<?php
    $this->widget('CFeedBlog', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_feedItem',
        'ajaxUpdate'=>false,
        'template'=>'{items}'
    ));
?>