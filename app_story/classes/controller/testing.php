<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Testing extends Controller_Twilio {
		
	// test function
	public function action_index( ){
	
		echo '<pre>';
		$twilio = Twilio::instance();
		//$test['get_sandbox'] = $twilio->get_sandbox();
		//$test['get_account'] = $twilio->get_account();
		//$test['set_account'] = $twilio->set_account_name('Patrick\'s Twilio Account');
		
		print_r( $test );
		
		echo '</pre>';
		$this->auto_respond = false;
	}
	
}