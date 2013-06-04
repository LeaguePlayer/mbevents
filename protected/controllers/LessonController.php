<?php

class LessonController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'ajaxOnly + sendNote',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index', 'view', 'sendNote'),
				'users'=>array('*'),
			),
//			array('allow',
//				'actions'=>array('sendNote'),
//				'users'=>array('@'),
//			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Lesson;
        $model->date_public = date('d.m.Y');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Lesson']))
		{
			$model->attributes=$_POST['Lesson'];
			if($model->save()) {
                $this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Lesson']))
		{
			$model->attributes=$_POST['Lesson'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Lesson('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lesson']))
			$model->attributes=$_GET['Lesson'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lesson the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Lesson::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Lesson $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionView()
    {
        $id = Yii::app()->request->getQuery('id');
        $model = Lesson::model()->with('user_access')->findByPk($id);
        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial('_view', array('model'=>$model));
            Yii::app()->end();
        }
        $this->render('_view', array('model'=>$model));
    }
    
    public function actionSendNote()
    {
        $model = new NoteForm;
        $response = array(
            'success' => false,
            'errors' => array(),
        );
        if ( isset($_POST['NoteForm']) ) {
            $model->attributes = $_POST['NoteForm'];
            if ( $model->validate() ) {
                if ( is_numeric($model->lesson_id) ) {
                    $lesson = Lesson::model()->findByPk($model->lesson_id);
                    $response['success'] = true;
                    // отправить статью
                    $domain = $_SERVER['HTTP_HOST'];
                    $subject = "Заметка к видео-сессии {$lsson->name} с сайта http://{$domain}";
                    $message = "<h1>Заметка к видео-сессии {$lesson->name}</h1><p>{$model->note}</p>";
                    Functions::sendMail($subject, $message, $model->email, Yii::app()->user->email);
                }
            }
            $response['errors'] = $model->errors;
        }
        echo CJSON::encode($response);
    }
}
