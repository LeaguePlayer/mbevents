<?php

class ComponentRegOnEvent extends AnnounceComponent
{    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_component_eventform';
	}
    
    public function getTypeId()
    {
        return self::COMPONENT_TYPE_EVENT_FORM;
    }
    
    public function getTitle()
    {
        return empty($this->title) ? 'Регистрация на мероприятие' : $this->title;
    }
    
    public function render($disableSubmit = false)
    {
        $controller = AnnounceComponentFactory::CreateController($this->getTypeId());
        if ($controller)
        {
            $eventForm = new RegisterOnEvent;
            $eventForm->announce_id = $this->getAnnounceId();
            echo $controller->renderPartial('_view', array(
                'model'=>$this,
                'eventForm'=>$eventForm,
                'disableSubmit'=>$disableSubmit,
            ));
        }
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(), array(
            array('title', 'length', 'max'=>255),
        ));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'title' => 'Заголовок',
		);
	}
}