<?php

/**
 * This is the model class for table "tbl_article".
 *
 * The followings are the available columns in table 'tbl_article':
 * @property integer $id
 * @property string $title
 * @property string $short_description
 * @property string $full_description
 * @property string $date_public
 * @property string $date_create
 * @property string $image
 * @property string $tags
 * @property integer $status
 */
class Article extends CActiveRecord
{
    const STATUS_DRAFT = 1; // черновик
    const STATUS_SHARED_ACCESS = 2; // опубликовано в общей ленте
    const STATUS_LIMITED_ACCESS = 3; // опубликовано только для зарегестрированных
    
    private $_oldTags = '';
    private $_oldCategoriesIds = array();
    private $_newCategoriesIds = array();
    
    public $send_notifyces;
    public $subject_message;
    public $notification_message;
    
    // атрибуты поиска
    public $isSearch = false;
    public $searchCategories;
    public $searchString;
    public $searchTags;
    
    public static function statuses($code = false)
    {
        $statuses = array(
            self::STATUS_DRAFT => 'Черновик',
            self::STATUS_SHARED_ACCESS => 'Опубликовать в общей ленте',
            self::STATUS_LIMITED_ACCESS => 'Опубликовать только для зарегестрированных',
        );
        if ( $code && is_numeric($code) )
        {
            return $statuses[$code];
        }
        return $statuses;
    }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return 'tbl_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, full_description, date_public, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('title, image', 'length', 'max'=>255),
                        array('short_description, image, tags, notification_message, send_notifyces, subject_message', 'safe'),
                        // Для того, чтобы паттерн корректно сработал, приводим тэги в кодировку UTF-8
                        array('tags', 'match', 'pattern'=>'/^[A-Za-zА-Яа-я\s,]+$/u',
                            'message'=>'В тегах можно использовать только буквы.'),
                        array('tags', 'normalizeTags'),
                        array('date_public', 'date', 'format'=>array('dd.MM.yyyy')),
                        //array('date_public', 'normalizeDate'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('isSearch, searchCategories, searchString, searchTags', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
                    'author'=>array(self::BELONGS_TO, 'User', 'user_id'),
                    'rel_categories'=>array(self::HAS_MANY, 'ArticleCategory', 'article_id'),
                    'categories'=>array(self::MANY_MANY, 'Category', ArticleCategory::tableName().'(article_id, category_id)'),
                    'comments'=>array(
                        self::HAS_MANY, 
                        'Comment', 
                        'article_id',
                        'condition'=>'comments.status='.Comment::STATUS_APPROVED,
                        'order'=>'comments.date_create DESC',
                    ),
                    'commentCount' => array(
                        self::STAT, 
                        'Comment', 
                        'article_id',
                        'condition'=>'status='.Comment::STATUS_APPROVED
                    ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Заголовок',
			'short_description' => 'Краткое описание',
			'full_description' => 'Полное описание',
			'date_public' => 'Когда опубликовать',
			'date_create' => 'Дата создания',
			'image' => 'Изображение',
			'tags' => 'Тэги',
			'status' => 'Статус',
                        'send_notifyces' => 'Разослать уведомления пользователям?',
                        'notification_message' => 'Текст сообщения для рассылки',
                        'subject_message' => 'Тема сообщения',
		);
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
    
    public function getUrl()
    {
        return Yii::app()->createUrl('article/view', array(
            'id'=>$this->id,
            'title'=>$this->title,
        ));
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($providerOptions = array())
	{
		$criteria=new CDbCriteria;
        $criteria->order = 'date_public DESC';
        if (!Yii::app()->user->isAdmin()) {
            $criteria->addCondition('t.status<>'.Article::STATUS_DRAFT);
        }
        if ( Yii::app()->user->isGuest ) {
            $criteria->addCondition('t.status='.Article::STATUS_SHARED_ACCESS);
        }
        $criteria->with = array('commentCount');
        // критерии поиска
        if (is_array($this->searchCategories) && !empty($this->searchCategories)) {
            array_push($criteria->with, 'categories');
            $counter = 0;
            $params = array();
            foreach ($this->searchCategories as $cat) {
                $alias = ":cat".$counter++;
                $condParts[] = "categories.id=$alias";
                $params[$alias] = $cat;
            }
            $criteria->addCondition(implode(' OR ', $condParts));
            $criteria->params = CMap::mergeArray($criteria->params, $params);
            $criteria->together = true;
        }
        if (is_array($this->searchTags)) {
            $counter = 0;
            $params = array();
            foreach ($this->searchTags as $tag) {
                $alias = ":tag".$counter++;
                $condParts[] = "t.tags LIKE $alias";
                $params[$alias] = '%'.$tag.'%';
            }
            $criteria->addCondition(implode(' OR ', $condParts));
            $criteria->params = CMap::mergeArray($criteria->params, $params);
        }
        if ($this->searchString !== null) {
            $criteria->compare('t.full_description', $this->searchString, true);
        }
        
        $config['criteria'] = $criteria;
        $config['model'] = $this;
        $config = CMap::mergeArray($config, $providerOptions);
        return new CActiveDataProvider('Article', $config);
	}
    
    public function normalizeTags($attribute,$params)
    {
        $this->tags=Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }
    
//    public function normalizeDate($attribute,$params)
//    {
//        $this[$attribute] = date('Y-m-d', strtotime($this[$attribute]));
//    }
    
    protected function beforeSave()
    {
        if ( !parent::beforeSave() )
            return false;
        
        if ( $this->isNewRecord ) {
            $this->user_id = Yii::app()->user->id;
        }
        
        $this->date_public = date('Y-m-d', strtotime($this->date_public));
        
        $images = CUploadedFile::getInstancesByName('image');
        if ( isset($images) && count($images) > 0 ) {
            if ( !$this->saveImage($images[0]) ) {
                return false;
            }
        }
        
        return true;
    }
    
    protected function afterSave()
    {
        parent::afterSave();
        Tag::model()->updateFrequency($this->_oldTags, $this->tags);
        ArticleCategory::model()->updateRelations($this->id, $this->_oldCategoriesIds, $this->_newCategoriesIds);
    }
    
    protected function afterFind()
    {
        $this->_oldTags = $this->tags;
        foreach ( $this->categories as $category ) {
            $this->_oldCategoriesIds[] = $category->id;
        }
        $this->date_public = date('d.m.Y', strtotime($this->date_public));
    }
    
    protected function afterDelete()
    {
        parent::afterDelete();
        Comment::model()->deleteAll('article_id='.$this->id);
        Tag::model()->updateFrequency($this->tags, '');
        $this->removeImage();
    }
    
    public function addComment($comment)
    {
        if(Yii::app()->params['commentNeedApproval'])
			$comment->status=Comment::STATUS_PENDING;
		else
			$comment->status=Comment::STATUS_APPROVED;
		$comment->post_id=$this->id;
		return $comment->save();
    }
    
    public function belongsToCategory($idCategory)
    {
        return in_array($idCategory, $this->_oldCategoriesIds);
    }
    
    public function setNewCategories($ids)
    {
        $this->_newCategoriesIds = $ids;
    }
    
    public function getNewCategories()
    {
        return $this->_newCategoriesIds===null ? array() : $this->_newCategoriesIds;
    }
    
    public function saveImage(CUploadedFile $uploadFile)
    {
        $fileInfo = pathinfo($uploadFile->name);
        $fileName = time().'-'.md5($uploadFile->name.time()).'.'.$fileInfo['extension'];
        $savePath = Yii::getPathOfAlias('webroot').'/uploads/previews/'.$fileName;
        if ( $uploadFile->saveAs($savePath) ) {
            
            
            
            $this->image = $fileName;
            return true;
        }
        return false;
    }
    
    public function removeImage()
    {
        $file = Yii::getPathOfAlias('webroot').'/uploads/'.$this->image;
        if ( is_file($file) ) {
            unlink($file);
            $this->image = '';
            return true;
        }
    }
    
    public function getImage($width = false, $height = false, $alt = '')
    {
        if ( empty($this->image) )
            return "";
        $options = array();
        if ($width) $options['width'] = $width;
        if ($height) $options['height'] = $height;
        return CHtml::image('/uploads/previews/'.$this->image, $alt, $options);
    }
    
    public function getThumb($width = 100, $height = 80)
    {
        return CHtml::image("/lib/thumb/phpThumb.php?src=/uploads/previews/{$this->image}&w=$width&h=$height&zc=1&q=90");
    }
    
    public function incViews()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition($this->tableName().'.id='.$this->id);
        if ( $this->updateCounters(array('views'=>1), $criteria) > 0 ) {
            $this->views++;
        }
    }
}