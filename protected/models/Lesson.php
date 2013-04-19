<?php

/**
 * This is the model class for table "tbl_lessons".
 *
 * The followings are the available columns in table 'tbl_lessons':
 * @property integer $id
 * @property string $name
 * @property integer $source
 * @property integer $course_id
 * @property integer $date_create
 * @property string $date_public
 */
class Lesson extends CActiveRecord
{
    public function scopes()
    {
        return array(
            'free_basic'=>array(
                'condition'=>'course_type='.Course::BLOCK_TYPE_FREE_BASIC,
            ),
            'pay_basic'=>array(
                'condition'=>'course_type='.Course::BLOCK_TYPE_PAY_BASIC,
            ),
            'pay_advanced'=>array(
                'condition'=>'course_type='.Course::BLOCK_TYPE_PAY_ADVANCED,
            ),
        );
    }
            
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lesson the static model class
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
		return 'tbl_lessons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, source, date_public', 'required'),
			array('course_id', 'numerical', 'integerOnly'=>true),
            array('source', 'CVideoValidator', 'types'=>'flv, avi, mpeg, mp4'),
			array('source, name', 'length', 'max'=>255),
            array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, source, course_id, date_create, date_public', 'safe', 'on'=>'search'),
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
			'name' => 'Название видео-урока',
			'source' => 'Путь к файлу',
			'course_id' => 'К какому курсу относится',
			'date_create' => 'Дата создания',
            'date_update' => 'Дата последнего изменения',
			'date_public' => 'Дата публикации',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('source',$this->source);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('date_create',$this->date_create);
		$criteria->compare('date_public',$this->date_public,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
    
    protected function afterFind()
    {
        if ( !empty($this->date_public) ) {
            $this->date_public = date('d.m.Y', strtotime($this->date_public));
        }
    }
    
    protected function beforeSave()
    {
        if ( parent::beforeSave() ) {
            $this->date_public = date('Y-m-d', strtotime($this->date_public));
            $this->alias = substr( md5($this->source.time()), 0, 9 );
            return true;
        }
        return false;
    }
    
    public static function getAll()
    {
        return self::model()->findAll('course_id=0');
    }
    
    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/video/out', array('alias'=>$this->alias));
    }
}