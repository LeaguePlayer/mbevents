<?php

class UWradioGroup {
	
	/**
	 * @var array
	 */
	public $params = array(
        'template'=>'{input}{label}',
        'separator'=>'',
        'container'=>'span',
	);
	
	/**
	 * Initialization
	 * @return array
	 */
	public function init() {
		return array(
			'name'=>__CLASS__,
			'label'=>'Radio List',
			'fieldType'=>array('INTEGER'),
			'params'=>$this->params,
			'paramsLabels' => array(
				'template'=>'Шаблон вывода',
				'separator'=>'Разделитель',
				'container'=>'Тэг контейнера',
			),
		);
	}
	
	/**
	 * @param $value
	 * @param $model
	 * @param $field_varname
	 * @return string
	 */
	public function setAttributes($value,$model,$field_varname) {
		return $value;
	}
	
	/**
	 * @param $model - profile model
	 * @param $field - profile fields model item
	 * @return string
	 */
	public function viewAttribute($model,$field) {
		return $model->getAttribute($field->varname);
	}
	
	/**
	 * @param $model - profile model
	 * @param $field - profile fields model item
	 * @param $params - htmlOptions
	 * @return string
	 */
	public function editAttribute($model,$field,$htmlOptions=array()) {
		if (!isset($htmlOptions['id'])) $htmlOptions['id'] = get_class($model).'_'.$field->varname;
        if (!isset($htmlOptions['separator'])) $htmlOptions['separator'] = $this->params['separator'];
        if (!isset($htmlOptions['template'])) $htmlOptions['template'] = $this->params['template'];
        if (!isset($htmlOptions['container'])) $htmlOptions['container'] = $this->params['container'];
		return CHtml::activeRadioButtonList($model,$field->varname, Profile::range($field->range), $htmlOptions);
	}
	
}