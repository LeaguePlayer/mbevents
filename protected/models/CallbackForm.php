<?php

class CallbackForm extends CFormModel
{
    public $fio;
    public $email;
    public $message;
    
    public function rules() {
        return array(
            array('email', 'required'),
            array('fio', 'length', 'max'=>256),
            array('email', 'email'),
            array('message', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'fio'=>'Ваше ФИО',
            'email'=>'Ваш e-mail',
            'message'=>'Сообщение',
        );
    }
}