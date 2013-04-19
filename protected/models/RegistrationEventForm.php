<?php

class RegistrationEventForm extends CFormModel
{
    public $name;
    public $phone;
    public $company;
    public $email;
    public $office;
    public $secretcode;
    
    
    public function rules() {
        return array(
            array('name, phone, email, secretcode', 'required'),
            array('email', 'email'),
            array('company, office', 'safe'),
        );
    }
    
    public function safeAttributes() {
    }

    public function attributeLabels()
    {
        return array(
			'name' => 'Как Вас зовут?',
			'phone' => 'Номер телефона',
			'company' => 'Ваша компнаия',
            'email' => 'E-mail',
			'office' => 'Должность в компании',
			'secretcode' => 'Секретный код',
		);
    }
}