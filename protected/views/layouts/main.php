<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	
    <!--Fonts from Google-->
	<link href='http://fonts.googleapis.com/css?family=PT+Sans+Caption:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

	<!--[if lt IE 9]>
	<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>             
		<?php
//        if ( Yii::app()->user->isGuest ) {
//            $this->widget('zii.widgets.CMenu',array(
//    			'items'=>array(
//                    array('label'=>'Промо-коды', 'url'=>array('/promocode/admin')),
//                    array('label'=>'Видео', 'url'=>array('/video/admin')),
//    				array('label'=>'Вход', 'url'=>array('/user/login')),
//                ),
//    		));
//        } elseif ( !Yii::app()->user->isAdmin() ) {
//            $this->widget('zii.widgets.CMenu',array(
//    			'items'=>array(
//    				array('label'=>'Промо-коды', 'url'=>array('/promocode/admin')),
//                    array('label'=>'Видео', 'url'=>array('/video/admin')),
//                    array('label'=>'Выход', 'url'=>array('/user/logout')),
//                ),
//    		));
//        } else {
//            $this->widget('zii.widgets.CMenu',array(
//    			'items'=>array(
//    				array('label'=>'Home', 'url'=>array('/site/index')),
//                    array('label'=>'Категории', 'url'=>array('/category/admin')),
//                    array('label'=>'Анонсы', 'url'=>array('/announce/admin')),
//                    array('label'=>'Блог', 'url'=>array('/article/admin')),
//                    array('label'=>'Пользователи', 'url'=>array('/user/admin')),
//                    array('label'=>'Видеоматериалы', 'url'=>array('/lesson/admin')),
//                    array('label'=>'Учебные материалы', 'url'=>array('/source/admin')),
//                    array('label'=>'Видео-курсы', 'url'=>array('/course/admin')),
//                    array('label'=>'Пользователи', 'url'=>array('/user/admin')),
//                    array('label'=>'Выход', 'url'=>array('/user/logout')),
//                ),
//    		));
//        }
        ?>
        
	<?php if(isset($this->breadcrumbs)):?>
		<?php
//        $this->widget('zii.widgets.CBreadcrumbs', array(
//			'links'=>$this->breadcrumbs,
//		)); ?>
        <!-- breadcrumbs -->
	<?php endif?>
    
 <?php echo $content; ?>

	<div class="clear"></div>

	<footer id="footer">
		<div class="center">
			<p class="copy">&copy; 2013 Брайан Трейси</p>
			<ul class="bottom-menu">
				<li><a href="/">Главная</a></li>
				<li><a href="#">Семинары</a></li>
				<li><a href="#">Видео-уроки</a></li>
				<li><a href="#">Партнерская система</a></li>
			</ul>
			<div class="social">
				<a class="fb" href="#"></a>
				<a class="tw" href="#"> </a>
				<a class="vk" href="#"> </a>
			</div>
			<div class="clear"></div>
		</div>
	</footer>
    
</body>
</html>