<?php

class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
    
    //public $defaultAction = 'go';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete, addLesson, removeLesson', // we only allow deletion via POST request
            'ajaxOnly + pay',
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','go','buy','pay'),
				'users'=>array('*'),
			),
            array('allow',
                'actions'=>array('my'),
                'users'=>array('@'),
            ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','cancel','addLesson','removeLesson','view', 'admin','delete','manage'),
				'users'=>Yii::app()->getModule('user')->getAdmins(),
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
	public function actionView($operation = '', $id = false)
	{
	}
    
    public function actionGo($id)
    {
        $with = array(
            'category',
            'lessons'=>array(
                'with'=>array(
                    'sources'
                ),
            ),
            'c_sources',
        );
        $pageVar = 'page';
        $model = $this->loadModel($id, $with);
        $this->render('go', array(
            'model'=>$model,
        ));
    }
    
    public function actionCancel($id, $operation = false)
    {
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $this->layout='//layouts/column2';
		$model = new Course;
        $model->title = 'Новый видео-курс';
        
        if ( isset($_POST['Course']) ) {
            $model->setAttributes($_POST['Course']);
            if ( $model->save() ) {
                $this->redirect('/course/admin');
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
        $this->layout='//layouts/column2';
		$model=$this->loadModel($id);

		if ( isset($_POST['Course']) ) {
            $model->setAttributes($_POST['Course']);
            if ( $model->save() ) {
                $this->redirect('/course/admin');
            }
        }
		$this->render('update',array(
			'model'=>$model,
		));
	}
    
    public function actionManage($id)
    {
        $this->layout='//layouts/column2';
        $model = $this->loadModel($id);
        Yii::app()->getClientScript()->registerCssFile( Yii::app()->getClientScript()->getCoreScriptUrl().'/jui/css/base/jquery-ui.css' );
        Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
        Yii::app()->getClientScript()->registerScriptFile( $this->getAssetsBase() .'/js/admin/course.js', CClientScript::POS_END);
		$this->render('manage',array(
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
        $this->layout='//layouts/column2';
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
        
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$pageVar]))
            $_GET[$pageVar] = Yii::app()->request->getPost($pageVar);
            
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

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        $this->layout='//layouts/column2';
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
        $this->layout='//layouts/column2';
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
        $this->layout='//layouts/column2';
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
    
    public function actionBuy($pay_type = 'promo')
    {
        $this->layout='//layouts/column2';
        if ( Yii::app()->user->isGuest ) {
            $regModel = new RegistrationForm('quick');
        }
        echo $this->renderPartial('/promoCode/input', array(
            'model'=>new PromoCodeForm,
            'regModel'=>$regModel,
        ));
    }
    
    public function actionMy($cat = false)
    {        
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'user_courses'=>array(
                'condition'=>'user_courses.user_id='.Yii::app()->user->id,
            ),
            'category',
            'lessons'=>array(
                'with'=>array(
                    'sources'
                ),
            ),
            'c_sources',
        );
        if ($cat) {
            $criteria->addCondition('t.category_id=:cat');
            $criteria->params = CMap::mergeArray($criteria->params, array(':cat'=>$cat));
        }
        $criteria->order = 't.category_id';
        $courses = Course::model()->findAll($criteria);
        
        
        $viewPart = '_my_courses';
        if (count($courses) == 0) {
            if (!$cat) {
                $outLessons = Lesson::model()->getTopLessons();
                $viewPart = '_no_courses';
            } else {
                $outLessons = Yii::app()->user->model()->getLastLessons();
            }
        } else {
            $outLessons = Yii::app()->user->model()->getLastLessons();
        }
        
        
        $this->render('my', array(
            'viewPart'=>$viewPart,
            'courses'=>$courses,
            'outLessons'=>$outLessons,
        ));
    }
    
    public function actionPay() {
        if (isset($_POST['CoursePay'])) {
            $id = $_POST['CoursePay']['course_id'];
            $type = $_POST['CoursePay']['course_type'];
            
        }
    }
}
