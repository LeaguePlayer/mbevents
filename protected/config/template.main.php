<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'MB Events',
    'sourceLanguage'=>'ru',
    'language' => 'ru',
    'charset'=>'UTF-8',
    'timeZone'=>'Asia/Yekaterinburg',

	// preloading 'log' component
	'preload'=>array('log'),
    
    'sourceLanguage' => 'en',
    'language' => 'ru',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.components.yiidebugtb-master.*',
        'application.components.widgets.*',
        'application.components.validators.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
	),

	'modules'=>array(
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'qwe123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'user' => array(
            'tableUsers' => 'tbl_users',
            'tableProfiles' => 'tbl_profiles',
            'tableProfileFields' => 'tbl_profiles_fields',
            'hash' => 'md5',
            'sendActivationMail' => true,
            'loginNotActiv' => false,
            'activeAfterRegister' => false,
            'autoLogin' => true,
            'registrationUrl' => array('/user/registration'),
            'recoveryUrl' => array('/user/recovery'),
            'loginUrl' => array('/user/login'),
            'returnUrl' => array('/user/profile'),
            'returnLogoutUrl' => array('/user/login'),
            'captcha'=>array('registration'=>false),
        ),
	),

	// application components
	'components'=>array(
		'user'=>array(
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
                //'uploads'=>'site/',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=mbevents',
			'emulatePrepare' => true,
			'username' => 'dev_mbevents',
			'password' => 'qwe123',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                /*
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
                */
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
                /*
                array( // configuration for the toolbar
                    'class'=>'XWebDebugRouter',
                    'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                    'levels'=>'error, warning, trace, profile, info',
                    'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
                ),
                */
			),
		),
        'user'=>array(
            'class' => 'WebUser',
            'allowAutoLogin'=>true,
            'loginUrl' => array('/user/login'),
        ),
        'assetManager' => array(
            'class'=>'CAssetManagerExt',
        ),
        'clientScript' => array(
            //'class' => 'ext.NLSClientScript',  ---- чего-то jquery не подгружается :(
            //'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
            //'includePattern' => '/\.php/', //js regexp, only files with matching paths will be filtered if set to other than 'null'
            //'serverBaseUrl' => 'http://mbevents.loc', //can be optionally set here
            'scriptMap' => array(
                //'jquery.js' => '/js/jquery-1.8.0.js',
                //'jquery.min.js' => 'http:code.jquery.com/jquery-1.8.0.min.js',
                //'jquery-ui.min.js' => '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js',
            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'support@amobile-studio.ru',
        'commentNeedApproval'=>true,
        'MAX_SOURCE_FILE_SIZE'=>'20', // Mb
	),
);