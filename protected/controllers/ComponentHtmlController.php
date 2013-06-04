<?php

class ComponentHtmlController extends CAnnounceComponentController
{
    public function filters()
	{
		return array(
			'accessControl',
			//'postOnly + delete',
		);
	}
    
    public function loadModel($id)
    {
        $model = ComponentHtml::model()->findByPk($id);
        if (!$model) {
            return null;
        }
        return $model;
    }
    
    public function create($announceId, $backUrl = false)
    {
        $model = new ComponentHtml;
        $model->setAnnounceId($announceId);
        
        if ( isset($_POST['ComponentHtml']) ) {
            $model->setAttributes($_POST['ComponentHtml']);
            
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
        $model->setAnnounceId($announceId);
        if (!$model) {
            throw new CHttpException(404, 'Не найден компонент');
        }
        
        if ( isset($_POST['ComponentHtml']) ) {
            $model->setAttributes($_POST['ComponentHtml']);
            
            $this->performAjaxValidation($model);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $this->render('update', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='component_html-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}