<ul class="courses">

    <?php foreach( $models as $model ): ?>
        <li class="course">
            <a class="name" href="<?=$this->createUrl('/course/go', array('id'=>$model->id));?>"><?=$model->title?></a>
        </li>
    <?php endforeach; ?>

</ul>