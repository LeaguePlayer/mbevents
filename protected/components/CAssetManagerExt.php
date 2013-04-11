<?php

class CAssetManagerExt extends CAssetManager
{
    public function publish($path,$hashByName=false,$level=-1,$forceCopy=null)
    {
        if (YII_DEBUG) $forceCopy = true;
        return parent::publish($path, $hashByName, $level, $forceCopy);
    }
}