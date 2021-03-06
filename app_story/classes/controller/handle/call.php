<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Handle_Call extends Controller_Twilio {

	public function action_index(){
		$this->response->addSay( 'To start a story text start followed by the beginning of your story to this number.');
		$this->response->addGather( array(
		'action'=> URL::site( Route::get('twilio-call')->uri( array(
			'action' => 'extra'
			)),true),'numDigits' => '1') )
		->addSay('Press 1 for info on how to join a story. Press 2 to hear a random completed story.');
		$this->response->addSay('Good bye!');
	}
	
	public function action_extra(){
	
		if(!$this->post)
			return;
				
		switch($this->post->Digits){
			case 1:
				$this->response->addSay('To join in a random existing story text "join" to this number. If you wish to join an existing story text join followed by that stories ID.');
				break;
			case 2:
				// load in an actual story.
				$this->response->addSay('There once was a boy by the name of ozwald, he didn\'t like taking out the trash. The end.');
				break;
		}
		
	}
	
}