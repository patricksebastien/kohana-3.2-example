<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Template_Generic extends Controller_Template
{

	public $template = 'template/generic';

	/**
	 * The before() method is called before your controller action.
	 * In our template controller we override this method so that we can
	 * set up default values. These variables are then available to our
	 * controllers if they need to be modified.
	 */
	public function before()
	{
		parent::before();

		if ($this->auto_render)
		{
			// keep the last url if it's not home/language
			if(Request::current()->action() != 'language') {
				Session::instance()->set('controller', Request::current()->uri());
			}
			
			if (Auth::instance()->logged_in('participant'))
			{
				$this->template->loged = TRUE;
			}
			
			// Initialize empty values
			$this->template->title   = '';
			$this->template->content = '';
			
			$this->template->styles = array();
			$this->template->scripts = array(); 
		}
	}
	 
	/**
	 * The after() method is called after your controller action.
	 * In our template controller we override this method so that we can
	 * make any last minute modifications to the template before anything
	 * is rendered.
	 */
	public function after()
	{
		if ($this->auto_render)
		{
			$styles = array(
				'assets/css/html5reset-1.6.1.css' => 'screen',
				'assets/css/generic.css' => 'screen',
				'http://fonts.googleapis.com/css?family=Andika' => 'screen',
			);

			$scripts = array(
				'http://code.jquery.com/jquery.min.js',
				//'http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js',
				'assets/js/jquery.alphanumeric.min.js',
				'assets/js/jquery.password.sm.min.js',
			);
	
			$this->template->styles = array_merge( $this->template->styles, $styles );
			$this->template->scripts = array_merge( $this->template->scripts, $scripts );
		}
		parent::after();
	}
}