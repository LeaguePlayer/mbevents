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
        $url = CHtml::asset(Yii::getPathOfAlias('webroot').'/plugins/fancybox/assets').'/fancybox';
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($url.'/jquery.fancybox.css');
        $cs->registerScriptFile($url.'/jquery.fancybox.pack.js', CClientScript::POS_END);
        
        // jwplayer
        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/plugins/jwplayer/' );
        Yii::app()->clientScript->registerScriptFile( $url.'/jwplayer.js', CClientScript::POS_END );
        
        // global Scripts
        $url = CHtml::asset( Yii::getPathOfAlias('webroot').'/js/' );
        Yii::app()->clientScript->registerScriptFile( $url.'/scripts.js', CClientScript::POS_BEGIN );
        
        return true;
    }
}