<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 */

    // напрвления деятельности пользователя
    // $careers_array через геттер возвращает список текущих направлений
    // $new_careers_array хранит обновленные значения направлений деятельности
    protected $careers_array;
    protected $new_careers_array;
    public function setCareersArray($value)
    {
        $this->careers_array = $value;
    }
    public function getCareersArray()
    {
        if ($this->careers_array === null)
            $this->careers_array = CHtml::listData($this->careers, 'id', 'id');
        return $this->careers_array;
    }
    public function setNewCareersArray($value)
    {
        $this->new_careers_array = $value;
    }
    public function getNewCareersArray()
    {
        return $this->new_careers_array;
    }
    
    
    
    // наиболее интересные категории
    protected $categories_array;
    protected $new_categories_array;
    public function setCategoriesArray($value)
    {
        $this->categories_array = $value;
    }
    public function getCategoriesArray()
    {
        if ($this->categories_array === null)
            $this->categories_array = CHtml::listData($this->categories, 'id', 'id');
        return $this->categories_array;
    }
    public function setNewCategoriesArray($value)
    {
        $this->new_categories_array = $value;
    }
    public function getNewCategoriesArray()
    {
        return $this->new_categories_array;
    }
    
    
    
    // по каким категориям отправлять уведомления
    protected $notify_cats_array;
    protected $new_notify_cats_array;
    public function setNotifyCatsArray($value)
    {
        $this->notify_cats_array = $value;
    }
    public function getNotifyCatsArray()
    {
        if ($this->notify_cats_array === null)
            $this->notify_cats_array = CHtml::listData($this->notifyCats, 'id', 'id');
        return $this->notify_cats_array;
    }
    public function setNewNotifyCatsArray($value)
    {
        $this->new_notify_cats_array = $value;
    }
    public function getNewNotifyCatsArray()
    {
        return $this->new_notify_cats_array;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('username', 'length', 'max'=>30, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('email, superuser, status', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status', 'safe', 'on'=>'search'),
            array('newCareersArray, newCategoriesArray, newNotifyCatsArray', 'safe'),
//            array('send_notify', 'numerical', 'integerOnly'=>true),
//            array('send_notify', 'in', 'range'=>array(0,1)),
		):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
            array('newCareersArray, newCategoriesArray, newNotifyCatsArray', 'safe'),
//            array('send_notify', 'numerical', 'integerOnly'=>true),
//            array('send_notify', 'in', 'range'=>array(0,1)),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        $relations['careers'] = array(self::MANY_MANY, 'Career', 'tbl_user_careers(user_id, career_id)');
        $relations['categories'] = array(self::MANY_MANY, 'Category', 'tbl_user_categories(user_id, category_id)');
        $relations['notifyCats'] = array(self::MANY_MANY, 'Category', 'tbl_user_notify_categories(user_id, category_id)');
        $relations['r_courses'] = array(self::HAS_MANY, 'UserCourses', 'user_id');
        $relations['r_lessons'] = array(self::HAS_MANY, 'UserLessons', 'user_id');
        $relations['count_r_lessons'] = array(self::STAT, 'UserLessons', 'user_id');
        $relations['count_available_lessons'] = array(self::STAT, 'UserLessons', 'user_id', 'condition'=>'available=1');
        $relations['promocodes'] = array(self::HAS_MANY, 'PromoCode', 'owner', 'order'=>'promocodes.use_date');
        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>'Придумайте пароль',//UserModule::t("password"),
			'verifyPassword'=>'Еще раз пароль',//UserModule::t("Retype Password"),
			'email'=>'Введите свой e-mail',//UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>$this->tableAlias.'.status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>$this->tableAlias.'.status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>$this->tableAlias.'.status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>$this->tableAlias.'.superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
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
        $criteria->with = array('profile', 'promocodes');
                
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        $criteria->compare('verify_link',$this->profile->verify_link);

        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }
    
    protected function afterSave()
    {
        $this->refreshCareers();
        $this->refreshCategories();
        $this->refreshNotifyCats();
        parent::afterSave();
    }
    
    protected function refreshCareers()
    {
        $newCareers = $this->new_careers_array;
        
        if ( $newCareers === null ) {
            return;
        }
        
        UserCareers::model()->deleteAllByAttributes(array('user_id'=>$this->id));
        if (is_array($newCareers))
        {
            foreach ($newCareers as $id)
            {
                if (Career::model()->exists('id=:id', array(':id'=>$id)))
                {                
                    $userCareer = new UserCareers();
                    $userCareer->user_id = $this->id;
                    $userCareer->career_id = $id;
                    $userCareer->save();
                }
            }
            $this->careers_array = $this->new_careers_array;
        }
    }
    
    protected function refreshCategories()
    {
        $newCategories = $this->new_categories_array;
        
        if ( $newCategories === null ) {
            return;
        }
        
        UserCategories::model()->deleteAllByAttributes(array('user_id'=>$this->id));
        if (is_array($newCategories))
        {
            foreach ($newCategories as $id)
            {
                if (Category::model()->exists('id=:id', array(':id'=>$id)))
                {                
                    $userCategory = new UserCategories();
                    $userCategory->user_id = $this->id;
                    $userCategory->category_id = $id;
                    $userCategory->save();
                }
            }
            $this->categories_array = $this->new_categories_array;
        }
    }
    
    protected function refreshNotifyCats()
    {
        $newNotifyCats = $this->new_notify_cats_array;
        
        if ( $newNotifyCats === null ) {
            return;
        }
        
        UserNotifyCategories::model()->deleteAllByAttributes(array('user_id'=>$this->id));
        if (is_array($newNotifyCats))
        {
            foreach ($newNotifyCats as $id)
            {
                if (Category::model()->exists('id=:id', array(':id'=>$id)))
                {
                    $userCategory = new UserNotifyCategories();
                    $userCategory->user_id = $this->id;
                    $userCategory->category_id = $id;
                    $userCategory->save();
                }
            }
            $this->notify_cats_array = $this->new_notify_cats_array;
        }
    }
    
    public function getLastLessons()
    {
        $lastLessons = $this->r_lessons(array(
            'select'=>'lesson_id, date_last_view',
            'order'=>'date_last_view DESC',
            'limit'=>3,
        ));
        foreach ($lastLessons as $lesson) {
            $lessons_ids[] = $lesson->lesson_id;
        }
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $lessons_ids);
        return Lesson::model()->findAll($criteria);
    }
}