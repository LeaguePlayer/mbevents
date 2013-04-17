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

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $pageVar = 'page';
        $this->processPageRequest($pageVar);
       
        $blogDataProvider = new CActiveDataProvider('Article', array(
            'pagination'=>array(
                'pageSize'=>1,
                'pageVar' =>$pageVar,
            ),
        ));
        
        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$blogDataProvider,
                'itemView'=>'/article/_view',
            ));
            Yii::app()->end();
        }
        
        $announce = Announce::findActivated();
        $courses = Course::model()->findAll();
        
		$this->render('index', array(
            'blogDataProvider'=>$blogDataProvider,
            'announce'=>$announce,
            'courses'=>$courses,
        ));
	}
    
    protected function processPageRequest($param = 'page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}