<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
	
	public function rules() {
		$rules = array(
			array('password, verifyPassword, email', 'required', 'on'=>'default'),
            array('email, password, verifyPassword', 'required', 'on'=>'quick'),
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols)."),'on'=>'default, quick'),
			array('email', 'email', 'on'=>'default, quick'),
			//array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists."), 'on'=>'default, quick'),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
            //array('newCareersArray', 'safe', 'on' => 'default'),
            array('newCategoriesArray, newNotifyCatsArray', 'unsafe', 'on'=>'default'),
            array('password, verifyPassword, email', 'safe', 'on'=>'step2'),
            //array('send_notify', 'boolean', 'on' => 'step2'),
		);
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration'), 'on'=>'default'));
		}
		
		array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect."), 'on'=>'default, quick'));
		return $rules;
	}
}