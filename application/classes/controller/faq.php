<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Faq extends Controller_Template_Generic {

	public function action_index()
	{
	
		$this->template->title = __('Faq');
  		$this->template->content = View::factory('faq');
	}

}
