<?php

abstract class CAnnounceComponentController extends Controller
{
    abstract function loadModel($id);
    abstract function create($announceId);
    abstract function update($id);
}