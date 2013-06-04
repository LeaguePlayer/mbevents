<?php

class ComponentPhVidController extends CAnnounceComponentController
{
    public function loadModel($id)
    {
        $model = ComponentPhVid::model()->findByPk($id);
        if (!$model) {
            return null;
            //throw new CHttpException(404, 'Видео-компонент c ID равным '.$id.' не найден');
        }
        return $model;
    }
    
    public function create($announceId, $backUrl = false)
    {
        $model = new ComponentPhVid;
        $model->setAnnounceId($announceId);
        
        if ( isset($_POST['ComponentPhVid']) ) {
            $model->attributes = $_POST['ComponentPhVid'];
            $this->performAjaxValidation($model);
            if ( $model->save() ) {
                return true;
            }
        }
        $this->render('create', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    public function update($id, $announceId, $backUrl = false)
    {
        $model = $this->loadModel($id);
        if (!$model) {
            throw new CHttpException(404, 'Не найден компонент');
        }
        
        if ( isset($_POST['ComponentPhVid']) ) {
            $model->setAttributes($_POST['ComponentPhVid']);
            $this->performAjaxValidation($model);
            if ( $model->save() ) {
                return true;
            }
        }
        $this->render('update', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='component_phvid-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}