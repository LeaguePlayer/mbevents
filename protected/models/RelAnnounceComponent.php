<?php

/**
 * This is the model class for table "tbl_announce_components".
 *
 * The followings are the available columns in table 'tbl_announce_components':
 * @property integer $id
 * @property integer $announce_id
 * @property integer $component_id
 * @property integer $component_type
 * @property integer $date_create
 */
class RelAnnounceComponent extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnnounceComponent the static model class
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
		return 'tbl_announce_components';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
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
//			'announce_id' => 'Announce',
//			'component_id' => 'Component',
//			'component_type' => 'Component Type',
//			'date_create' => 'Date Create',
		);
	}
    
    public function afterFind()
    {
        
    }
    
    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date_create',
            )
        );
    }
}