<?php

class SendArticleForm extends CFormModel
{
    public $email;
    public $article_id;
    
    public function rules() {
        return array(
            array('email', 'required', 'message'=>'Вы не ввели E-mail'),
            array('email', 'email', 'message'=>'Неправильный E-mail'),
            array('article_id', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'email' => 'E-mail',
        );
    }

}