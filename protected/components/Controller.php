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
        
        // global Scripts
        $glob_url = CHtml::asset( Yii::getPathOfAlias('webroot').'/js/' );
        Yii::app()->clientScript->registerScriptFile( $glob_url.'/scripts.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $glob_url.'/jquery.roundabout.min.js', CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile( $glob_url.'/common.js', CClientScript::POS_END );
        
        // global Styles
        $css_url = CHtml::asset( Yii::getPathOfAlias('webroot').'/css/' );
        Yii::app()->clientScript->registerCssFile( $css_url.'/reset.css' );
        Yii::app()->clientScript->registerCssFile( $css_url.'/style.css' );
        Yii::app()->clientScript->registerCssFile( $css_url.'/blog.css' );
        if ( $this->layout == '//layouts/column1' ) {
            Yii::app()->clientScript->registerCssFile( $css_url.'/animation.css' );
        } else {
            Yii::app()->clientScript->registerCssFile( $css_url.'/screen.css' );
            Yii::app()->clientScript->registerCssFile( $css_url.'/main.css' );
            Yii::app()->clientScript->registerCssFile( $css_url.'/form.css' );
        }
        
        return true;
    }
}