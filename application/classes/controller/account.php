<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Template_Generic {

	public function before()
	{
		parent::before();
	}
	
	
	// nothing here
	public function action_index()
	{
		$this->request->redirect('');
	}
	
	
	// create account
	public function action_create()
	{
	
		// form post handling
		if (isset($_POST) && Valid::not_empty($_POST)) {
			
			// validate
			$post = Validation::factory($_POST)
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->rule('email', 'email_domain')
			->rule('username', 'not_empty')
			->rule('username', Kohana::$config->load('ko32example.account.create.username.format'))
			->rule('username', 'min_length', array(':value', Kohana::$config->load('ko32example.account.create.username.min_length')))
			->rule('username', 'max_length', array(':value', Kohana::$config->load('ko32example.account.create.username.max_length')))
			->rule('password', 'not_empty')
			->rule('password', 'min_length', array(':value', Kohana::$config->load('ko32example.account.create.password.min_length')))
			->rule('password', array($this, 'pwdneusr'), array(':validation', ':field', 'username'));
					
			if ($post->check()) {
				// save
				$model = ORM::factory('user');
				$model->values(array(
					'email'		=> $post['email'],
					'username' 	=> HTML::entities(strip_tags($post['username'])),
					'password'	=> $post['password'],
				));
				try {
					$model->save();
					
					$model->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
					$model->add('roles', ORM::factory('role')->where('name', '=', 'participant')->find());
					// success login
					if (Auth::instance()->login($post['username'], $post['password']))
					{
						if(Auth::instance()->logged_in('participant')) {
							// sucessfully loged
							$this->request->redirect('dashboard');
						}
					} else {
						//TODO error
					}
				}
				catch (ORM_Validation_Exception $e) {
					$errors = $e->errors('user');
				}
			} else {
				$errors = $post->errors('user');
			}
		}
		
		// TODO i18n
		$this->template->title = __('Create an account');
		
		// display
		$this->template->content = View::factory('account/create')
		->bind('post', $post)
		->bind('errors', $errors);
	}
	
	
	// login
	public function action_login()
	{
		// user already logged in, redirect to dashboard
		if (Auth::instance()->logged_in('participant')) {
			$this->request->redirect('dashboard');
		}
		
		// received the POST
		if (isset($_POST) && Valid::not_empty($_POST)) {
				
			// validate the login form
			$post = Validation::factory($_POST)
			->rule('username', 'not_empty')
			->rule('password', 'not_empty')
			->rule('password', 'min_length', array(':value', 3));
			$remember = isset($post['remember']);
		
			//TODO use email or username login
			
			// if the form is valid and the username and password matches
			if ($post->check() && Auth::instance()->login($post['username'], $post['password'], $remember))
			{
				if(Auth::instance()->logged_in('participant')) {
					// sucessfully loged
					$this->request->redirect('dashboard');
				}
			} else {
				// wrong username or password (but form is valid)
				$loginerrors =  __('Wrong username or password');
			}
			// validation failed, collect the errors
			$errors = $post->errors('user');
		}

		// display
		$this->template->title = __('Login');
		$this->template->content = View::factory('account/login')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('loginerrors', $loginerrors);
	}
	
	
	// login - help
	public function action_help()
	{
		// display
		$this->template->title = 'Help';
		$this->template->content = View::factory('account/help');
	}
	
	
	// login - reset step 1
	public function action_reset()
	{
		// received the POST
		if (isset($_POST) && Valid::not_empty($_POST)) {		
			// validate the login form
			$post = Validation::factory($_POST)
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->rule('email', 'email_domain')
			->rule('email', array($this, 'pwdexist'), array(':validation', ':field')); //TODO duplicate of ORM::factory('user') below
				
			// if the form is valid and the username and password matches
			if ($post->check()) {
				
				$user = ORM::factory('user')->where('email', '=', $post['email'])->find();
				$user->reset_token = $this->generate_token(32);
				$user->save();
				
				//TODO email
				/*
				require Kohana::find_file('vendor', 'swift/swift_required');
	
		  		//Create the Transport
		  		$transport = Swift_SmtpTransport::newInstance('localhost', 25);
		  		
		  		//Create the Mailer using your created Transport
		  		$mailer = Swift_Mailer::newInstance($transport);
		  		
		  		//Create a message
		  		$message = Swift_Message::newInstance('Subject')
		  		->setFrom(array('etc@etc.com' => 'Etc'))
		  		->setTo(array('etc@etc.com'))
		  		->setBody('etc');
		  		
		  		//Send the message
		  		$result = $mailer->send($message);
  		
  		
  				------------------------------------
  				
  				
				$message = "You have requested a password reset. You can reset password to your account by visiting the page at:\n\n" .
								           ":reset_token_link\n\n" .
								           "If the above link is not clickable, please visit the following page:\n" .
								           ":reset_link\n\n" .
								           "and copy/paste the following Reset Token: :reset_token\nYour user account name is: :username\n";
				$mailer = Email::connect();
				// Create complex Swift_Message object stored in $message
				// MUST PASS ALL PARAMS AS REFS
				$subject = __('Account password reset');
				$to = $_POST['reset_email'];
				$from = Kohana::$config->load('useradmin')->email_address;
				$body = __($message, array(
									':reset_token_link' => URL::site('user/reset?reset_token='.$user->reset_token.'&reset_email='.$_POST['reset_email'], TRUE), 
									':reset_link' => URL::site('user/reset', TRUE), 
									':reset_token' => $user->reset_token, 
									':username' => $user->username
				));
				// FIXME: Test if Swift_Message has been found.
				$message_swift = Swift_Message::newInstance($subject, $body)->setFrom($from)->setTo($to);
				if ($mailer->send($message_swift))
				{
					Message::add('success', __('Password reset email sent.'));
					$this->request->redirect('user/login');
				}
				else
				{
					Message::add('failure', __('Could not send email.'));
				}
				*/
				$sent = 1;
			} else {
				// validation failed, collect the errors
				$errors = $post->errors('user');
			}
		}
		
		// display
		$this->template->title = 'Reset password';
		$this->template->content = View::factory('account/reset')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('sent', $sent);
	}
	

	// login - reset step 2
	public function action_password()
	{
		// user already logged in, redirect to dashboard
		if (Auth::instance()->logged_in('participant')) {
			$this->request->redirect('dashboard');
		}

		// try to match
		if (isset($_GET['token']) && isset($_GET['email'])) {
			if ((strlen($_GET['token']) == 32) && Valid::email($_GET['email'])) {
				// match $_GET with user
				$user = ORM::factory('user')->where('email', '=', $_GET['email'])->where('reset_token', '=', $_GET['token'])->find();
				if($user->loaded()) {
					$found = 1;
				} else {
					$found = 0;
				}
			} else {
				$this->request->redirect();
			}
		} else {
			$this->request->redirect();
		}
		
		// handle post
		if (isset($_POST) && Valid::not_empty($_POST)) {
			// validate the login form
			$post = Validation::factory($_POST)
			->rule('username', 'not_empty')
			->rule('password', 'not_empty')
			->rule('password', 'min_length', array(':value', Kohana::$config->load('ko32example.account.create.password.min_length')))
			->rule('password', array($this, 'pwdneusr'), array(':validation', ':field', 'username'));
			
			// if the form is valid and the username and password matches
			if ($post->check()) {
				// modify the password
				$user->reset_token = NULL;
				$user->password = $post['password'];
				$user->save();
				// log the user 
				if(Auth::instance()->login($post['username'], $post['password'])) {
					Session::instance()->set('success_pwd', 1);
					$this->request->redirect('dashboard');
				}
			} else {
				$errors = $post->errors('user');
			}
		}
		
		// display
		$this->template->title = 'Reset password step 2';
		$this->template->content = View::factory('account/password')
			->bind('post', $post)
			->bind('errors', $errors)
			->bind('found', $found)
			->bind('user', $user);
	}
	
	
	// check if username is available
	// call by ajax
	public function action_checkusername()
	{
		if ($this->request->is_ajax()) {
			$this->auto_render = FALSE;

			if(!ORM::factory('user')->unique_key_exists($_POST['username'])) {
				echo json_encode(array('available' => 1));
			} else {
				echo json_encode(array('available' => 0));
			}
		}
	}
	
	
	// validation rule: password != username
	static function pwdneusr($validation, $password, $username)
	{
		if ($validation[$password] === $validation[$username])
		{
			$validation->error($password, 'pwdneusr');
		}
	}
	
	
	//validation rule: password exist
	static function pwdexist($validation, $email)
	{
		if(!ORM::factory('user')->unique_key_exists($validation[$email])) {
			$validation->error($email, 'emailexistnot');
		}
	}
	
	
	// generate token
	static function generate_token($length = 8)
	{
		// start with a blank password
		$password = "";
		// define possible characters (does not include l, number relatively likely)
		$possible = "123456789abcdefghjkmnpqrstuvwxyz123456789";
		// add random characters to $password until $length is reached
		for ($i = 0; $i < $length; $i++) {
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$password .= $char;
		}
		return $password;
	}
	
}
