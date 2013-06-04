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

	<title>Академия Брайана Трейси<?// echo CHtml::encode($this->pageTitle); ?></title>
    
    <script src="//cdn.sublimevideo.net/js/ppbip1g1.js" type="text/javascript"></script>
    
</head>
<body>

    <? if (Yii::app()->user->hasFlash('INVALID_LOGIN_OR_PASSWORD')): ?>
    <div style="position: absolute; left: -9999px;">
        <div id="user_message">
            <p><?=Yii::app()->user->getFlash('INVALID_LOGIN_OR_PASSWORD')?></p>
        </div>
    </div>
    <? endif; ?>

    <div id="page-wrap" style="min-height:100%;">
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
        <div class="fix-footer-padding" style="margin-bottom: 46px;"></div>
    </div>

	<footer id="footer">
		<div class="center">
			<p class="copy">&copy; 2013 Брайан Трейси</p>
			<ul class="bottom-menu">
                <li><a href="<?=$this->topCourse->url;?>">Видео-уроки</a></li>
                <li><a href="/">Семинары</a></li>
                <? if (!Yii::app()->user->isGuest): ?>
                    <!--<li><a href="<?=$this->createUrl('/course/my');?>">Мои видеокурсы</a></li>-->
                <? endif ?>
                <!--
				<li><a href="#">Семинары</a></li>
				<li><a href="#">Партнерская система</a></li>
                -->
			</ul>
            <!--
			<div class="social">
				<a class="fb" href="#"></a>
				<a class="tw" href="#"> </a>
				<a class="vk" href="#"> </a>
			</div>
            -->
			<div class="clear"></div>
		</div>
	</footer>
    
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter21363238 = new Ya.Metrika({id:21363238,
                        webvisor:true,
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true});
            } catch(e) { }
        });
    
        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";
    
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="//mc.yandex.ru/watch/21363238" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
    
    <!-- Google Metrika-->
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-41250523-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <!-- /Google Metrika-->
    
    <!-- Google Code for &#1058;&#1077;&#1075; &#1088;&#1077;&#1084;&#1072;&#1088;&#1082;&#1077;&#1090;&#1080;&#1085;&#1075;&#1072; -->
    <!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
    <script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 993028905;
    var google_conversion_label = "0LHMCP_wkgUQqdbB2QM";
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/993028905/?value=0&amp;label=0LHMCP_wkgUQqdbB2QM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>
    
</body>
</html>