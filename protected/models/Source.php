<?php

/**
 * This is the model class for table "tbl_sources".
 *
 * The followings are the available columns in table 'tbl_sources':
 * @property integer $id
 * @property string $path
 * @property integer $owner_id
 * @property integer $owner_type
 * @property integer $date_create
 */
class Source extends CActiveRecord
{
    const OWNER_TYPE_LESSON = 1;
    const OWNER_TYPE_COURSE_FREE = 2;
    const OWNER_TYPE_COURSE_PAY = 3;
    const OWNER_TYPE_COURSE_ADVANCED = 4;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Source the static model class
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
		return 'tbl_sources';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('path', 'required'),
			array('owner_id, owner_type, date_create', 'numerical', 'integerOnly'=>true),
			array('path', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, path, owner_id, owner_type, date_create', 'safe', 'on'=>'search'),
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
			'path' => 'Путь к файлу',
			'owner_id' => 'Owner',
			'owner_type' => 'Owner Type',
			'date_create' => 'Дата создания',
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
		$criteria->compare('path',$this->path,true);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('owner_type',$this->owner_type);
		$criteria->compare('date_create',$this->date_create);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function scopes()
    {
        return array(
            'basic'=>array(
                'condition'=>'owner_type='.self::OWNER_TYPE_COURSE_PAY,
            ),
            'advanced'=>array(
                'condition'=>'owner_type='.self::OWNER_TYPE_COURSE_ADVANCED,
            ),
        );
    }
    
    public function getSize()
    {
        return '';
    }
    
    public function getDownloadUrl()
    {
        return Yii::app()->urlManager->createUrl('/source/download', array('id'=>$this->id));
    }
}