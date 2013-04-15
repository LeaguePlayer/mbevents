<?php

class CourseController extends Controller
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
			'postOnly + delete, addLesson, removeLesson', // we only allow deletion via POST request
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
				'actions'=>array('index','go'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','cancel','addLesson','removeLesson','view'),
				'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($operation = '')
	{
        $id = Yii::app()->request->getQuery('id');
        $with = array('lessons');
        switch ($operation) {
            case '':
                $model = $this->loadModel($id, $with);
                break;
                
            case 'edit':
                $model = $this->loadModel($id, $with);
                break;
                
            case 'new':
                $model = new Course;
                $model->title = 'Новый видео-курс';
                $model->save();
                break;
                
            default:
                throw new CHttpException(400, 'Неверный запрос');
        }
        
        if ( isset($_POST['Course']) ) {
            $model->setAttributes($_POST['Course']);
            if ( $model->save() ) {
                $this->redirect('/course/admin');
            }
        }
        
        Yii::app()->getClientScript()->registerCssFile( Yii::app()->getClientScript()->getCoreScriptUrl().'/jui/css/base/jquery-ui.css' );
        Yii::app()->getClientScript()->registerCssFile( CHtml::asset( Yii::getPathOfAlias('webroot').'/css').'/admin.css' );
        Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/js/admin/' );
        Yii::app()->getClientScript()->registerScriptFile($url.'/course.js', CClientScript::POS_END);
       
		$this->render('view',array(
			'model'=>$model,
            'operation'=>$operation,
		));
	}
    
    public function actionGo($id)
    {
        $model = $this->loadModel($id);
        $this->render('go', array('model'=>$model));
    }
    
    public function actionCancel($id, $operation = false)
    {
        $model = $this->loadModel($id);
        if ($model) {
            switch ($operation) {
                case 'new':
                    $model->delete();
                    break;
                    
                case 'edit':
                    //$model->back();
                    break;
                default:
                    // ничего не делаем
                    ;
            }
        }
        $this->redirect('/course/admin');
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Course;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['Course']))
		{
			$model->attributes=$_POST['Course'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	 * Lists all models.
	 */
	public function actionIndex($category = false)
	{
        // Вывести курсы по категориям
        // Если категория не указана, вывести курсы для всех категорий
        
        $criteria = new CDbCriteria;
        $criteria->with = array('category', 'lessons');
        $pageVar = 'page';
        $this->processPageRequest($pageVar);
		$dataProvider=new CActiveDataProvider('Course', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>1,
                'pageVar' =>$pageVar,
            ),
        ));
        
        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial('/site/_loopAjax', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'/course/_view',
            ));
            Yii::app()->end();
        }
        
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
    
    
    
    
    
    
    protected function processPageRequest($param = 'page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Course('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Course']))
			$model->attributes=$_GET['Course'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Course the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $with = false)
	{
        if ( $with ) {
            $model=Course::model()->with($with)->findByPk($id);
        } else {
            $model=Course::model()->findByPk($id);
        }
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Course $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionAddLesson()
    {
        $response = array(
            'success'=>false,
            'errors'=>array()
        );
        if ( isset($_POST['Lesson']) )
        {
            $lessonId = $_POST['Lesson']['id'];
            $courseId = $_POST['Lesson']['course_id'];
            $courseType = $_POST['Lesson']['course_type'];
            
            $model = Lesson::model()->findByPk($lessonId);
            if (!$model) {
                $response['errors'][] = 'Видеоурок не найден';
            } else {
                $model->course_id = $courseId;
                $model->course_type = $courseType;
                if ( $model->save(false) ) {
                    $response['success'] = true;
                } else {
                    $response['errors'] = $model->errors;
                }
            }
        }
        echo CJSON::encode($response);
    }
    
    public function actionRemoveLesson()
    {
        $response = array(
            'success'=>false,
            'errors'=>array()
        );
        if ( isset($_POST['Lesson']) )
        {
            $lessonId = $_POST['Lesson']['id'];
            
            $model = Lesson::model()->findByPk($lessonId);
            if (!$model) {
                $response['errors'][] = 'Видеоурок не найден';
            } else {
                $model->course_id = 0;
                $model->course_type = 0;
                if ( $model->save(false) ) {
                    $response['success'] = true;
                } else {
                    $response['errors'] = $model->errors;
                }
            }
        }
        echo CJSON::encode($response);
    }
}
