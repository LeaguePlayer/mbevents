<?php

/**
 * This is the model class for table "tbl_promo_codes".
 *
 * The followings are the available columns in table 'tbl_promo_codes':
 * @property integer $id
 * @property string $code
 * @property integer $expire
 * @property integer $last_update
 * @property integer $status
 */
class PromoCode extends CActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOACTIVE = 2;
    const STATUS_USED = 3;
    
    public static function getAllStatuses()
    {
        return array(
            0 => 'Без статуса',
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_NOACTIVE => 'Не активен',
            self::STATUS_USED => 'Использован',
        );
    }
    
    public function getStatus()
    {
        $statuses = self::getAllStatuses();
        return $statuses[$this->status];
    }
    
    public $count;
    public $expire_date;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PromoCode the static model class
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
		return 'tbl_promo_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('count', 'required', 'on'=>'generate'),
			array('expire, last_update, status', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>255),
            array('expire_date', 'date', 'format'=>array('dd.MM.yyyy')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, expire, last_update, status', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'User', 'owner', 'select'=>'user.id, user.email'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Код',
			'expire' => 'Действителен до',
			'last_update' => 'Last Update',
			'status' => 'Статус',
            'count' => 'Количество',
            'expire_date' => 'Действителен до',
            'use_date' => 'Когда задействован'
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('expire',$this->expire);
		$criteria->compare('last_update',$this->last_update);
		$criteria->compare('status',$this->status);
        $criteria->order = 't.status DESC, t.last_update';
        $criteria->with = 'user';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>100,
            )
		));
	}
    
    protected function beforeSave()
    {
        if ( parent::beforeSave() ) {
            if ( empty($this->code) ) {
                do {
                    $this->generateCode();
                } while($this->isRepeatCode());
            }
            $this->last_update = time();
            if ( $this->isNewRecord ) {
                $this->status = self::STATUS_ACTIVE;
            }
            return true;
        }
        return false;
    }
    
    
    protected $_usedCodes;
    protected function isRepeatCode()
    {
        if ( $this->_usedCodes===null ) {
            $this->_usedCodes = CHtml::listData( self::model()->findAll(), 'id', 'code' );
        }
        foreach( $this->_usedCodes as $code ) {
            if( $this->code === $code ) {
                return true;
            }
        }
        return false;
    }
    
    protected function generateCode($length = 8)
    {
        $result = '';
        $string = 'abcdefghijlklmnopqrstuvwxyzABCDEFGHIJLKLMNOPQRSTUVWXYZ1234567890';
        $n = strlen($string) - 1;
        for ($i=0; $i<$length; $i++)
        {
            $result .= $string[rand(0, $n)];
        }        
        $this->code = $result;
    }
    
    public function getFormattedDate($attributeDate)
    {
        return date( 'd F Y', strtotime($this->{$attributeDate}) );
    }
}