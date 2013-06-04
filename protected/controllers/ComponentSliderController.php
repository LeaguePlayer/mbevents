<?php

class ComponentSliderController extends CAnnounceComponentController
{
    public function filters()
	{
		return array(
			'accessControl',
			//'postOnly + delete',
            'postOnly + removeSlide',
		);
	}
    
    public function accessRules()
    {
        return array(
			array('allow',
				'actions'=>array('removeSlide'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
    }
    
    public function loadModel($id)
    {
        $model = ComponentSlider::model()->findByPk($id);
        if (!$model) {
            return null;
        }
        return $model;
    }
    
    public function create($announceId, $backUrl = false)
    {
        $model = new ComponentSlider;
        $model->setAnnounceId($announceId);
        
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentSlider']) ) {
            $model->setAttributes($_POST['ComponentSlider']);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/admin/sliders.js',  CClientScript::POS_END );
        $this->render('create', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    public function update($id, $announceId, $backUrl = false)
    {
        $model = $this->loadModel($id);
        if (!$model) {
            throw new CHttpException(404, 'Не найден компонент');
        }
        $model->setAnnounceId($announceId);
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentSlider']) ) {
            $model->setAttributes($_POST['ComponentSlider']);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/admin/sliders.js',  CClientScript::POS_END );
        $this->render('update', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='component_slider-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionRemoveSlide($id)
    {
        if ( is_numeric($id) ) {
            $slide = Slides::model()->findByPk($id);
        }
        if ( !$slide ) {
            Yii::app()->end();
            echo 1;
        }
            
        unlink( Yii::getPathOfAlias('webroot').$slide->source );
        $slide->delete();
        echo 1;
    }
}