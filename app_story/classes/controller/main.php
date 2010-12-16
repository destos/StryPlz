<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Layout {

	//public function before(){}
	
	public function action_index(){
		$this->template->title = __('Home');
		$this->template->content = 'test';
	}
	
	//public function after(){}

} // End Main
