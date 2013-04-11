<?php

/**
 * This is the model class for table "tbl_component_html".
 *
 * The followings are the available columns in table 'tbl_component_html':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $date_create
 * @property integer $date_update
 */
class ComponentHtml extends AnnounceComponent
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ComponentHtml the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_component_html';
	}
    
    public function getTypeId()
    {
        return self::COMPONENT_TYPE_HTML;
    }
    
    public function getTitle()
    {
        return $this->title;
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
			array('title, description', 'required'),
			array('title', 'length', 'max'=>255),
            
			array('id, title, description, date_create, date_update', 'safe', 'on'=>'search'),
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
			'description' => 'Контент',
			'date_create' => 'Дата создания',
			'date_update' => 'Дата редактирования',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create);
		$criteria->compare('date_update',$this->date_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}