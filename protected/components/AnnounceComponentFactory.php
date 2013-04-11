<?php

class AnnounceComponentFactory
{
    private static $_instance;
    private function __construct() {}
    public static function Instance()
    {
        if (self::$_instance === null) {
            self::$_instance = new CAnnounceComponentFactory;
        }
        return self::$_instance;
    }
    
    public static function CreateModel($typeId)
    {
        switch ($typeId) {
            case AnnounceComponent::COMPONENT_TYPE_PHOTO_VIDEO:
                $component = new ComponentPhVid;
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_HTML:
                $component = new ComponentHtml;
                break;
                
            default:
                $component = null;
        }
        return $component;
    }
    
    public static function CreateController($typeId)
    {
        switch ($typeId) {
            case AnnounceComponent::COMPONENT_TYPE_PHOTO_VIDEO:
                list($controller) = Yii::app()->createController('componentPhVid');
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_HTML:
                list($controller) = Yii::app()->createController('componentHtml');
                break;
                
            default:
                $controller = null;
        }
        return $controller;
    }
}