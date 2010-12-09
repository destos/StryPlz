<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{
		//print_r();
		$twilio = Twilio::instance();
		$this->request->response = "Start a story! Call ".$twilio->$AppNumber." for info.";
	}

} // End Home
