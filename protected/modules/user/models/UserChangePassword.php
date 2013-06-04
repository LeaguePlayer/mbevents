<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel {
	public $oldPassword;
	public $password;
	public $verifyPassword;
	
	public function rules() {
		return array(
			array('password, verifyPassword', 'required', 'on'=>'recovery'),
			array('password, verifyPassword', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols)."), 'on'=>'recovery'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect."), 'on'=>'recovery'),
            
			//array('oldPassword, password, verifyPassword', 'required'),
			array('oldPassword, password, verifyPassword', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols)."), 'on'=>'change'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect."), 'on'=>'change'),
			array('oldPassword', 'verifyOldPassword', 'on'=>'change'),
        );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'oldPassword'=>'Старый пароль',
			'password'=>'Новый пароль',
			'verifyPassword'=>'Повторите новый пароль',
		);
	}
	
	/**
	 * Verify Old Password
	 */
    public function verifyOldPassword($attribute, $params)
    {
        if (!empty($this->password)) {
            if (User::model()->notsafe()->findByPk(Yii::app()->user->id)->password != Yii::app()->getModule('user')->encrypting($this->$attribute))
                $this->addError($attribute, UserModule::t("Old Password is incorrect."));
        }
    }
}