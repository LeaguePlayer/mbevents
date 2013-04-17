<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1 style="font-size: 80px; text-align: center; padding: 100px 0;">MB-EVENTS</h1>

<?php
    //$this->renderPartial('/announce/_frontview', array('model'=>$announce));
?>

<?php
    $this->widget('SiteSearch');
    
    $this->renderPartial('_loop', array(
        'dataProvider'=>$blogDataProvider,
        'itemView'=>'/article/_view',
        'feed_id'=>'feed_blog',
    ));
?>

<?php
    $this->renderPartial('_loop', array(
        'dataProvider'=>$coursesData,
        'itemView'=>'/course/_view',
        'feed_id'=>'feed_course',
    ));
?>