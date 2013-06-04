<?php

/**
 * This is the model class for table "tbl_reviews".
 *
 * The followings are the available columns in table 'tbl_reviews':
 * @property integer $id
 * @property string $fio
 * @property string $content
 * @property string $photo
 * @property string $job
 * @property integer $date_create
 */
class Reviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reviews the static model class
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
		return 'tbl_reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fio, content, job', 'required'),
			array('fio, job', 'length', 'max'=>255),
            array('photo', 'CImageValidator', 'types'=>'jpg, png, gif'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fio, content, photo, job, date_create', 'safe', 'on'=>'search'),
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
			'fio' => 'ФИО',
			'content' => 'Отзыв',
            'job' => 'Должность',
            'photo' => 'Фото',
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
		$criteria->compare('fio',$this->fio,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('job',$this->job,true);
		$criteria->compare('date_create',$this->date_create);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}