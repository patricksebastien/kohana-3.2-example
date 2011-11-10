<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dashboard extends Controller_Template_Generic {

	public function before()
	{
		parent::before();
		
		if (!Auth::instance()->logged_in('participant'))
		{
			$this->request->redirect('account/login');
		}

		$this->template->loged = TRUE;
	}
	
	
	// participant loged in - welcome page
	public function action_index()
	{
		// display
		$this->template->show_logout = TRUE;
		$this->template->title = 'Dashboard';
		$this->template->content = View::factory('dashboard/dashboard');
	}
	
	
	// participant logout
	public function action_logout()
	{
		// log user out
		Auth::instance()->logout();
		// redirect to login page
		Request::current()->redirect('');
	}

}