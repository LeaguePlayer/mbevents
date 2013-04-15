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
				'actions'=>array('upload','ajaxUpload'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
    
    public function actionUpload()
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
        
        $this->render('upload', array(
            'dataProvider'=>$dataProvider
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
        $allowedExtensions = array("flv");//array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
 
        $fileSize = filesize($folder.$result['filename']);//GETTING FILE SIZE
        $fileName = $result['filename'];//GETTING FILE NAME
 
        echo $return;// it's array
        Yii::app()->end();
    }
}
