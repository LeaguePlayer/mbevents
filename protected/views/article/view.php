<?php
/* @var $this ArticleController */
/* @var $model Article */

$this->breadcrumbs=array(
	'Управление статьями'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Создать статью', 'url'=>array('create')),
	array('label'=>'Изменить статью', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить статью', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Удалить эту статью?')),
	array('label'=>'Управление статьями', 'url'=>array('admin')),
);
?>

<section id="post-content">
	<article>
		<header>
			<div class="post-info">
				<div class="post-date"><?=date('j F Y', strtotime($model->date_public))?></div>
				<div class="post-views"><?=$model->views?></div>
				<div class="post-comments">0</div>
                <?$counter = 0;?>
                <?foreach ($model->categories as $category):?>
                    <?if ( ((++$counter) % 2) == 0):?>
                        <span class="yellow"><?=$category->name?></span>
                    <?else:?>
                        <span class="grey"><?=$category->name?></span>
                    <?endif;?>
                <?endforeach;?>				
			</div>
			<div class="clear"></div>
			<h1><?=$model->title?></h1>
		</header>
		<div class="post-body">
			<?=$model->getImage(380)?>
			<?=$model->full_description?>
		</div>
	</article>
</section>
