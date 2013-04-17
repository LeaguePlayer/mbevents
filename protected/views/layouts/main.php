<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php //echo CHtml::encode(Yii::app()->name); ?></div>
        
        <!--
        <div class="user_panel">
            <?php if ( Yii::app()->user->isGuest ): ?>
                <a href="<?=$this->createUrl('/user/login');?>">Вход</a>
                <a href="<?=$this->createUrl('/user/registration');?>">Регистрация</a>
            <?php else: ?>
                <a href="<?=$this->createUrl('/user/logout');?>">Выход</a>
            <?php endif; ?>
        </div>
        -->
        
	</div><!-- header -->

	<div id="mainmenu">            
		<?php
        if ( Yii::app()->user->isGuest ) {
            $this->widget('zii.widgets.CMenu',array(
    			'items'=>array(
                    array('label'=>'Промо-коды', 'url'=>array('/promocode/admin')),
                    array('label'=>'Видео', 'url'=>array('/video/admin')),
    				array('label'=>'Вход', 'url'=>array('/user/login')),
                ),
    		));
        } elseif ( !Yii::app()->user->isAdmin() ) {
            $this->widget('zii.widgets.CMenu',array(
    			'items'=>array(
    				array('label'=>'Промо-коды', 'url'=>array('/promocode/admin')),
                    array('label'=>'Видео', 'url'=>array('/video/admin')),
                    array('label'=>'Выход', 'url'=>array('/user/logout')),
                ),
    		));
        } else {
            $this->widget('zii.widgets.CMenu',array(
    			'items'=>array(
    				array('label'=>'Home', 'url'=>array('/site/index')),
                    array('label'=>'Категории', 'url'=>array('/category/admin')),
                    array('label'=>'Анонсы', 'url'=>array('/announce/admin')),
                    array('label'=>'Блог', 'url'=>array('/article/admin')),
                    array('label'=>'Пользователи', 'url'=>array('/user/admin')),
                    array('label'=>'Видеоматериалы', 'url'=>array('/lesson/admin')),
                    array('label'=>'Учебные материалы', 'url'=>array('/source/admin')),
                    array('label'=>'Видео-курсы', 'url'=>array('/course/admin')),
                    array('label'=>'Пользователи', 'url'=>array('/user/admin')),
                    array('label'=>'Выход', 'url'=>array('/user/logout')),
                ),
    		));
        }
        ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->
</body>
</html>