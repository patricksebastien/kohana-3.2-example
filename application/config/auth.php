<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'driver'       => 'orm',
	'hash_method'  => 'sha256',
	'hash_key'     => 'dsadsadad',
	'lifetime'     => 0,
	'session_type' => Session::$default,
	'session_key'  => 'auth_user',
);
