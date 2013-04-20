<?php

class VideoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('out'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('upload','ajaxUpload', 'admin'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'application.components.actions.UploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads/videos",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads/videos",
            ),
        );
    }
    
    
    public function actionAdmin()
    {
        $dir = Yii::getPathOfAlias('webroot')."/uploads/videos";   //задаём имя директории
        if(is_dir($dir)) {            
            $files = scandir($dir);
            array_shift($files); // удаляем из массива '.'
            array_shift($files); // удаляем из массива '..'
        }
        
        $file_list = array();
        if (is_array($files)) {
            foreach($files as $key => $file) {
                $file_list[] = array(
                    'id'=>$key,
                    'name'=>$file,
                    'size'=>self::get_filesize($dir.'/'.$file),
                );
            }
        }
        
        $dataProvider = new CArrayDataProvider($file_list);
        
        Yii::import("xupload.models.XUploadForm");
        $model = new XUploadForm;
        
        $this->layout = '//layouts/column2';
        
        $this->render('admin', array(
            'dataProvider'=>$dataProvider,
            'model'=>$model
        ));
    }
    
    public static function get_filesize($file)
    {
        if(!file_exists($file)) return "Файл  отсутствует.";
        $filesize = filesize($file);
        if($filesize > 1024) 
        {
            $filesize = ($filesize/1024);
            if($filesize > 1024) {
                $filesize = ($filesize/1024);
                if($filesize > 1024) {
                    $filesize = ($filesize/1024);
                    $filesize = round($filesize, 1);
                    return $filesize." ГБ";
                } else { 
                    $filesize = round($filesize, 1);
                    return $filesize." MБ";    
                }
            } else {
                $filesize = round($filesize, 1);
                return $filesize." Кб";
            }
        } else {
            $filesize = round($filesize, 1); 
            return $filesize." байт";
        }
    }
    
    
    public function actionAjaxUpload()
    {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $folder='uploads/videos/';// folder for uploaded files
        $allowedExtensions = array("flv", "avi", "mpeg", "mp4");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
 
        $fileSize = filesize($folder.$result['filename']);//GETTING FILE SIZE
        $fileName = $result['filename'];//GETTING FILE NAME
 
        echo $return;// it's array
        Yii::app()->end();
    }
    
    
    public function actionOut()
    {
        $alias = Yii::app()->request->getQuery('alias');
        $lesson = Lesson::model()->findByAttributes(array('alias'=>$alias));
        $pathinfo = pathinfo($lesson->source);
        $location = Yii::getPathOfAlias('webroot') . $lesson->source;
        $mimeType = "video/mp4";
        
        self::smartReadFile($location, $pathinfo['basename'], $mimeType);
    }
    
    
            
    public static function smartReadFile($location, $filename, $mimeType)
    {        
        if(!file_exists($location))
        { header ("HTTP/1.0 404 Not Found");
            return;
        }
        
        $size=filesize($location);
        $time=date('r',filemtime($location));
        
        $fm=@fopen($location,'rb');
        if(!$fm)
        { header ("HTTP/1.0 505 Internal server error");
            return;
        }
        
        $begin=0;
        $end=$size;
        
        if(isset($_SERVER['HTTP_RANGE']))
        {
            if(preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches))
            {
                $begin=intval($matches[0]);
                if( !empty($matches[1]) ) {
                    $end=intval($matches[1]);
                }
            }
        }
        
        if($begin>0||$end<$size) {
            header('HTTP/1.0 206 Partial Content');
        } else {
            header('HTTP/1.0 200 OK');  
        }
        header("Content-Type: $mimeType");
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Pragma: no-cache');  
        header('Accept-Ranges: bytes');
        header('Content-Length:'.($end-$begin));
        header("Content-Range: bytes $begin-$end/$size");
        header("Content-Disposition: inline; filename=$filename");
        header("Content-Transfer-Encoding: binary\n");
        header("Last-Modified: $time");
        header('Connection: close');
        
        $cur=$begin;
        fseek($fm,$begin,0);
        
        while(!feof($fm)&&$cur<$end&&(connection_status()==0))
        {
            echo fread($fm,min(1024*2,$end-$cur));
            $cur+=1024*2;
            //set_time_limit(30);
        }
    }
}
