<?php

class RegisterOnEvent extends CActiveRecord
{
    public $name;
    public $phone;
    public $company;
    public $email;
    public $job;
    public $secretkey;
    public $announce_id;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function tableName()
	{
		return 'tbl_reg_on_event';
	}
    
    public function rules() {
        return array(
            array('name, phone, email', 'required'),
            array('email', 'email'),
            array('company, job, secretkey, announce_id', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
			'name' => 'Как Вас зовут?',
			'phone' => 'Номер телефона',
			'company' => 'Ваша компнания',
            'email' => 'E-mail',
			'job' => 'Должность в компании',
			'secretkey' => 'Секретный код',
		);
    }
}