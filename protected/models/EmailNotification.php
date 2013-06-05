<?php

/**
 * This is the model class for table "email_notifications".
 *
 * The followings are the available columns in table 'email_notifications':
 * @property integer $id
 * @property integer $type
 * @property string $subject
 * @property string $text
 * @property string $from
 */
class EmailNotification extends CActiveRecord
{
    const STATUS_SEND       = 1;
    const STATUS_DONTSEND   = 0;
    
    const TYPE_USER_REGISTRATION   = 1;
    const TYPE_USER_ACTIVATION     = 2;
    const TYPE_EVENT_REGISTRATION  = 3;
    const TYPE_RECOVERY_PASSWORD   = 4;
    const TYPE_ADD_ARTICLE         = 5;
    
    public static function itemAlias($type,$code=NULL) {
		$_items = array(
                    'NoteType' => array(
                        self::TYPE_USER_REGISTRATION => 'После регистрации',
                        self::TYPE_USER_ACTIVATION => 'После активации',
                        self::TYPE_EVENT_REGISTRATION => 'После регистрации на мероприятие',
                        self::TYPE_RECOVERY_PASSWORD => 'Восстановление пароля',
                        self::TYPE_ADD_ARTICLE => 'Добавление статьи в блог',
                    ),
                    'Status' => array(
                        self::STATUS_SEND => 'Да',
                        self::STATUS_DONTSEND => 'Нет',
                    ),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailNotification the static model class
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
		return 'tbl_email_notifications';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('note_type, subject, text', 'required'),
			array('note_type, status', 'numerical', 'integerOnly'=>true),
			array('subject, from', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, note_type, subject, text, from', 'safe', 'on'=>'search'),
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
			'note_type' => 'Тип уведомления',
			'subject' => 'Заголовок',
			'text' => 'Содержание',
			'from' => 'От кого',
                        'status' => 'Отправлять это уведомление?'
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
		$criteria->compare('note_type',$this->note_type);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('from',$this->from,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getUpdateUrl()
    {
        return Yii::app()->urlManager->createUrl('/emailNotification/update', array('id'=>$this->id));
    }
    
    public static function findByType($type)
    {
        return self::model()->findByAttributes(array(
            'note_type'=>$type,
        ));
    }
}