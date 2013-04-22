<?php

class PromoCodeController extends Controller
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
			'postOnly + delete, generate, enter', // we only allow deletion via POST request
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
				'actions'=>array('enter'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('generate', 'index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
        $criteria = new CDbCriteria;
        $criteria->addCondition('status='.PromoCode::STATUS_ACTIVE);
		$models = PromoCode::model()->findAll($criteria);
		$this->render('index',array(
			'models'=>$models,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PromoCode('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PromoCode']))
			$model->attributes=$_GET['PromoCode'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PromoCode the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PromoCode::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
    
    public function actionGenerate()
    {
        $model = new PromoCode('generate');
        
        $this->performAjaxValidation($model);

		if(isset($_POST['PromoCode']))
		{
			$model->attributes=$_POST['PromoCode'];
			if($model->validate()) {
                $expire = ( empty($model->expire_date) ) ? 0 : strtotime($model->expire_date);
                for ( $i = 0; $i < $model->count; ++$i ) {
                    $code = new PromoCode();
                    $code->expire = $expire;
                    $code->save();
                }
			}
		}
    }

	/**
	 * Performs the AJAX validation.
	 * @param PromoCode $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='promo-code-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    
    public function actionEnter()
    {        
        $modelForm = new PromoCodeForm;
        $response = array(
            'success'=>false,
            'errors'=>array(),
        );
        
        if ( isset($_POST['PromoCodeForm']) ) {
            $modelForm->setAttributes($_POST['PromoCodeForm']);
            $validProcess = $modelForm->validate();
            if ( !$validProcess ) {
                $response['errors'] = array_merge($response['errors'], $modelForm->errors);
            }
            
            if ( Yii::app()->user->isGuest AND isset($_POST['RegistrationForm']) ) {
                // Зарегистрировать и авторизовать пользователя
                $regModel = new RegistrationForm('quick');
                $regModel->setAttributes($_POST['RegistrationForm']);
                
                if ( !$regModel->validate() ) {
                    $validProcess = false;
                    $response['errors'] = array_merge($response['errors'], $regModel->errors);
                }
                if ( $validProcess ) {
                    $regModel->username = $regModel->email;
        			$soucePassword = $regModel->password;
        			$regModel->activkey=UserModule::encrypting(microtime().$regModel->password);
        			$regModel->password=UserModule::encrypting($regModel->password);
        			$regModel->verifyPassword=UserModule::encrypting($regModel->verifyPassword);
        			$regModel->superuser=0;
        			$regModel->status=User::STATUS_ACTIVE;
                    
        			if ( $validProcess = $regModel->save() ) {
                        $profile=new Profile;
                        $profile->regMode = true;
        				$profile->user_id=$regModel->id;
        				$profile->save(false);
                        $identity=new UserIdentity($regModel->username,$soucePassword);
        				$identity->authenticate();
        				Yii::app()->user->login($identity);
                        $domain = $_SERVER['HTTP_HOST'];
                        Functions::sendMail("Пароль для входа на сайт http:{$domain}", "Вы зарегестрированы на сайте http:{$domain}. Ваш пароль: {$soucePassword}. Ваш логин: {$regModel->email}", $regModel->email, "no-repeat@{$domain}");
                    }
                }
            }
            if ( Yii::app()->user->isGuest ) {
                $validProcess = false;
            }
            
            if ( $validProcess ) {
                // дать необходимые доступы
                $courses = Course::model()->findAll();
                foreach ( $courses as $course ) {
                    $lessons = $course->getLessonsByType(Course::BLOCK_TYPE_PAY_BASIC);
                    foreach ( $lessons as $lesson ) {
                        $lesson->allowAccess();
                    }
                }
                $promoCode = PromoCode::model()->findByAttributes(array('code'=>$modelForm->promoCode));
                if ( $promoCode ) {
                    $promoCode->status = PromoCode::STATUS_USED;
                    $promoCode->use_date = date('Y-m-d H:i');
                    $promoCode->save();
                }
                $response['success'] = true;
            }
        }      
        
        echo CJavaScript::jsonEncode($response);
    }
}
