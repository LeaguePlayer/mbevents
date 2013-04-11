<?php

class CImageValidator extends CValidator
{
    public $types;
    
    
    protected function validateAttribute($object,$attribute)
	{
        $file = $object->{$attribute};
        if($this->types!==null)
		{
			if(is_string($this->types))
				$types=preg_split('/[\s,]+/',strtolower($this->types),-1,PREG_SPLIT_NO_EMPTY);
			else
				$types=$this->types;
			if(!in_array(strtolower($this->getExtensionName($file)),$types))
			{
				$message=Yii::t('yii','Файл "{file}" не может быть выбран. Файл должен быть следующего типа: {extensions}.');
				$this->addError($object,$attribute,$message,array('{file}'=>$file, '{extensions}'=>implode(', ',$types)));
			}
		}
        
        if ( @getimagesize(Yii::getPathOfAlias('webroot').$file)==null ) {
            $message=Yii::t('yii','Файл "{file}" не является изображением.');
            $this->addError($object,$attribute,$message,array('{file}'=>$file));
        }
	}
    
    
    protected function getExtensionName($file)
    {
        if(($pos=strrpos($file,'.'))!==false)
			return (string)substr($file,$pos+1);
		else
			return '';
    }
}