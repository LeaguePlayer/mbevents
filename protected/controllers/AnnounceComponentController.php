<?php

class AnnounceComponentController extends Controller
{
    public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create', 'delete'),
				'users'=>array('admin'),
			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
		);
	}
    
    
	public function actionCreate($typeId, $announceId, $backUrl = false)
	{
        $controller = AnnounceComponentFactory::CreateController($typeId);
        if ($controller) {
            $url = ($backUrl) ? $backUrl : $this->createUrl('/announce/view', array('operation'=>'edit', 'id'=>$announceId));
            $finalProcess = $controller->create($announceId, $url);
            if ( $finalProcess ) {
                $this->redirect($url);
            }
        } else {
            throw new CHttpException(404, 'Ошибка инициализации контроллера');
        }
	}

    
	public function actionUpdate($id, $typeId, $backUrl = false)
	{
        $controller = AnnounceComponentFactory::CreateController($typeId);
        if ($controller) {
            $url = ($backUrl) ? $backUrl : $this->createUrl('/announce/view', array('operation'=>'edit', 'id'=>$announceId));
            $finalProcess = $controller->update($id, $url);
            if ( $finalProcess ) {
                $this->redirect($url);
            }
        } else {
            throw new CHttpException(404, 'Ошибка инициализации контроллера');
        }
	}
    
    
    public function actionDelete($backUrl = false)
    {
        $id = $_POST['id'];
        $typeId = $_POST['typeId'];
        if ( !is_numeric($id) || !is_numeric($typeId) ) {
            throw new CHttpException(404, 'Некорректный запрос');
        }
        $controller = AnnounceComponentFactory::CreateController($typeId);
        if ( $controller ) {
            $model = $controller->loadModel($id);
            $model->delete();
            if (Yii::app()->request->isAjaxRequest) {
                Yii::app()->end();
            }
            $url = ($backUrl) ? $backUrl : $this->createUrl('/announce/admin');
            $this->redirect($url);
        }
    }
}