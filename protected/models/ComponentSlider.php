<?php

class ComponentSlider extends AnnounceComponent
{
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_component_slider';
	}
    
    public function getTypeId()
    {
        return self::COMPONENT_TYPE_SLIDER;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function render()
    {
        $controller = AnnounceComponentFactory::CreateController($this->getTypeId());
        if ($controller)
        {
            echo $controller->renderPartial('_view', array('model'=>$this));
        }
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return CMap::mergeArray(parent::rules(), array(
            array('title', 'length', 'max'=>255),
		));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'slides'=>array(self::HAS_MANY, 'Slides', 'slider_id', 'order'=>'slides.id'),
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
    
    public function afterSave()
    {
        $files = CUploadedFile::getInstancesByName('ComponentSlider');
        if ( isset($files) && count($files) > 0 ) {
            foreach ($files as $file) {
                $savepath = $this->saveImage($file);
                if ( $savepath ) {
                    $slide = new Slides;
                    $slide->source = $savepath;
                    $slide->slider_id = $this->id;
                    $slide->save();
                }
            }
        }
        parent::afterSave();
    }
    
    public function saveImage(CUploadedFile $uploadFile)
    {
        $fileInfo = pathinfo($uploadFile->name);
        $fileName = time().'-'.md5($uploadFile->name.time()).'.'.$fileInfo['extension'];
        $savePath = Yii::getPathOfAlias('webroot').'/uploads/previews/slides/'.$fileName;
        if ( $uploadFile->saveAs($savePath) ) {
            return '/uploads/previews/slides/'.$fileName;
        }
        return false;
    }
    
//    public function removeImage($filename)
//    {
//        $file = Yii::getPathOfAlias('webroot').'/uploads/'.$this->image;
//        if ( is_file($file) ) {
//            unlink($file);
//            $this->image = '';
//            return true;
//        }
//    }
    
//    public function getImage($width = false, $height = false, $alt = '')
//    {
//        $options = array();
//        if ($width) $options['width'] = $width;
//        if ($height) $options['height'] = $height;
//        return CHtml::image('/uploads/previews/'.$this->image, $alt, $options);
//    }
    
    public function getThumb($width = 100, $height = 80)
    {
        return CHtml::image("/lib/thumb/phpThumb.php?src=/uploads/previews/{$this->image}&w=$width&h=$height&zc=1&q=90");
    }
}