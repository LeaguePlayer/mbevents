<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1 style="font-size: 80px; text-align: center; padding: 100px 0;">MB-EVENTS</h1>

<?php
    //$this->renderPartial('/announce/_frontview', array('model'=>$announce));
?>

<?php
    //$this->renderPartial('_courses', array('models'=>$courses));
?>

<?php
    $this->renderPartial('_loop', array(
        'dataProvider'=>$blogDataProvider,
        'itemView'=>'_view',
    ));
?>