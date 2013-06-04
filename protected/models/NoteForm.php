<?php
class NoteForm extends CFormModel
{
    public $email;
    public $note;
    public $lesson_id;
    
    public function rules() {
        return array(
            array('email', 'required', 'message'=>'Вы не ввели E-mail'),
            array('email', 'email', 'message'=>'Неправильный E-mail'),
            array('note', 'safe'),
            array('lesson_id', 'safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'email'=>'E-mail',
            'note'=>'Оставьте заметку к видео',
        );
    }

}