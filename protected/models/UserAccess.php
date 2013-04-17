<?php

/**
 * This is the model class for table "tbl_user_access".
 *
 * The followings are the available columns in table 'tbl_user_access':
 * @property integer $id
 * @property integer $source_id
 * @property integer $user_id
 * @property string $expire
 * @property integer $uses_number
 * @property integer $date_update
 * @property integer $date_create
 */
class UserAccess extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAccess the static model class
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
		return 'tbl_user_access';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source_id, user_id, expire, uses_number, date_update, date_create', 'required'),
			array('source_id, user_id, uses_number, date_update, date_create', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, source_id, user_id, expire, uses_number, date_update, date_create', 'safe', 'on'=>'search'),
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
			'source_id' => 'Source',
			'user_id' => 'User',
			'expire' => 'Expire',
			'uses_number' => 'Uses Number',
			'date_update' => 'Date Update',
			'date_create' => 'Date Create',
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
		$criteria->compare('source_id',$this->source_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('expire',$this->expire,true);
		$criteria->compare('uses_number',$this->uses_number);
		$criteria->compare('date_update',$this->date_update);
		$criteria->compare('date_create',$this->date_create);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}