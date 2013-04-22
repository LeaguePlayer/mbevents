<?php

class PromoCodeForm extends CFormModel
{
    public $promoCode;
    public $email;
    
    public function rules() {
        return array(
            array('promoCode', 'required'),
            array('promoCode', 'validCode'),
        );
    }
    
    public function validCode($attribute,$params)
    {
        $code = PromoCode::model()->findByAttributes(array('code'=>$this->{$attribute}));
        if ( !$code ) {
            $this->addError('promoCode', 'Не верный промо-код');
            return false;
        }
        if ( $code->status == PromoCode::STATUS_USED ) {
            $this->addError('promoCode', 'Промо-код уже использован');
            return false;
        }
        if ( $code->expire != 0 AND time() > $code->expire ) {
            $this->addError('promoCode', 'Истек срок действия промо-кода');
            return false;
        }
        if ( $code->status == PromoCode::STATUS_NOACTIVE ) {
            $this->addError('promoCode', 'Промо-код заблокирован');
            return false;
        }
        return true;
    }

    public function attributeLabels()
    {
        return array (
            'promoCode'=>'Промо-код',
        );
    }
    
}