<?php

class TagController extends Controller
{
	public function actionLoad()
	{
        $models = Tag::model()->findAll(array('order'=>'name'));
        foreach ($models as $model) {
            $tags[] = $model->name;
        }
		echo json_encode($tags);
	}
}