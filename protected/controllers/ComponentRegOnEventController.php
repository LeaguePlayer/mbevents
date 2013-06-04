<?php

class ComponentRegOnEventController extends CAnnounceComponentController
{
    public $layout = '//layouts/column2';
    
    public function filters()
	{
		return array(
			'accessControl',
            'ajaxOnly + registration',
		);
	}
    
    public function accessRules()
    {
        return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('registration'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
    }
    
    public function loadModel($id)
    {
        $model = ComponentRegOnEvent::model()->findByPk($id);
        if (!$model) {
            return null;
        }
        return $model;
    }
    
    public function create($announceId, $backUrl = false)
    {
        $model = new ComponentRegOnEvent;
        $model->setAnnounceId($announceId);
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentRegOnEvent']) ) {
            $model->setAttributes($_POST['ComponentRegOnEvent']);
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
        $this->performAjaxValidation($model);
        
        if ( isset($_POST['ComponentRegOnEvent']) ) {
            $model->setAttributes($_POST['ComponentRegOnEvent']);
            if ( $model->save() ) {
                return true;
            }
        }
        $this->render('update', array('model'=>$model, 'backUrl'=>$backUrl));
    }
    
    public function actionRegistration()
    {
        $model = new RegisterOnEvent;
        $this->performAjaxValidation($model, 'reg_on_event-form');
        
        if ( isset($_POST['RegisterOnEvent']) ) {
            $model->setAttributes( $_POST['RegisterOnEvent'] );
            if ( $model->save() ) {
                if ( is_numeric($model->announce_id) ) {
                    $announce = Announce::model()->findByPk($model->announce_id);
                    if ( $announce ) {
                        $announceName = $announce->title;
                    }
                }
                $siteUrl = "http://".$_SERVER['HTTP_HOST'];
                
                // отправка уведомления администратору сайта
                $subject = "Заявка на мероприятие «{$announceName}» с сайта {$siteUrl}";
                $message = "С сайта $siteUrl поступила заявка на мероприятие «{$announceName}» <br/> 
                    Имя: <strong>{$model->name}</strong><br/>
                    Телефон: <strong>{$model->phone}</strong><br/>
                    email: <strong>{$model->email}</strong><br/>";
                Functions::sendMail($subject, $message, Yii::app()->params['adminEmail'], "Академия Брайана Трейси");
                
                // отправка уведомления пользователю
                $notification = EmailNotification::findByType(EmailNotification::TYPE_EVENT_REGISTRATION);
                if ( $notification !== null ) {
                    $parser = new TextParser(array(
                        'site_name'=>$siteUrl,
                        'announce_name'=>$announceName,
                    ));
                    $message = $parser->decode($notification->text);
                    $subject = $parser->decode($notification->subject);
                    $from = $notification->from;
                    Functions::sendMail($subject, $message, $model->email, $from);
                }
                
                Yii::app()->user->setFlash('SUCCESS_EVENT_MESSAGE', 'Спасибо! Ваша заявка принята!');
            }
        }
        $cs=Yii::app()->clientScript;
        $cs->scriptMap=array(
            'jquery.js'=>false,
            'jquery.yiiactiveform.js'=>false
        );
        $this->renderPartial('_eventform', array(
            'model'=>$model,
        ), false, true);
        Yii::app()->end();
    }
    
    protected function performAjaxValidation($model, $ajaxvar = 'component_eventform-form')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$ajaxvar)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}