<?php

class ArticleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
            'ajaxOnly + sendArticle',
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
				'actions'=>array('index','view','search','load'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update', 'sendArticle'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	public function actionView($id)
	{
        $model = $this->loadModel($id);
        $model->incViews();
        $comment = new Comment;
        $comment->article_id = $model->id;
        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('_load', array(
                'model'=>$model,
                'comment'=>$comment,
            ));
            Yii::app()->end();
        }
        
        $this->render('_load', array(
            'model'=>$model,
            'comment'=>$comment,
        ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $this->layout='//layouts/column2';
        $model=new Article;
        $model->date_public = date('d.m.Y');
        
        $model->send_notifyces = true;
        $siteUrl = 'http://'.$_SERVER['HTTP_HOST'];
        $model->subject_message = "На сайте {$siteUrl} в блог добавлена новая статья";
        $model->notification_message = "На сайт {$siteUrl} по интересующей вас тематике добавлена новая статья.";

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

            if(isset($_POST['Article']))
            {
                $model->attributes=$_POST['Article'];

                if ( isset($_POST['Article']['categories']) ) {
                    $model->newCategories = array_keys($_POST['Article']['categories']);
                }
                if($model->save()) {
                    if ( $model->send_notifyces && $model->status != Article::STATUS_DRAFT ) {
                        $this->sendNotifications($model);
                    }
                    $this->redirect(array('admin'));
                }
            }

        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/jquery.autoresize.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $url.'/js/tags.js', CClientScript::POS_END );
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
//        echo '<pre>';
//        print_r($_POST);
//        echo '</pre>';
//        exit;
        $this->layout='//layouts/column2';
		$model=$this->loadModel($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
        
//        $model->send_notifyces = true;
//        $siteUrl = 'http://'.$_SERVER['HTTP_HOST'];
//        $model->subject_message = "На сайте {$siteUrl} в блог добавлена новая статья";
//        $model->notification_message = "На сайт {$siteUrl} по интересующей вас тематике добавлена новая статья.";

		if(isset($_POST['Article'])) {
                    $oldStatus = $model->status;
//                    $model->setAttributes($_POST['Article']);
//                    $model->send_notifyces = $_POST['Article']['send_notifyces'];
//                    $model->subject_message = $_POST['Article']['subject_message'];
//                    $model->notification_message = $_POST['Article']['notification_message'];
                    
                    $model->attributes=$_POST['Article'];
                    if ( isset($_POST['Article']['categories']) ) {
                        $model->newCategories = array_keys($_POST['Article']['categories']);
                    }
                    if($model->save()) {
                        if ( $oldStatus==Article::STATUS_DRAFT && $model->status != $oldStatus && $model->send_notifyces ) {
                            $this->sendNotifications($model);
                        }
                    }
                    $this->redirect(array('admin'));
		}

        $url = $this->getAssetsBase();
        Yii::app()->clientScript->registerScriptFile( $url.'/js/jquery.autoresize.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $url.'/js/tags.js', CClientScript::POS_END );
		$this->render('update',array(
			'model'=>$model,
		));
	}
    
    public function sendNotifications(Article $article)
    {
        // поиск пользователей для рассылки уведомлений
        $criteria = new CDbCriteria;
        $criteria->addCondition('profile.send_notify=1');
        $partConditions = array();
        foreach ( $article->newCategories as $categoryId ) {
            if ( is_numeric($categoryId) )
                array_push($partConditions, "notifyCats_notifyCats.category_id=".$categoryId);
        }
        $condition = implode(" OR ", $partConditions);
        $criteria->addCondition("(".$condition.")");
        $users = User::model()->with(array('notifyCats','profile'))->active()->findAll($criteria);
        
        $siteUrl = 'http://'.$_SERVER['HTTP_HOST'];
        $articleUrl = $this->createUrl('/lesson/load', array('id'=>$article->id));
        $subject = $article->subject_message;
        $message = $article->notification_message;
        foreach ( $users as $user ) {
            Functions::sendMail($subject, $message, $user->email, "Академия Брайана Трейси");
        }
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
        $this->layout='//layouts/column2';
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
        $model = $this->loadModel($id);
        $model->incViews();
        $comment = new Comment;
        $comment->article_id = $model->id;
        if ( Yii::app()->request->isAjaxRequest ) {
            $this->renderPartial('_load', array(
                'model'=>$model,
                'comment'=>$comment,
            ));
            Yii::app()->end();
        }
        
        $this->render('_load', array(
            'model'=>$model,
            'comment'=>$comment,
        ));
    }
    
    public function actionSendArticle()
    {
        $model = new SendArticleForm;
        $response = array(
            'success' => false,
            'errors' => array(),
        );
        if ( isset($_POST['SendArticleForm']) ) {
            $model->attributes = $_POST['SendArticleForm'];
            if ( $model->validate() ) {
                if ( is_numeric($model->article_id) ) {
                    $article = Article::model()->findByPk($model->article_id);
                    $response['success'] = true;
                    // отправить статью
                    $domain = $_SERVER['HTTP_HOST'];
                    $subject = "Вам прислали статью с сайта http://{$domain}";
                    $message = "<h1>".$article->title."</h1>".$article->full_description;
                    $message .= "<br/><br/><p><strong>Источник: </strong><a href='http://{$domain}/article/{$model->article_id}'>http://{$domain}/article/{$model->article_id}</a></p>";
                    Functions::sendMail($subject, $message, $model->email, Yii::app()->user->email);
                }
            }
            $response['errors'] = $model->errors;
        }
        echo CJSON::encode($response);
    }
    
    protected function performAjaxValidation($model, $ajaxvar = 'article-form')
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$ajaxvar)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
