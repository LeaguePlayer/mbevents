<?php

abstract class AnnounceComponent extends CActiveRecord
{
    const COMPONENT_TYPE_PHOTO_VIDEO = 1;
    const COMPONENT_TYPE_HTML        = 2;
    
    private $_announceId;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function relations()
	{
		return array(
            //'announce'=>array(self::MANY_MANY, 'Announce', 'tbl_announce_component(announce_id, component_id)'),
		);
	}
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date_create',
                'updateAttribute' => 'date_update',
            )
        );
    }
    
    public static function getTypeNames()
    {
        $names = array(
            self::COMPONENT_TYPE_PHOTO_VIDEO => 'Фото/видео',
            self::COMPONENT_TYPE_HTML => 'Html',
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
    
    public function afterSave()
    {
        parent::afterSave();
        
        if ( !isset($this->_announceId) ) {
            return;
        }
        
        $relAnnounceComponent = new RelAnnounceComponent;
        $relAnnounceComponent->announce_id = $this->_announceId;
        $relAnnounceComponent->component_id = $this->id;
        $relAnnounceComponent->component_type = $this->getTypeId();
        $relAnnounceComponent->save();
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