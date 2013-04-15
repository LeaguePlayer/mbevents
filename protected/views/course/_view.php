<?php
/* @var $this CourseController */
/* @var $data Course */
?>

<div class="view">
    <div class="category"><a href="<?=$this->createUrl('/cours/index', array('category'=>$data->category->id));?>"><?=$data->category->name?></a></div>
    
	<div class="preview">
        <div id="player-for-course-<?=$data->id?>" class="player" source="<?=$data->video_preview?>"></div>
    </div>

</div>