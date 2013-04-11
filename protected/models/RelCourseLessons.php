<?php

/**
 * This is the model class for table "tbl_course_lessons".
 *
 * The followings are the available columns in table 'tbl_course_lessons':
 * @property integer $id
 * @property integer $course_id
 * @property integer $lesson_id
 * @property integer $block_type
 * @property integer $data_sort
 */
class RelCourseLessons extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CourseLessons the static model class
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
		return 'tbl_course_lessons';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course_id, lesson_id, block_type', 'required'),
			array('course_id, lesson_id, block_type, data_sort', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, course_id, lesson_id, block_type, data_sort', 'safe', 'on'=>'search'),
		);
	}
    
    public function scopes()
    {
        return array(
            'free_basic'=>array(
                'condition'=>'block_type='.Course::BLOCK_TYPE_FREE_BASIC,
            ),
            'pay_basic'=>array(
                'condition'=>'block_type='.Course::BLOCK_TYPE_PAY_BASIC,
            ),
            'pay_advanced'=>array(
                'condition'=>'block_type='.Course::BLOCK_TYPE_PAY_ADVANCED,
            ),
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
			'course_id' => 'Course',
			'lesson_id' => 'Lesson',
			'block_type' => 'Block Type',
			'data_sort' => 'Data Sort',
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
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('block_type',$this->block_type);
		$criteria->compare('data_sort',$this->data_sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /*
    public function getLastDataSort()
    {
        if ( empty($this->course_id) || empty($this->block_type) ) {
            return 0;
        }
        $tableName = $this->tableName();
        $sql = "SELECT max(data_sort) FROM {$tableName} WHERE course_id=:courseId AND block_type=:blockType";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":courseId", $this->course_id, PDO::PARAM_INT);
        $command->bindParam(":blockType", $this->block_type, PDO::PARAM_INT);
        $lastDataSort = $command->execute();
        return ( is_numeric($lastDataSort) ) ? $lastDataSort + 1 : 0;
    }
    */
    
    protected function beforeSave()
    {
        if ( parent::beforeSave() )
        {
            $lessons = RelCourseLessons::model()->findAllByAttributes(array(
                'lesson_id'=>$this->lesson_id,
                'block_type'=>$this->block_type
            ));
            return true;
        }
        return false;
    }
}