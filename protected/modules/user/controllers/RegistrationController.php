<?php
// ushfdsdjsdgh

class RegistrationController extends Controller
{
    public $layout='//layouts/column2';
	public $defaultAction = 'registration';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
    
    // десериализация строки параметров в массив
    public function serializeString($string) {
        $arr = explode('&', urldecode($string));
        $result = array();
        foreach ($arr as $part) {
            $nameVal = explode('=', $part);
            
            $name = $nameVal[0];
            $value = $nameVal[1];
            
            $pos1 = strpos($name, '[');
            $key = substr($name, 0, $pos1);
            
            $pos2 = strpos($name, ']');
            $subkey = substr($name, $pos1+1, $pos2-$pos1-1);
            
            $len = strlen($name);
            if (strpos($name, '[]', $len - 2)==false) {
                $result[$key][$subkey] = $value;
            } else {
                $result[$key][$subkey][] = $value;
            }
        }
        return $result;
    }

	/**
	 * Registration user
	 */
	public function actionRegistration() {
            $model = new RegistrationForm('default');
            $profile = new Profile;
            $profile->regMode = true;
            
            // Установка начальных значений из куков
            $is_cookie = isset(Yii::app()->request->cookies['registration_info']->value);
            if ($is_cookie) {
                $values = $this->serializeString(Yii::app()->request->cookies['registration_info']->value);
                $model->setAttributes($values['RegistrationForm']);
                $model->careersArray = empty($values['RegistrationForm']['careersArray']) ? array() : $values['RegistrationForm']['careersArray'];
                $model->categoriesArray = empty($values['RegistrationForm']['categoriesArray']) ? array() : $values['RegistrationForm']['categoriesArray'];
                $model->notifyCatsArray = empty($values['RegistrationForm']['notifyCatsArray']) ? array() : $values['RegistrationForm']['notifyCatsArray'];
                $profile->setAttributes($values['Profile']);
            }
            
            // Проверка на ajax
            $isAjax = Yii::app()->request->isAjaxRequest && isset($_POST['ajax']) && $_POST['ajax']==='registration-form';
            
			// ajax validator
			if($isAjax)
			{
                // уточняем шаг регистрации
                $current_step = $_POST['current_step'];
                if ( $current_step == '2' ) {
                    $model->setScenario('step2');
                } else {
                    $model->setScenario('default');
                }
                // уточняем не последний ли это шаг
                $itsFinishStep = isset($_POST['its_finish_step']);
                $response = UActiveForm::validate(array($model,$profile));
                $valid = !$model->hasErrors() && !$profile->hasErrors();
                
                if ( !$valid ) {
                    echo $response;
                    Yii::app()->end();
                }
			}
			
		    if (Yii::app()->user->id) {
                if ( $isAjax ) {
                    $result['status'] = 'user_autorized';
                    echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
                    Yii::app()->end();
                }
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	if(isset($_POST['RegistrationForm'])) {
					$model->attributes = $_POST['RegistrationForm'];
                    $registrationInfo['user'] = $_POST['RegistrationForm'];
                    
                    if ( empty($model->username) ) {
                        $model->username = Functions::generateKey(10);
                    }
                    $model->newCareersArray = $_POST['RegistrationForm']['careersArray'];
                    $model->newCategoriesArray = $_POST['RegistrationForm']['categoriesArray'];
                    $model->newNotifyCatsArray = $_POST['RegistrationForm']['notifyCatsArray'];
                    
                    if ( isset($_POST['Profile']) ) {
                        $profile->attributes = $_POST['Profile'];
                        $registrationInfo['profile'] = $_POST['Profile'];
                    }
                    if ( !empty($profile->verify_link) && strpos($profile->verify_link, 'http://') !== 0 ) {
                        $profile->verify_link = 'http://'.$profile->verify_link;
                    }
					if($model->validate()&&$profile->validate())
					{
                        if ( $isAjax && !$itsFinishStep ) {
                            $result['status'] = 'current_valid';
                            echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
                            Yii::app()->end();
                        }
						$soucePassword = $model->password;
						$model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0;
						$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						
						if ($model->save()) {
							$profile->user_id=$model->id;
							$profile->save();
							if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
								UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
							}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
                                    if ( $isAjax ) {
                                        $result['status'] = 'logined';
                                        $result['refresh'] = true;
                                        echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
                                        Yii::app()->end();
                                    }
									$this->redirect(Yii::app()->controller->module->returnUrl);
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
								    // Здесь отправить письмо о правилах активации аккаунта
                                    $site_name = Yii::app()->name;
                                    $domain = $_SERVER['HTTP_HOST'];
                                    $notification = EmailNotification::findByType(EmailNotification::TYPE_USER_REGISTRATION);
                                    if ( $notification !== null ) {
                                        $parser = new TextParser(array(
                                            'site_name'=>"http://{$domain}",
                                            'user_password'=>$soucePassword,
                                            'user_login'=>$model->email,
                                        ));
                                        $message = $parser->decode($notification->text);
                                        $subject = $parser->decode($notification->subject);
                                        $from = $notification->from;
                                        Functions::sendMail($subject, $message, $model->email, $from);
                                    }
									Yii::app()->user->setFlash('registration','Спасибо за регистрацию! На Ваш почтовый ящик выслано письмо с инструкцией по активации Вашего аккаунта.');
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
								}
                                if ( $isAjax ) {
                                    $result['status'] = 'saved';
                                    $result['message'] = Yii::app()->user->getFlash('registration');
                                    echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
                                    Yii::app()->end();
                                }
								$this->refresh();
							}
						}
					} else $profile->validate();
                    
                    // Обновление регистрационных данных в куках
                    //Yii::app()->request->cookies['registration_info'] = new CHttpCookie('registration_info', $registrationInfo);
				}
                
                if ( Yii::app()->request->isAjaxRequest ) {
                    echo $this->renderPartial('/user/registration',array('model'=>$model,'profile'=>$profile));
                    Yii::app()->end();
                }
                
			    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
		    }
	}
}