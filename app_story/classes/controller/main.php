<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Layout {

	//public function before(){}
	
	public function action_index(){
		
	  Request::instance()->redirect( Route::get('stories')->uri() );
		
		return;
		
		$this->template->title = __('Home');
		
		// request stories route and send.
		$stories_route = Route::get('stories')->uri();
		//echo $stories_route;
		
		$r = Request::factory( $stories_route );
		
		echo $r->execute()->response;
		
		$this->auto_render = false;
	}
	
	//public function after(){}

} // End Main
