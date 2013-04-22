<?php

/**
 * This is the model class for table "tbl_user_lessons".
 *
 * The followings are the available columns in table 'tbl_user_lessons':
 * @property integer $id
 * @property integer $user_id
 * @property integer $lesson_id
 * @property integer $max_views
 * @property integer $current_views
 * @property string $date_close
 * @property string $date_open
 * @property string $alias
 */
class UserLessons extends CActiveRecord
{
    const MAX_VIEWS_VALUE = 60;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserLessons the static model class
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
		return 'tbl_user_lessons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lesson_id, max_views, current_views, date_close', 'required'),
			array('user_id, lesson_id, max_views, current_views', 'numerical', 'integerOnly'=>true),
			array('alias', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, lesson_id, max_views, current_views, date_close, date_open, alias', 'safe', 'on'=>'search'),
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
            'lesson'=>array(self::BELONGS_TO, 'Lesson', 'lesson_id'),
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
			'lesson_id' => 'Lesson',
			'max_views' => 'Max Views',
			'current_views' => 'Current Views',
			'date_close' => 'Date Close',
			'date_open' => 'Date Open',
			'alias' => 'Alias',
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
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('max_views',$this->max_views);
		$criteria->compare('current_views',$this->current_views);
		$criteria->compare('date_close',$this->date_close,true);
		$criteria->compare('date_open',$this->date_open,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    protected function beforeSave()
    {
        if ( !parent::beforeSave() ) {
            return false;
        }
        if ( $this->isNewRecord ) {
            $this->date_open = date('Y-m-d');
        }
        return true;
    }
}