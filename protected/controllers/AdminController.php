<?php

class AdminController extends Controller
{
    public $layout='//layouts/column2';
    
    public function filters()
    {
            return array(
                    'accessControl',
            );
    }
    
    public function accessRules()
    {
            return array(
                    array('allow', // allow admin user to perform 'admin' and 'delete' actions
                            'actions'=>array('index'),
                            'users'=>Yii::app()->getModule('user')->getAdmins(),
                    ),
                    array('deny',  // deny all users
                            'users'=>array('*'),
                    ),
            );
    }
    
    public function actionIndex()
    {
        if ( !Yii::app()->user->isAdmin() )
        {
            $this->redirect('/user/login');
        }
        $this->render('index');
    }
}