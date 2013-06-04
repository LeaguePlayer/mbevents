<?php

class LoginController extends Controller
{
    public $layout='//layouts/column2';
    public $defaultAction = 'login';
    public $validBackUrl;        

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        $this->setBackUrl();
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				if($model->validate()) {
					$this->lastViset();
                    $this->redirect($this->validBackUrl);
//					if (Yii::app()->user->returnUrl=='/index.php')
//						$this->redirect(Yii::app()->controller->module->returnUrl);
//					else
//						$this->redirect(Yii::app()->user->returnUrl);
				} else {
				    Yii::app()->user->setFlash("INVALID_LOGIN_OR_PASSWORD", "Вы ввели неверный логин или пароль");
				}
			}
            
            $this->redirect('/');
			// display the login form
			//$this->render('/user/login',array('model'=>$model, 'backUrl'=>$this->validBackUrl));
		} else {
            $this->redirect($this->validBackUrl);
		}
			//$this->redirect(Yii::app()->controller->module->returnUrl);
	}
    
    public function actionAjaxLogin()
    {
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			if(isset($_POST['UserLogin']))
			{
                $response = array(
                    'success'=>false,
                    'error'=>'',
                );
				$model->attributes=$_POST['UserLogin'];
				if($model->validate()) {
					$this->lastViset();
                    $response['success'] = true;
				} else {
				    $response['error'] = 'Вы ввели неверный логин или пароль';
				}
                echo function_exists('json_encode') ? json_encode($response) : CJSON::encode($response);
                Yii::app()->end();
			}
		} else {
            ;
		}
        $this->renderPartial('/user/_ajaxLogin', array(
            'model'=>$model,
        ));
    }
    
    private function setBackUrl()
    {
        if ( isset($_POST['UserLogin']['backUrl']) ) {
            $this->validBackUrl = $_POST['UserLogin']['backUrl'];
            return;
        }
        
        $urlinfo = parse_url(Yii::app()->request->urlReferrer);
        if ( strpos($urlinfo['path'], 'user/login') !== false ) {
            $this->validBackUrl = '/';
        } else {
            $this->validBackUrl = Yii::app()->request->urlReferrer;
        }
    }
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}
}