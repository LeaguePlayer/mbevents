<?php

class ComponentReviews extends AnnounceComponent
{
    private $_reviews;
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_component_reviews';
	}
    
    public function getTypeId()
    {
        return self::COMPONENT_TYPE_REVIEWS;
    }
    
    public function getTitle()
    {
        return empty($this->title) ? 'Отзывы' : $this->title;
    }
    
    public function render()
    {
        $controller = AnnounceComponentFactory::CreateController($this->getTypeId());
        if ($controller)
        {
            echo $controller->renderPartial('_view', array('model'=>$this));
        }
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('reviews_ids', 'safe'),
		);
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
    
    public function getReviews()
    {
        if ( $this->_reviews === null ) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', explode(',', $this->reviews_ids));
            $this->_reviews = Reviews::model()->findAll($criteria);
        }
        return $this->_reviews;
    }
}