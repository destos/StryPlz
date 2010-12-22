<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Route extends Controller {

	public function before(){		
		return parent::before();
	}
	
	public function action_index( $sms ){
		
		// new routes for SMS handling.
		//$sms_route = new Route();
		
		Route::set('sms-action', '<action> (<num>) <text>',
		array(
			'action' => '(start|join|check)',
			'num' => '\d+'
		))
		->defaults(array(
			'controller' => 'route',
			'action'     => 'blah',
		));
		
		Route::set('full', '<text>')
		->defaults(array(
			'controller' => 'route',
			'action'     => 'blah',
		));
		
		$sms_request = Request::instance( $sms );
		
		try
		{
			// Attempt to execute the response
			$sms_request->execute();
		}
		catch (Exception $e) {
				
		}
		
		echo $request->response;
		
	}
	
	public function action_blah(){
		$this->request->response = 'blah';
		
	}
	
	public function action_start(){
		$txt = $this->request->param('text');
		$num = $this->request->param('num');
		
		$this->request->response = "got here with: {$num} {$txt}";
	}
		
}