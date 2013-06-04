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
                
            case AnnounceComponent::COMPONENT_TYPE_SPIEKERS:
                $component = new ComponentSpiekers;
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_REVIEWS:
                $component = new ComponentReviews;
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_EVENT_FORM:
                $component = new ComponentReviews;
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_SLIDER:
                $component = new ComponentSlider;
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
                
            case AnnounceComponent::COMPONENT_TYPE_SPIEKERS:
                list($controller) = Yii::app()->createController('componentSpiekers');
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_REVIEWS:
                list($controller) = Yii::app()->createController('componentReviews');
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_EVENT_FORM:
                list($controller) = Yii::app()->createController('componentRegOnEvent');
                break;
                
            case AnnounceComponent::COMPONENT_TYPE_SLIDER:
                list($controller) = Yii::app()->createController('ComponentSlider');
                break;
                
            default:
                $controller = null;
        }
        return $controller;
    }
}