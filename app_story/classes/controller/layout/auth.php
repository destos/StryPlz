<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Layout_Auth extends Controller_Layout
{

	//public $template = 'layout';

	// Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
	// Can be set to a string or an array, for example array('login', 'admin') or 'login'
	public $auth_required = FALSE;

	// Controls access for separate actions
	// 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
	// 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
	public $secure_actions = FALSE;


	/**
	 * The before() method is called before your controller action.
	 * In our template controller we override this method so that we can
	 * set up default values. These variables are then available to our
	 * controllers if they need to be modified.
	 */
	public function before()
	{
		parent::before();

		//Open session, try catches session corruptiong and resets it, due to ORM bug
		try{
			$this->session = Session::instance();
		} catch(ErrorException $e) {
			Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
			session_destroy();
		}
		
		//Check user auth and role
		$action_name = Request::instance()->action;
		
		if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
			|| (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) &&
				Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE)) {
			if (Auth::instance()->logged_in()) {
				Request::instance()->redirect( Route::get('account')->uri( array('action'=>'noaccess') ) );
			}else {
				Request::instance()->redirect( Route::get('account')->uri( array('action'=>'signin') ) );
			}
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
		parent::after();
	}
}