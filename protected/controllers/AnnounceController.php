<?php

class AnnounceController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','cancel'),
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
        switch ($operation) {
            case '':
                $model = $this->loadModel($id);
                break;
                
            case 'new':
                $model = new Announce;
                $model->title = 'Новый анонс';
                $model->save();
                break;
                
            case 'edit':
                $model = $this->loadModel($id);
                break;
                
            default:
                throw new CHttpException(400, 'Неверный запрос');
        }
        
        if ( isset($_POST['Announce']) ) {
            $model->setAttributes($_POST['Announce']);
            $model->save();
            $this->redirect('admin');
        }
        
        if ( $operation==='new' OR $operation==='edit' ) {
            $url = CHtml::asset(Yii::getPathOfAlias('application.views.announce.assets'));
            Yii::app()->clientScript->registerCssFile($url.'/admin.css');
            Yii::app()->clientScript->registerScriptFile($url.'/admin.js', CClientScript::POS_END);
        }
        
		$this->render('view',array(
			'model'=>$model,
            'operation'=>$operation,
		));
	}
    
    
    public function actionCancel($announceId, $operation = false)
    {        
        $model = Announce::model()->findByPk($announceId);
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
        $this->redirect('admin');
    }
    

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Announce;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Announce']))
		{
			$model->attributes=$_POST['Announce'];
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

		if(isset($_POST['Announce']))
		{
			$model->attributes=$_POST['Announce'];
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
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Announce');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Announce('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Announce']))
			$model->attributes=$_GET['Announce'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Announce the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Announce::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Announce $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='announce-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
