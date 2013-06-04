<?php

abstract class CAnnounceComponentController extends Controller
{
    public $layout = '//layouts/column2';
    
    abstract function loadModel($id);
    abstract function create($announceId);
    abstract function update($id, $announceId);
}