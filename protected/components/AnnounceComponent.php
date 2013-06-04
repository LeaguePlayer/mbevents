<?php

abstract class AnnounceComponent extends CActiveRecord
{
    const COMPONENT_TYPE_PHOTO_VIDEO = 1;
    const COMPONENT_TYPE_HTML        = 2;
    const COMPONENT_TYPE_SPIEKERS    = 3;
    const COMPONENT_TYPE_REVIEWS     = 4;
    const COMPONENT_TYPE_EVENT_FORM  = 5;
    const COMPONENT_TYPE_SLIDER      = 6;
    
    private $_announceId;
    public $position;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
//    public function relations()
//	{
//		return array(
//            'r_component'=>array(self::BELONGS_TO, 'RelAnnounceComponent', 'component_id',
//                'condition'=>'component_type='.$this->getTypeId().' AND announce_id='.$this->_announceId),
//            //'announce'=>array(self::MANY_MANY, 'Announce', 'tbl_announce_component(announce_id, component_id)'),
//		);
//	}
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date_create',
                'updateAttribute' => 'date_update',
            )
        );
    }
    
    public function rules()
    {
        return array(
            array('position', 'numerical', 'integerOnly'=>true),
        );
    }
    
    public static function getTypeNames()
    {
        $names = array(
            self::COMPONENT_TYPE_PHOTO_VIDEO => 'Фото/видео',
            self::COMPONENT_TYPE_HTML => 'Html',
            self::COMPONENT_TYPE_SPIEKERS => 'Спикеры',
            self::COMPONENT_TYPE_REVIEWS => 'Отзывы',
            self::COMPONENT_TYPE_EVENT_FORM => 'Форма регистрации на мероприятие',
            self::COMPONENT_TYPE_SLIDER => 'Слайдер',
        );
        return $names;
    }
        
    public function getTypeName()
    {
        $names = self::getTypeNames();
        return $names[$this->getTypeId()];
    }
    
    public function setAnnounceId($announceId)
    {
        $this->_announceId = $announceId;
    }
    
    public function getAnnounceId()
    {
        if ( $this->_announceId === null ) {
            $rAnnComp = RelAnnounceComponent::model()->findByAttributes(array(
                'component_id'=>$this->id,
                'component_type'=>$this->getTypeId(),
            ));
            if ( $rAnnComp ) {
                $this->_announceId = $rAnnComp->announce_id;
            }
        }
        return $this->_announceId;
    }
    
    public function afterSave()
    {
        parent::afterSave();
        if ( !isset($this->_announceId) ) {
            return;
        }
        if ( $this->isNewRecord ) {
            $relAnnounceComponent = new RelAnnounceComponent;
            $relAnnounceComponent->announce_id = $this->_announceId;
            $relAnnounceComponent->component_id = $this->id;
            $relAnnounceComponent->component_type = $this->getTypeId();
            $relAnnounceComponent->position = $this->position;
            $relAnnounceComponent->save();
            return;
        }
        if ( !empty($this->position) ) {
            $relAnnounceComponent = RelAnnounceComponent::model()->findByAttributes(array(
                'component_id'=>$this->id,
                'component_type'=>$this->getTypeId(),
                'announce_id'=>$this->_announceId,
            ));
            if ( !$relAnnounceComponent ) {
                throw new CHttpException(404, 'Не найден компонент');
            }
            $relAnnounceComponent->position = $this->position;
            $relAnnounceComponent->save();
        }
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        RelAnnounceComponent::model()->deleteAll('component_id='.$this->id.' AND component_type='.$this->getTypeId());
    }
    
    abstract function getTypeId();
    abstract function getTitle();
    abstract function render();
}