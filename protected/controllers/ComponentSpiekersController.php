<?php

class ComponentSpiekersController extends CAnnounceComponentController
{
    public function filters()
	{
		return array(
			'accessControl',
			//'postOnly + delete',
            'ajaxOnly + addSpieker',
		);
	}
    
    public function accessRules()
    {
        return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('addSpieker'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
    }
    
    public function loadModel($id)
    {
        $model = ComponentSpiekers::model()->findByPk($id);
        if (!$model) {
            return null;
        }
        return $model;
    }
    
    public function create($announceId, $backUrl = false)
    {
        $model = new ComponentSpiekers;
        $model->setAnnounceId($announceId);
        
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentSpiekers']) ) {
            $model->setAttributes($_POST['ComponentSpiekers']);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/admin/spiekers.js',  CClientScript::POS_END );
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
        
        if ( isset($_POST['ComponentSpiekers']) ) {
            $model->setAttributes($_POST['ComponentSpiekers']);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/admin/spiekers.js',  CClientScript::POS_END );
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
    
    public function actionAddSpieker($id = null)
    {
        if ( is_numeric($id) ) {
            $spieker = Spiekers::model()->findByPk($id);
        }
        if ( $spieker === null ) {
            $spieker = new Spiekers;
        }
        
        if ( isset($_POST['Spiekers']) ) {
            $response = array(
                'success' => null,
                'spieker' => null,
                'spiekerHtml' => null,
                'errors' => null,
            );
            $spieker->setAttributes( $_POST['Spiekers'] );
            if ( $spieker->save() ) {
                $response['success'] = true;
                $response['spieker']['id'] = $spieker->id;
                $response['spieker'] = $spieker->attributes;
                $response['spiekerHtml'] = $this->renderPartial('_spieker', array('model'=>$spieker), true);
            } else {
                $response['errors'] = $spieker->errors;
            }
            echo function_exists('json_encode') ? json_encode($response) : CJSON::encode($response);
            Yii::app()->end();
        }
        
        echo $this->renderPartial('_spieker_form', array('model'=>$spieker));
    }
}