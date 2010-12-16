<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller {

	public function before(){}
	
	public function action_index(){
		
		$twilio_number = Twilio::$AppNumber;
		
		$this->request->response = "Start a story! Call ".$twilio_number." for info.";
	}
	
	public function after(){}

} // End Main
