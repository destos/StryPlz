<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller {

	public function action_index()
	{
		$config = Kohana::config('twilio');
		$this->request->response = "Start a story! Call {$config->App_Number} for info.";
	}

} // End Home
