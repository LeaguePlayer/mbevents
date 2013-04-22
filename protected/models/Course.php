<?php

/**
 * This is the model class for table "tbl_courses".
 *
 * The followings are the available columns in table 'tbl_courses':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $video_preview
 * @property double $basic_cost
 * @property double $advanced_cost
 */
class Course extends CActiveRecord
{
    const BLOCK_TYPE_FREE_BASIC = 1;
    const BLOCK_TYPE_PAY_BASIC = 2;
    const BLOCK_TYPE_PAY_ADVANCED = 3;

    public $acessLevel = self::BLOCK_TYPE_FREE_BASIC;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Courses the static model class
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
		return 'tbl_courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('category_id', 'numerical', 'integerOnly'=>true),
			array('basic_cost, advanced_cost', 'numerical'),
			array('title, video_preview', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('description, basic_description, adv_description, preview_description', 'safe'),
			array('id, category_id, title, video_preview, basic_cost, advanced_cost', 'safe', 'on'=>'search'),
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
            'category'=>array(self::BELONGS_TO, 'Category', 'category_id', 'order'=>'category.name'),
            'lessons'=>array(self::HAS_MANY, 'Lesson', 'course_id', 'order'=>'lessons.data_sort'),
            'countLessons'=>array(self::STAT, 'Lesson', 'course_id', 'select'=>'count(*)'),
            //'countPayLessons'=>array(self::STAT, 'Lesson', 'course_id',
            //    'select'=>'count(*)', 'scopes'=>array('pay_bsic', 'pay_advanced')),
            'user_courses'=>array(self::HAS_MANY, 'UserCourses', 'course_id',
                //'condition'=>'user_courses.user_id='.Yii::app()->user->id,
                //'params'=>array(':u_ud'=>Yii::app()->user->id)
            ),
            'basic_sources'=>array(self::HAS_MANY, 'Source', 'owner_id', 'condition'=>'owner_type='.Source::OWNER_TYPE_COURSE_PAY),
            'advanced_sources'=>array(self::HAS_MANY, 'Source', 'owner_id', 'condition'=>'owner_type='.Source::OWNER_TYPE_COURSE_ADVANCED),
            'count_sources'=>array(self::STAT, 'Source', 'owner_id', 'select'=>'count(*)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_id' => 'Тематика',
			'title' => 'Название курса',
			'video_preview' => 'Ссылка на youtube с видео-обращением',
            'preview_description' => 'Описание к видео-обращению',
			'basic_cost' => 'Стоимость базовой части',
			'advanced_cost' => 'Стоимость расширенной части',
            'description' => 'Описание курса',
            'basic_description' => 'Описание базовой части',
            'adv_description' => 'Описание расширенной части',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('video_preview',$this->video_preview,true);
		$criteria->compare('basic_cost',$this->basic_cost);
		$criteria->compare('advanced_cost',$this->advanced_cost);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getFreeBasicLessons()
    {
        return $this->lessons(array('scopes'=>'free_basic'));
    }
    
    public function getPaydBasicLessons()
    {
        return $this->lessons(array('scopes'=>'pay_basic'));
    }
    
    public function getPaydAdvancedLessons()
    {
        return $this->lessons(array('scopes'=>'pay_advanced'));
    }
    
    public function getLessonsByType($blockType = false)
    {      
        switch ( $blockType ) {
            case self::BLOCK_TYPE_FREE_BASIC:
                return $this->getFreeBasicLessons();
                break;
            
            case self::BLOCK_TYPE_PAY_BASIC:
                return $this->getPaydBasicLessons();
                break;
            
            case self::BLOCK_TYPE_PAY_ADVANCED:
                return $this->getPaydAdvancedLessons();
                break;
            
            default:
                return $this->lessons;
        }
    }
    
    protected function afterDelete()
    {
        foreach ( $this->lessons as $lesson )
        {
            $lesson->course_id = 0;
            $lesson->course_type = 0;
            $lesson->save(false);
        }
        parent::afterDelete();
    }
    
    public function getCountAvailableLessons()
    {
        $user = UserModule::user();
        if ( !$user ) {
            return 0;
        }
        return $user->count_available_lessons;
    }
    
    public static function findTop()
    {
        $courses = self::model()->findAll(array(
            'order'=>'id',
        ));
        return $courses[0];
    }
    
    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/course/go', array('id'=>$this->id));
    }
    
    public function getCountSources($block_type = false)
    {
        switch ($block_type) {
            case 'basic':
            return $this->count_sources(array('scopes'=>'basic'));
            break;
            
            case 'advanced':
            return $this->count_sources(array('scopes'=>'advanced'));
            break;
            
            default:
            return 0;
        }
    }

    protected function afterFind()
    {
        $userCourses = $this->user_courses(array(
                'condition'=>'user_id=:u_id',
                'params'=>array(':u_id'=>Yii::app()->user->id),
        ));
        foreach ( $userCourses as $userCourse ) {
            if ( $userCourse->available ) {
                $this->acessLevel = $userCourse->level;
            }
            break;
        }
    }
}