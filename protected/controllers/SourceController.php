<?php

class SourceController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('admin','delete','upload'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Source('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Source']))
			$model->attributes=$_GET['Source'];
        
        $cs = Yii::app()->getClientScript();
        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/js' );
        $cs->registerScriptFile( $url.'/jquery.upload.js' );
        $cs->registerScriptFile( $url.'/admin/source.js' );

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Source the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Source::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Source $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='source-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionUpload()
    {
        $files = self::fixGlobalFilesArray($_FILES);
        
        $maxSize = Yii::app()->params['MAX_SOURCE_FILE_SIZE'];
        $maxSizeB = $maxSize * 1024 * 1024;
        $response = array(
            'success'=>true,
            'errors'=>array(),
        );
        foreach ($files['Source'] as $key => $file)
        {
            if($file["size"] > $maxSizeB)
            {
                $response['errors'][] = "Размер файла превышает {$maxSize} мб";
                break;
            }
            if(is_uploaded_file($file["tmp_name"]))
            {
                $source = new Source;
                $source->path = $file['name'];
                if ( !$source->save() ) {
                    $response['errors'][] = $sourse->getError('path');
                }
            }
            else
            {
                $response['errors'][] = "Ошибка при загрузке файла {$file['name']}";
            }
        }
        echo CJSON::encode($response);
    }
    
    public static function fixGlobalFilesArray($files)
    {
        $ret = array();
        if(isset($files['tmp_name']))
        {
            if (is_array($files['tmp_name']))
            {
                foreach($files['name'] as $idx => $name)
                {
                    $ret[$idx] = array(
                        'name' => $name,
                        'tmp_name' => $files['tmp_name'][$idx],
                        'size' => $files['size'][$idx],
                        'type' => $files['type'][$idx],
                        'error' => $files['error'][$idx]
                    );
                }
            }
            else
            {
                $ret = $files;
            }
        }
        else
        {
            foreach ($files as $key => $value)
            {
                $ret[$key] = self::fixGlobalFilesArray($value);
            }
        }
        return $ret;
    }
}
