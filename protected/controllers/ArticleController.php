<?php

class ArticleController extends Controller
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
				'actions'=>array('index','view','search','load'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Article;
        $model->date_public = date('d.m.Y');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
            
            if ( isset($_POST['Article']['categories']) ) {
                $model->newCategories = array_keys($_POST['Article']['categories']);
            }
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
        

        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/js' );
        Yii::app()->clientScript->registerScriptFile( $url.'/jquery.autoresize.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $url.'/tags.js', CClientScript::POS_END );
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

		if(isset($_POST['Article']))
		{
			$model->setAttributes($_POST['Article']);
            if ( isset($_POST['Article']['categories']) ) {
                $model->newCategories = array_keys($_POST['Article']['categories']);
            }
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/js' );
        Yii::app()->clientScript->registerScriptFile( $url.'/jquery.autoresize.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $url.'/tags.js', CClientScript::POS_END );
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
	public function actionIndex($tag = false)
	{
        $criteria=new CDbCriteria(array(
            'condition'=>'status='.Article::STATUS_SHARED_ACCESS,
            'order'=>'date_update DESC',
            'with'=>'commentCount',
        ));
        if ( $tag ) {
            $criteria->addSearchCondition('tags', $tag);
        }
		$dataProvider=new CActiveDataProvider('Article', array(
            'pagination'=>array(
                'pageSize'=>5,
            ),
            'criteria'=>$criteria,
        ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Article('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Article']))
			$model->attributes=$_GET['Article'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Article the loaded model
	 * @throws CHttpException
	 */
    private $_model;
	public function loadModel($id)
	{
		if ( $this->_model !== null )
            return $this->_model;
  
        if (is_numeric($id)) {
            $criteria = new CDbCriteria;
            if ( Yii::app()->user->isGuest ) {
                $criteria->condition = 'status='.Article::STATUS_SHARED_ACCESS;
            } else if ( Yii::app()->user->isAdmin() ) {
                $criteria->condition = '';
            } else {
                $criteria->condition = 'status='.Article::STATUS_SHARED_ACCESS.' OR status='.Article::STATUS_LIMITED_ACCESS;
            }
            $criteria->with = array('categories');
            $this->_model = Article::model()->findByPk($id, $condition);
        }
        
        if ($this->_model === null)
            throw new CHttpException(404, 'Запрашиваемая страница не найдена');
 
        return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Article $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionSearch()
    {
        $search = new SiteSearchForm;
        if(isset($_POST['SiteSearchForm'])) {
            $search->attributes = $_POST['SiteSearchForm'];
            $_GET['searchString'] = $search->string;
        } else {
            $search->string = $_GET['searchString'];
        }
        
        $model = new Article;
        $model->full_description = $search->string;
        $this->processPageRequest('page');
        
        if ( Yii::app()->request->isAjaxRequest ) {
            echo $this->renderPartial('/site/_loopAjax', array(
                'dataProvider'=>$model->search(),
                'itemView'=>'_view',
            ));
            Yii::app()->end();
        }
        
        $this->render('found', array(
            'dataProvider'=>$model->search(),
            'form'=>$search,
        ));
    }
    
    protected function processPageRequest($param = 'page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
    
    
    public function actionLoad($id)
    {
        $model = Article::model()->findByPk($id);
        if ( !$model ) {
            throw new CHttpException(404);
        }
        echo $this->renderPartial('_load', array(
            'model'=>$model,
        ));
        Yii::app()->end();
    }
}
