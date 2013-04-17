<?php
$this->widget('SiteSearch', array(
    'formModel'=>$form,
));
?>

<?php
$this->renderPartial('/site/_loop', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'/article/_view',
));
?>