<?php

/**
 * This is the model class for table "tbl_favorites".
 *
 * The followings are the available columns in table 'tbl_favorites':
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property integer $post_type
 */
class Favorite extends CActiveRecord
{
    const POST_TYPE_CATEGORY = 1;
    const POST_TYPE_ARTICLE  = 2;
    
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Favorite the static model class
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
		return 'tbl_favorites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, post_id, post_type', 'required'),
			array('user_id, post_id, post_type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, post_id, post_type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        //Yii::import('application.modules.user.models.*');
		return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
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
			'post_id' => 'Post',
			'post_type' => 'Post Type',
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
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('post_type',$this->post_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getFavoritesByPostType($postType, $userId)
    {
        if ( !is_numeric($postType) ) {
            return array();
        }
        
        $criteria = new CDbCriteria;
        $criteria->addCondition('post_type='.$postType);
        if ( is_numeric($userId) AND $userId > 0 ) {
            $criteria->addCondition('user_id='.$userId);
        }
        $favorites = Favorites::model()->findAll($criteria);
        return $favorites;
    }
}