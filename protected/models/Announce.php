<?php

/**
 * This is the model class for table "tbl_announces".
 *
 * The followings are the available columns in table 'tbl_announces':
 * @property integer $id
 */
class Announce extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Announce the static model class
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
		return 'tbl_announces';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('title', 'length', 'max'=>255),
			array('id, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array (
            '_relComponents' => array(self::HAS_MANY, 'RelAnnounceComponent', 'announce_id', 'order'=>'date_create'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'title' => 'Заголовок'
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

		$criteria->compare('title',$this->title);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getComponents()
    {
        $componnets = array();
        foreach ($this->_relComponents as $relComponent)
        {
            $controller = AnnounceComponentFactory::CreateController($relComponent->component_type);
            $model = $controller->loadModel($relComponent->component_id);
            if ($model) {
                array_push($componnets, $model);
            }
        }
        return $componnets;
    }
    
    protected function afterDelete()
    {
        parent::afterDelete();
        foreach ($this->getComponents() as $component) {
            $component->delete();
        }
    }
    
    public static function activate($id)
    {
        Announce::model()->updateAll(array('activated'=>false));
        Announce::model()->updateByPk($id, array('activated'=>true));
    }
    
    public static function findActivated()
    {
        return Announce::model()->find('activated=1');
    }
}