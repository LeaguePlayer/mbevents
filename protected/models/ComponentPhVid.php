<?php

/**
 * This is the model class for table "tbl_component_ph_vid".
 *
 * The followings are the available columns in table 'tbl_component_ph_vid':
 * @property integer $id
 * @property integer $component_type
 * @property string $video_source
 * @property string $photo_source
 * @property string $description
 * @property integer $date_create
 * @property integer $date_update
 * @property integer $status
 */
class ComponentPhVid extends AnnounceComponent
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ComponentPhVid the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getTypeId()
    {
        return self::COMPONENT_TYPE_PHOTO_VIDEO;
    }
    
    public function getTitle()
    {
        return "Видео-контент";
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_component_ph_vid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description', 'required'),
            array('photo_source', 'CImageValidator', 'types' => 'jpg, png, gif'),
			array('video_source', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, video_source, photo_source, description, date_create, date_update, status', 'safe', 'on'=>'search'),
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
			'video_source' => 'Ссылка на видео',
			'photo_source' => 'Постер',
			'description' => 'Описание',
			'date_create' => 'Date Create',
			'date_update' => 'Date Update',
			'status' => 'Статус',
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
		$criteria->compare('video_url',$this->video_url,true);
		$criteria->compare('photo_url',$this->photo_url,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create);
		$criteria->compare('date_update',$this->date_update);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}