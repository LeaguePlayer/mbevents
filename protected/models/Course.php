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
    
    private $_viewedLessonsCount;
    
//    public $_freeBasicLessons;
//    public $_payBasicLessons;
//    public $_payAdvancedLessons;


    public static function itemAlias($type, $code = null)
    {
        $_items = array(
			'BlockType' => array(
				self::BLOCK_TYPE_FREE_BASIC => 'Базовый бесплатный',
				self::BLOCK_TYPE_PAY_BASIC => 'Базовый платный',
				self::BLOCK_TYPE_PAY_ADVANCED => 'Расширенный',
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
    }

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
            array('photo_preview', 'CImageValidator', 'types'=>'jpeg, jpg, png, gif'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('description, basic_description, adv_description, preview_description, date_public', 'safe'),
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
            'category'=>array(self::BELONGS_TO, 'Category', 'category_id'),
            'lessons'=>array(self::HAS_MANY, 'Lesson', 'course_id', 'order'=>'lessons.data_sort'),
            'countLessons'=>array(self::STAT, 'Lesson', 'course_id', 'select'=>'count(*)'),
            //'countPayLessons'=>array(self::STAT, 'Lesson', 'course_id',
            //    'select'=>'count(*)', 'scopes'=>array('pay_bsic', 'pay_advanced')),
            'user_courses'=>array(self::HAS_MANY, 'UserCourses', 'course_id',
                //'condition'=>'user_courses.user_id='.Yii::app()->user->id,
                //'params'=>array(':u_ud'=>Yii::app()->user->id)
            ),
            'c_sources'=>array(self::HAS_MANY, 'Source', 'owner_id',
                'condition'=>'c_sources.owner_type='.Source::OWNER_TYPE_COURSE_PAY.' OR c_sources.owner_type='.Source::OWNER_TYPE_COURSE_ADVANCED),
            //'basic_sources'=>array(self::HAS_MANY, 'Source', 'owner_id', 'condition'=>'basic_sources.owner_type='.Source::OWNER_TYPE_COURSE_PAY),
            //'advanced_sources'=>array(self::HAS_MANY, 'Source', 'owner_id', 'condition'=>'advanced_sources.owner_type='.Source::OWNER_TYPE_COURSE_ADVANCED),
            //'count_basic_sources'=>array(self::STAT, 'Source', 'owner_id', 'condition'=>'owner_type='.Source::OWNER_TYPE_COURSE_PAY),
            //'count_advanced_sources'=>array(self::STAT, 'Source', 'owner_id', 'condition'=>'owner_type='.Source::OWNER_TYPE_COURSE_ADVANCED),
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
            'photo_preview' => 'Фото к курсу',
			'basic_cost' => 'Стоимость базовой части',
			'advanced_cost' => 'Стоимость расширенной части',
            'description' => 'Описание курса',
            'basic_description' => 'Описание базовой части',
            'adv_description' => 'Описание расширенной части',
		);
	}
    
//    public function defaultScope()
//    {
//        return array(
//            'with' => array(
//                'category',
//                'lessons',
//                'c_sources',
//            ),
//        );
//    }
    
    public function getSources()
    {
        return $this->c_sources;
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
            'order'=>'t.id',
        ));
        return $courses[0];
    }
    
    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/course/go', array('id'=>$this->id));
    }
    
    public function getBasicLessonsCount()
    {
        return $this->countLessons(array('scopes'=>'free_basic')) + $this->countLessons(array('scopes'=>'pay_basic'));
    }
    
    public function getAdvLessonsCount()
    {
        return $this->countLessons(array('scopes'=>'pay_advanced'));
    }
    
    public function getTotalLessonsCount()
    {
        return $this->getBasicLessonsCount() + $this->getAdvLessonsCount();
    }
    
//    public function getCountSources($block_type = false)
//    {
//        return 0;
//        switch ($block_type) {
//            case 'basic':
//            return $this->count_sources(array('scopes'=>'basic'));
//            break;
//            
//            case 'advanced':
//            return $this->count_sources(array('scopes'=>'advanced'));
//            break;
//            
//            default:
//            return 0;
//        }
//    }

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
    
    public function getBasicSources()
    {
        return $this->c_sources(array('condition'=>'c_sources.owner_type='.Source::OWNER_TYPE_COURSE_PAY));
    }
    
    public function getAdvancedSources()
    {
        return $this->c_sources(array('condition'=>'c_sources.owner_type='.Source::OWNER_TYPE_COURSE_ADVANCED));
    }
    
    public function getTotalBasicSourcesCount()
    {
        $total = count($this->basicSources);
        foreach ( $this->getFreeBasicLessons() as $lesson ) {
            $total += count($lesson->sources);
        }
        foreach ( $this->getPaydBasicLessons() as $lesson ) {
            $total += count($lesson->sources);
        }
        return $total;
    }
    
    public function getTotalAdvancedSourcesCount()
    {
        $total = count($this->advancedSources);
        foreach ( $this->getPaydAdvancedLessons() as $lesson ) {
            $total +=  count($lesson->sources);
        }
        return $total;
    }
    
    public function beforeSave()
    {
        if ( $this->isNewRecord ) {
            $this->date_public = date("Y-m-d H:i:s");
        }
        return parent::beforeSave();
    }
    
    public function isNew()
    {
        // нужно реализовать
        return false;
    }
    
    // Количество просмотренных уроков
    public function getViewedLessonsCount()
    {
        if ( $this->_viewedLessonsCount !== null ) {
            return $this->_viewedLessonsCount;
        }
        $user = Yii::app()->user->model();
        if ( !$user ) {
            $this->_viewedLessonsCount = 0;
            return $this->_viewedLessonsCount;
        }
        $lessons_ids = implode(',', CHtml::listData($this->lessons, 'id', 'id'));
        if ( empty($lessons_ids) ) {
            $this->_viewedLessonsCount = 0;
            return $this->_viewedLessonsCount;
        }
        $this->_viewedLessonsCount = $user->count_r_lessons(array(
            'condition'=>"lesson_id in ({$lessons_ids}) AND current_views > 0",
        ));
        return $this->_viewedLessonsCount;
    }
}