
<div id="speakers">
    <h2 class="main"><?=$model->getTitle();?></h2>
    <? foreach($model->getSpiekers() as $spieker): ?>
        <? $this->renderPartial('_spieker', array('model'=>$spieker)); ?>
    <? endforeach; ?>
</div>