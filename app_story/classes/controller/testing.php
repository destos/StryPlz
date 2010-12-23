<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Testing extends Controller_Twilio {
		
	// test function
	public function action_index( ){
	
		echo '<pre>';
		$twilio = Twilio::instance();
		$test = array();
		#$test['get_sandbox'] = $twilio->get_sandbox();
		#$test['get_account'] = $twilio->get_account();
		#$test['set_account'] = $twilio->set_account_name('Patrick\'s Twilio Account');
		
		print_r( $test );
		
		echo '</pre>';
		$this->auto_respond = false;
	}
	
	public function action_db_check(){
	
		$stories = ORM::factory('story')->find_all();
		
		if( $stories ){
			echo 'loaded stories ';
			foreach( $stories as $story ){
				//print_r($story);
				echo $story->id.'-';
			}
		}
		
		$this->auto_respond = false;
	}
	
	public function action_sms(){
	
		Twilio::instance()->send_sms(array(
			'To' => '+18458030695',
			'Body' => "testing SMS" ));
			
	}
	
	public function action_story(){
		
		//Kohana::$log->add( Kohana::DEBUG, "Looking up a randome story for testing" );
		
		//$stories = ORM::factory('story')->
		
		//$story = ;
		
		echo (string) ORM::factory( 'story', 3 );
		
		$this->auto_respond = false;
	}
	
	public function action_text(){
		echo $text = Text::limit_chars_left( "lots of people and makes can participate in creating stories! I know! It's pretty cool, and stuff. I would like to let everyone know that others may be watching. Very closely... Tarestrial flight", 160, '...', false );
		
		echo strlen( $text );
		
		$this->auto_respond = false;
	}
}