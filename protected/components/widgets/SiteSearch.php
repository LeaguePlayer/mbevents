<?php

class SiteSearch extends CWidget
{
    public $formModel;
    
	public function run()
	{
        if ( $this->formModel === null ) {
            $form = new SiteSearchForm();
        } else {
            $form = $this->formModel;
        }
    	$this->render('siteSearch', array('form'=>$form));
  	}
}