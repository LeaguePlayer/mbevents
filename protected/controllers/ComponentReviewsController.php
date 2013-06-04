<?php

class ComponentReviewsController extends CAnnounceComponentController
{
    public function filters()
	{
		return array(
			'accessControl',
			//'postOnly + delete',
            'ajaxOnly + addReview',
		);
	}
    
    public function accessRules()
    {
        return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('addReview'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
    }
    
    public function loadModel($id)
    {
        $model = ComponentReviews::model()->findByPk($id);
        if (!$model) {
            return null;
        }
        return $model;
    }
    
    public function create($announceId, $backUrl = false)
    {
        $model = new ComponentReviews;
        $model->setAnnounceId($announceId);
        
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentReviews']) ) {
            $model->setAttributes($_POST['ComponentReviews']);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile($url.'/js/admin/reviews.js', CClientScript::POS_END);
        $this->render('create', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    public function update($id, $announceId, $backUrl = false)
    {
        $model = $this->loadModel($id);
        if (!$model) {
            throw new CHttpException(404, 'Не найден компонент');
        }
        
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentReviews']) ) {
            $model->setAttributes($_POST['ComponentReviews']);
            
            if ( $model->save() ) {
                return true;
            }
        }
        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/admin/reviews.js', CClientScript::POS_END );
        $this->render('update', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='component_reviews-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionAddReview($id = null)
    {
        if ( is_numeric($id) ) {
            $review = Reviews::model()->findByPk($id);
        }
        if ( $review === null ) {
            $review = new Reviews;
        }
        
        if ( isset($_POST['Reviews']) ) {
            $response = array(
                'success' => null,
                'review' => null,
                'reviewHtml' => null,
                'errors' => null,
            );
            $review->setAttributes( $_POST['Reviews'] );
            if ( $review->save() ) {
                $response['success'] = true;
                $response['review']['id'] = $review->id;
                $response['review'] = $review->attributes;
                $response['reviewHtml'] = $this->renderPartial('_review', array('model'=>$review), true);
            } else {
                $response['errors'] = $review->errors;
            }
            echo function_exists('json_encode') ? json_encode($response) : CJSON::encode($response);
            Yii::app()->end();
        }
        
        echo $this->renderPartial('_review_form', array('model'=>$review));
    }
}