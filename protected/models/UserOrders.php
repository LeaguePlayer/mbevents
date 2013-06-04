<?php

/**
 * This is the model class for table "tbl_user_orders".
 *
 * The followings are the available columns in table 'tbl_user_orders':
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $course_type
 * @property string $date_create
 * @property integer $status
 */
class UserOrders extends CActiveRecord
{
    const STATUS_PAYD = 1;
    const STATUS_WAIT = 0;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserOrders the static model class
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
		return 'tbl_user_orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id, course_type, status', 'required'),
			array('user_id, course_id, course_type, status', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, course_id, course_type, date_create, status', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'course_id' => 'Course',
			'course_type' => 'Course Type',
			'date_create' => 'Date Create',
			'status' => 'Status',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('course_type',$this->course_type);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}