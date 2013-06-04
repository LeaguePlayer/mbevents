<?php

/**
 * This is the model class for table "tbl_slides".
 *
 * The followings are the available columns in table 'tbl_slides':
 * @property integer $id
 * @property integer $slider_id
 * @property string $source
 */
class Slides extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Slides the static model class
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
		return 'tbl_slides';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source', 'required'),
			array('slider_id', 'numerical', 'integerOnly'=>true),
			array('source', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, slider_id, source', 'safe', 'on'=>'search'),
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
			'slider_id' => 'Слайдер',
			'source' => 'Путь к изображению',
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
		$criteria->compare('slider_id',$this->slider_id);
		$criteria->compare('source',$this->source,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getImage($width = false, $height = false, $alt = '')
    {
        $options = array();
        if ($width) $options['width'] = $width;
        if ($height) $options['height'] = $height;
        return CHtml::image($this->source, $alt, $options);
    }
    
    public function getThumb($width = 100, $height = 80)
    {
        return CHtml::image("/lib/thumb/phpThumb.php?src={$this->source}&w=$width&h=$height&zc=1&q=90");
    }
}