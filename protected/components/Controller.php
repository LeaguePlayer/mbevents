<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    // Выводить ли на странице ленту блога
    public $showSideArticles;
    
    // Курс, который будет в шапке
    public $topCourse;
    
    // Зделать ли шапку свернутой
    public $header_small;
    
    //public $showWelcome;
    
    private $_assetsBase;
    public function getAssetsBase()
    {
        if ($this->_assetsBase === null) {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.assets'),
                false,  // hash папок со скриптами формируется с учетом даты последней модификации, т.е., 
                        // выполнив команду touch protected/assets/ на сервере, кэш броузеров клиентов принудительно обновится
                -1,
                YII_DEBUG
            );
        }
        return $this->_assetsBase;
    }
    
    protected function beforeRender()
    {
        $cs = Yii::app()->getClientScript();
        
        // fancybox
        $fancy_url = CHtml::asset(Yii::getPathOfAlias('webroot').'/plugins/fancybox/assets').'/fancybox';
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($fancy_url.'/jquery.fancybox.css');
        $cs->registerScriptFile($fancy_url.'/jquery.fancybox.pack.js', CClientScript::POS_END);
        
        // jwplayer
        $jw_url = CHtml::asset( Yii::getPathOfAlias('webroot').'/plugins/jwplayer/' );
        Yii::app()->clientScript->registerScriptFile( $jw_url.'/jwplayer.js', CClientScript::POS_END );
        
        // flowplayer
//        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/plugins/flowplayer/' );
//        Yii::app()->clientScript->registerScriptFile( $url.'/flowplayer.min.js', CClientScript::POS_BEGIN );
//        Yii::app()->clientScript->registerCssFile( $url.'/skin/minimalist.css' );

        // ktplayer
//        $kt_url = CHtml::asset( Yii::getPathOfAlias('webroot').'/plugins/kt_player/' );
//        Yii::app()->clientScript->registerScriptFile( $kt_url.'/kt_player.js', CClientScript::POS_BEGIN );
        
        // videojs-player
//        $vdeojs_url = CHtml::asset( Yii::getPathOfAlias('webroot').'/plugins/video-js/' );
//        Yii::app()->clientScript->registerCssFile( $vdeojs_url.'/video-js.css' );
//        Yii::app()->clientScript->registerScriptFile( $vdeojs_url.'/video.js', CClientScript::POS_BEGIN );

        // uppod
//        $uppod_url = CHtml::asset( Yii::getPathOfAlias('webroot').'/plugins/uppod/' );
//        Yii::app()->clientScript->registerScriptFile( $uppod_url.'/uppod.js', CClientScript::POS_BEGIN );
//        Yii::app()->clientScript->registerScriptFile( $uppod_url.'/swfobject.js', CClientScript::POS_BEGIN );
        
        $assetsBase = $this->getAssetsBase();
        // global Scripts
        $cs->registerScriptFile( $assetsBase.'/js/jquery.cookie.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/jquery.anythingslider.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/jquery.roundabout.min.js', CClientScript::POS_END );
        //$cs->registerScriptFile( $assetsBase.'/js/jquery.easing.1.2.js', CClientScript::POS_END );
        $cs->registerScriptFile( 'http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU', CClientScript::POS_BEGIN );
        $cs->registerScriptFile( $assetsBase.'/js/scripts.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/common.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/callback.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/chosen.jquery.min.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/jquery.colorbox-min.js', CClientScript::POS_END );
        
        // global Styles
        $cs->registerCssFile( $assetsBase.'/css/reset.css' );
        $cs->registerCssFile( $assetsBase.'/css/anything-slider/anythingslider.css' );
        $cs->registerCssFile( $assetsBase.'/css/chosen.css' );
        $cs->registerCssFile( $assetsBase.'/css/colorbox.css' );
        
        if ( $this->layout == '//layouts/column1' ) {
            $cs->registerScriptFile( $assetsBase.'/js/registration.js', CClientScript::POS_END );
            $cs->registerCssFile( $assetsBase.'/css/style.css' );
            $cs->registerCssFile( $assetsBase.'/css/blog.css' );
            $cs->registerCssFile( $assetsBase.'/css/animation.css' );
        } else {
            $cs->registerCssFile( $assetsBase.'/css/admin.css' );
            $cs->registerCssFile( $assetsBase.'/css/screen.css' );
            $cs->registerCssFile( $assetsBase.'/css/main.css' );
            //$cs->registerCssFile( $css_url.'/form.css' );
        }
        // Скролл
        $cs->registerScriptFile( $assetsBase.'/js/jquery.scrollTo.js', CClientScript::POS_END );
        $cs->registerScriptFile( $assetsBase.'/js/scroll.js', CClientScript::POS_END );
        $cs->registerCssFile( $assetsBase.'/css/scroll.css' );
        
        if ($this->topCourse===null) {
            $this->topCourse = Course::model()->findTop();
        }
        
        // Берем из куков текущее состояние хедера
        $this->header_small = ( isset(Yii::app()->request->cookies['header_hide']) ) && ( Yii::app()->request->cookies['header_hide'] == true );
        
//        if ( true ) {
//            if ( !isset(Yii::app()->request->cookies['welcome_flag']->value) ) {
//                $cookieWelcome = new CHttpCookie('welcome_flag', true);
//                $cookieWelcome->expire = 60 * 60 * 24 * 60;
//                Yii::app()->request->cookies['welcome_flag'] = $cookieWelcome;
//                $this->showWelcome = true;
//            }
//        }
        
        return true;
    }
    
    protected function beforeAction($action)
    {
        $articleBehavior = $this->asa('articleBehavior');
        if ( $articleBehavior !== null ) {
            $this->showSideArticles = true;
            // здесь обрабатываются запросы на подгрузку новых статей или поиск по фильтру
            $articleBehavior->start();
        }
        return parent::beforeAction($action);
    }
}