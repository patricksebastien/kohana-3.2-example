<?php defined('SYSPATH') or die('No direct script access.');

class Controller_About extends Controller_Template_Generic {

	public function action_index()
	{
		$this->template->title = __('About');
  		$this->template->content = View::factory('about');
	}

}
