<?php

class CVideoValidator extends CValidator
{
    public $types;
    
    
    protected function validateAttribute($object,$attribute)
	{
        $file = $object->{$attribute};
        $extension = strtolower($this->getExtensionName($file));
        if($this->types!==null)
		{
			if(is_string($this->types))
				$types=preg_split('/[\s,]+/',strtolower($this->types),-1,PREG_SPLIT_NO_EMPTY);
			else
				$types=$this->types;
			if(!in_array($extension, $types))
			{
				$message=Yii::t('yii','Файл "{file}" не может быть выбран. Файл должен быть следующего типа: {extensions}.');
				$this->addError($object,$attribute,$message,array('{file}'=>$file, '{extensions}'=>implode(', ',$types)));
			}
		}
        
        if ( function_exists('finfo_open') )
        {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, Yii::getPathOfAlias('webroot').$file);
            
            $mimeTypes = array(
                "mp4" => "video/mp4",
                "mpeg" => "video/mpeg", 
                "mpg" => "video/mpeg", 
                "mpe" => "video/mpeg", 
                "qt" => "video/quicktime", 
                "mov" => "video/quicktime", 
                "mxu" => "video/vnd.mpegurl", 
                "avi" => "video/x-msvideo",
                'flv' => 'video/x-flv'
            );
            
            foreach ($mimeTypes as $key => $value) {
                if($value == $mime) {
                    if ($key == $extension) {
                        $validMime = true;
                        break;
                    }
                }
            }
            
            if (!$validMime) {
                $message=Yii::t('yii','Файл "{file}" не прошел проверку на соответствие типа.');
				$this->addError($object,$attribute,$message,array('{file}'=>$file));
            }
        } // end if ( function_exists('finfo_open') )
	}
    
    
    protected function getExtensionName($file)
    {
        if(($pos=strrpos($file,'.'))!==false)
			return (string)substr($file,$pos+1);
		else
			return '';
    }
}