<?php

class SiteController extends Controller
{    
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
    
    public function behaviors()
    {
        return array(
            'articleBehavior' => array(
                'class' => 'AutoLoadArticleBehavior',
            ),
        );
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
//        $urlinfo = parse_url(Yii::app()->request->urlReferrer);
//        
//        if ( $urlinfo['host'] != 'tracyacademy.com' and $urlinfo['host'] != 'mbevents.loc'  ) {
//            $this->redirect($this->createUrl('/course/go', array('id'=>28)));
//        }
				
        $pageVar = 'page';
        
        $coursesData = new CActiveDataProvider('Course', array(
            'pagination'=>array(
                'pageSize'=>1,
                'pageVar' =>$pageVar,
            ),
        ));
        
        $announce = Announce::model()->findActivated();
        $eventForm = new RegisterOnEvent;
        
            $this->render('index', array(
                'announce'=>$announce,
                'coursesData'=>$coursesData,
                'eventForm'=>$eventForm,
            ));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
        $this->layout = '//layouts/column2';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
    
    public function actionRegistrationOnEvent()
    {
        $model = new RegistrationEventForm;
        echo CJavaScript::jsonEncode(array(
            'success'=>false
        ));
    }
    
    
    public function actionTest()
    {
        $this->layout = '//layouts/column2';
        
//        $alias = '0ef4a4aaa.mp4'; //;Yii::app()->request->getQuery('alias');
//        $lesson = Lesson::model()->findByAttributes(array('alias'=>$alias));
//        
//        if ( !$lesson ) {
//            return;
//        }        
//        if ( !$lesson->isAvailable() ) {
//            return;
//        }        
        $this->render('test');
    }
    
    public function actionCallback()
    {
        $this->layout = '//layouts/column2';
        $model = new CallbackForm;
        $isAjax = Yii::app()->request->isAjaxRequest;
        
        if(isset($_POST['CallbackForm']))
		{
			$model->attributes=$_POST['CallbackForm'];
            $response = CActiveForm::validate($model);
            $valid = !$model->hasErrors();
            if ( $isAjax and !$valid ) {
                header('Content-type: application/json');
                echo $response;
                Yii::app()->end();
            }
            if ( $valid ) {
                $domain = $_SERVER['HTTP_HOST'];
                $message = "
                    С сайта http://{$domain} пришла заявка.<br/>
                    <strong>Имя отправителя:</strong> {$model->fio}<br/>
                    <strong>E-mail отправителя:</strong> {$model->email}<br/><br/>
                    <strong> Текст сообщения:</strong> {$model->message}<br/>
                ";
                Functions::sendMail("С сайта http://{$domain} поступила заявка", $message, Yii::app()->params['SUPPORT_EMAIL'], "Академя Брайана Трейси");
                if ( $isAjax ) {
                    Yii::app()->end();
                }
            }
		}
        
        if ( $isAjax ) {
            $this->renderPartial('/site/callbackform', array(
                'model'=>$model,
            ));
            Yii::app()->end();
        }
        $this->render('/site/callbackform', array(
            'model'=>$model,
        ));
    }
    
    public function actionWelcome()
    {
        echo $this->renderPartial('welcome');
    }
    
    public function actionRegister()
    {
        $this->renderPartial('_register');
    }
}