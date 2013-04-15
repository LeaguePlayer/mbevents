<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>$itemView,
        'ajaxUpdate'=>false,
        'template'=>'{items}'
    ));
?>