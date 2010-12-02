<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Incoming extends Controller_Twilio {

	public function action_index(){
		$this->tw_response->addSay( 'To start a story text start followed by the beginning of your story to this number.');
		$this->tw_response->addGather( array(
		'action'=> URL::site( Route::get('default')->uri( array(
			'controller'=>'incoming',
			'action' => 'extra'
			)),true),'numDigits' => '1') )
		->addSay('Press 1 for info on how to join a story. Press 2 to hear a random completed story.');
		$this->tw_response->addSay('Good bye!');
	}
	
	public function action_extra(){
		
		switch($this->post->Digits){
			case 1:
				$this->tw_response->addSay('To join in a random existing story text "join" to this number. If you wish to join an existing story text join followed by that stories ID.');
				break;
			case 2:
				// load in an actual story.
				$this->tw_response->addSay('There once was a boy by the name of ozwald, he didn\'t like taking out the trash. The end.');
				break;
		}
		
	}
	
}