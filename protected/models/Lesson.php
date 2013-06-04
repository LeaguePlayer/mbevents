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
    const MAX_VIEWS_VALUE = 60;
    
    const STATUS_FOR_ALL        = 0;
    const STATUS_FOR_REGISTERED = 1;
    const STATUS_FOR_MANUAL     = 2;
    
    private $_viewsCounter;
    private $_leftViewsCounter;
    private $_closeDate;
    
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
            'with_sources'=>array(
                'with'=>array(
                    'sources'
                ),
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
            array('poster', 'CImageValidator', 'types'=>'jpeg, jpg, png, gif'),
			array('source, name, poster', 'length', 'max'=>255),
            array('description, date_last_view', 'safe'),
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
            'user_access'=>array(self::HAS_MANY, 'UserLessons', 'lesson_id'),
            'course'=>array(self::BELONGS_TO, 'Course', 'course_id'),
            'sources'=>array(self::HAS_MANY, 'Source', 'owner_id', 'condition'=>'sources.owner_type='.Source::OWNER_TYPE_LESSON),
            'countSources'=>array(self::STAT, 'Source', 'owner_id', 'condition'=>'owner_type='.Source::OWNER_TYPE_LESSON),
		);
	}
    
//    public function defaultScope()
//    {
//        return array(
//            'with' => array(
//                'sources'
//            ),
//        );
//    }

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
            'poster' => 'Постер к видео-уроку',
            'description' => 'Комментарий к курсу',
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
        $criteria->order = 't.course_id, t.course_type';

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
            // jwplayer принимает только ссылки, содержащие расширение файла
            $this->alias = substr( md5($this->source.time()), 0, 9 ).'.mp4';
            return true;
        }
        return false;
    }
    
    public static function detached()
    {
        return self::model()->findAll('t.course_id=0');
    }
    
    public function getUrl()
    {
        return Yii::app()->urlManager->createUrl('/lesson/view', array('id'=>$this->id));
    }
    
    public function getMediaUrl()
    {
        return Yii::app()->urlManager->createUrl('/video/out', array('alias'=>$this->alias));
    }
    
    public function updateViewsCounter()
    {
        // Общий счетчик просмотров
        $this->updateCounters(array('views'=>1), 'id=:id', array(':id'=>$this->id));
        $user = Yii::app()->user->model();
        if ( !$user ) {
            return;
        }
        // Обновление счетчика в таблице tbl_user_lessons, управляющей доступом к просмотру
        $r_lessons = $user->r_lessons(array('condition'=>'r_lessons.lesson_id='.$this->id));
        if ( empty($r_lessons) && $this->isFree() ) {
            $rLess = new UserLessons;
            $rLess->user_id = Yii::app()->user->id;
            $rLess->lesson_id = $this->id;
            $rLess->max_views = 9999;
            $rLess->current_views = 1;
            $rLess->available = true;
            $rLess->date_close = 0;
            $rLess->date_last_view = time();
            $rLess->save();
        } else {
            foreach ($r_lessons as $r_lesson) {
                if ( !$this->isFree() && ($r_lesson->current_views >= $r_lesson->max_views) ) {
                    $r_lesson->available = false;
                }
                $r_lesson->current_views++;
                $r_lesson->date_last_view = date("Y-m-d H:i:s");
                $r_lesson->save(false);
                // сделать только для одной записи
                break;
            }
        }
        // Обновление счетчика просмотров 
    }
    
    // Вернуть количество просмотров
    public function getViewsCounter()
    {
        if ( $this->_viewsCounter !== null ) {
            return $this->_viewsCounter;
        }
        $user = Yii::app()->user->model();
        if ( !$user ) {
            $this->_viewsCounter = $this->views;
            return $this->_viewsCounter;
        }
        $r_lessons = $user->r_lessons(array('condition'=>'r_lessons.lesson_id='.$this->id));
        if ( empty($r_lessons) && $this->isFree() ) {
            $rLess = new UserLessons;
            $rLess->user_id = $user->id;
            $rLess->lesson_id = $this->id;
            $rLess->max_views = 9999;
            $rLess->current_views = 0;
            $rLess->available = true;
            $rLess->date_close = 0;
            $rLess->save();
            $this->_viewsCounter = 0;
            return $this->_viewsCounter;
        } else {
            foreach ($r_lessons as $r_lesson) {
                $this->_viewsCounter = $r_lesson->current_views;
                return $this->_viewsCounter;
            }
        }
            
    }
    
    // Сколько просмотров осталось
    public function getLeftViewsCounter()
    {
        if ( $this->_leftViewsCounter !== null ) {
            return $this->_leftViewsCounter;
        }
        if ( $this->isFree() ) {
            $this->_leftViewsCounter = 9999;
            return $this->_leftViewsCounter;
        }
        $user = Yii::app()->user->model();
        if ( !$user ) {
            $this->_leftViewsCounter = 9999;
            return $this->_leftViewsCounter;
        }
        $r_lessons = $user->r_lessons(array('condition'=>'r_lessons.lesson_id='.$this->id));
        foreach ($r_lessons as $r_lesson) {
            $this->_leftViewsCounter = $r_lesson->max_views - $this->getViewsCounter();
            return $this->_leftViewsCounter;
        }
    }
    
    public function getCloseDate()
    {
        if ( $this->_closeDate !== null ) {
            return $this->_closeDate;
        }
        if ( $this->isFree() ) {
            $this->_closeDate = false;
            return $this->_closeDate;
        }
        $user = Yii::app()->user->model();
        if ( !$user ) {
            $this->_closeDate = false;
            return $this->_closeDate;
        }
        $r_lessons = $user->r_lessons(array('condition'=>'r_lessons.lesson_id='.$this->id));
        foreach ($r_lessons as $r_lesson) {
            $this->_closeDate = Functions::getCalendarDay(strtotime($r_lesson->date_close));
            return $this->_closeDate;
        }
    }
    
    // принадлежит ли видеоурок бесплатной секции курса?
    public function isFree()
    {
        return $this->course_type == Course::BLOCK_TYPE_FREE_BASIC;
    }
    
    // принадлежит ли видеоурок платной базовой секции курса?
    public function isPayBasic()
    {
        return $this->course_type == Course::BLOCK_TYPE_PAY_BASIC;
    }
    
    // принадлежит ли видеоурок расширенной секции курса?
    public function isPayAdvanced()
    {
        return $this->course_type == Course::BLOCK_TYPE_PAY_ADVANCED;
    }
    
    // открыть доступ к видеуроку для пользователя
    public function allowAccess()
    {
        if ( Yii::app()->user->isGuest ) {
            return false;
        }
        $userLesson = UserLessons::model()->findByAttributes(array(
            'user_id'=>20,//Yii::app()->user->id,
            'lesson_id'=>$this->id,
        ));
        if ( !$userLesson ) {
            $userLesson = new UserLessons;
        }
        $userLesson->user_id = Yii::app()->user->id;
        $userLesson->lesson_id = $this->id;
        $userLesson->max_views = UserLessons::MAX_VIEWS_VALUE;
        $userLesson->current_views = 0;
        $userLesson->date_close = date('Y-m-d', strtotime('+365 days'));
        $userLesson->alias = $this->alias;
        $userLesson->available = true;
        if ( $userLesson->save(false) ) {
            $userCourses = UserCourses::model()->findByAttributes(array(
                'user_id'=>Yii::app()->user->id,
                'course_id'=>$this->course->id,
            ));
            if (!$userCourses) {
                $userCourses = new UserCourses;
                $userCourses->ref_count = 0;
            }
            $userCourses->user_id = Yii::app()->user->id;
            $userCourses->course_id = $this->course->id;
            $userCourses->level = $this->course_type;
            $userCourses->available = true;
            $userCourses->ref_count += 1;
            return $userCourses->save(false);
        };
        return false;
    }
    
    // закрыть доступ к видеуроку для текущего пользователя
    public function denyAccess()
    {
        if ( Yii::app()->user->isGuest ) {
            return false;
        }
        $userLesson = UserLessons::model()->findByAttributes(array(
            'user_id'=>Yii::app()->user->id,
            'lesson_id'=>$this->id,
        ));
        if ( !$userLesson ) {
            return false;
        }
        $userLesson->available = false;
        $userLesson->save();
        $userCourses = UserCourses::model()->findByAttributes(array(
            'user_id'=>Yii::app()->user->id,
            'course_id'=>$this->course->id,
        ));
        if ($userCourses) {
            $userCourses->ref_count -= 1;
            if ($userCourses->ref_count == 0) {
                $userCourses->available = false;
            }
            $userCourses->save();
        }
    }
    
    public function isAvailable()
    {
        if ( $this->isFree() ) {
            return true;
        }
        $user = Yii::app()->user->model();
        if ( !$user ) {
            return false;
        }
        $userLessons = $user->r_lessons(array(
            'condition'=>'r_lessons.lesson_id=:l_id AND r_lessons.available=1',
            'params'=>array(':l_id'=>$this->id),
        ));
        $isAvailable = ( count($userLessons) > 0 );
        if ( !$isAvailable ) {
            return false;
        }
        return true;
    }
    
    public function OwnerName()
    {
        $result = $this->course->title;
        if ( empty($result) )
            return '-';
        
        $result .= ( ' ('.Course::itemAlias('BlockType', $this->course_type).')' );
        return $result;
    }
    
    public static function getTopLessons()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'views DESC';
        $criteria->limit = 5;
        return Lesson::model()->findAll($criteria);
    }
}