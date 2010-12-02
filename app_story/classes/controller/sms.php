<?php defined('SYSPATH') or die('No direct script access.');

class Controller_sms extends Controller_Twilio {
	
	
	private $config;
	
	public function before(){
	
		$this->config = Kohana::config('twilio');
		
		return parent::before();
	}
	
	// Handle all SMS messages.
	public function action_index(){
		
		// 
		//determine what action to take.
		//$this->post
		
		//if( $this->post )
			//Kohana::$log->add( Kohana::ERROR, $this->post );
		
		//if( $this->get )
			//Kohana::$log->add( Kohana::ERROR, $this->get );
			

		// proccess 
		if( $this->post ){
						
			Kohana::$log->add( Kohana::DEBUG, 'SMS is Incoming, has sent txt before?' );
			
			$number = $this->post->From;//Helper_Phone::format($this->post->From);
			
			$teller = ORM::factory( 'teller')->where( 'phone_number', '=', $number )->limit(1)->find();
			//, array( 'phone_number' => $number ) 
			if( !$teller->loaded() ){
				
				$teller = ORM::factory( 'teller' );
				$teller->phone_number = $number;
				$teller->save();
				
				unset($number);
				
				Kohana::$log->add( Kohana::DEBUG, "Saving new Phone Number {$teller->phone_number}" );
			}else{
				Kohana::$log->add( Kohana::DEBUG, "Existing user! {$teller->phone_number}" );
			}
			
			//get first word of body == action
			$action_words = $words = explode(' ', strtolower($this->post->Body));
			$sms_action = array_shift($action_words);
			
			// get next word if number use as ID or turn.
			if(is_numeric($action_words[0])){
				$sms_id = array_shift($action_words);
			}else{
				$sms_id = false; // default turns
			}
			
			// implode the rest of the text
			$txt = implode(' ',$action_words);
			$full_txt = implode(' ',$words);
			
			switch( $sms_action ){
			
				// User wants to join a story.
				case 'join':
					
					if( is_numeric($sms_id) ){

						Kohana::$log->add( Kohana::DEBUG, "Attemping to join {$sms_id} from {$teller->phone_number}" );
						
						$story = ORM::factory('story', $sms_id ); //->find()
						
						if( $story->loaded() ){
							
							// check if we already have someone set as the current teller.
							//$cur_teller = $story->current_teller->find();
							$cur_teller = $story->cur_teller;		
								
							if( empty($cur_teller) ){ //$cur_teller->loaded()
							
								Kohana::$log->add( Kohana::DEBUG, "Attemping to become teller for story {$sms_id} by {$teller->phone_number}" );
								
								// set caller as current teller
								//$story->add( 'current_teller', $teller );
								$story->cur_teller = $teller->pk(); // possible other solution
								$story->save();
								
							//If teller assigned to 
							}else if( $cur_teller == $teller->pk() ){
								Kohana::$log->add( Kohana::DEBUG, "Already assigned to {$sms_id}" );
							}else{
								Kohana::$log->add( Kohana::DEBUG, "Story already has a current teller {$cur_teller}" );
							}
							
							$parts = $story->parts->order_by('id','ASC')->find_all();
							
							foreach( $parts as $part ){
								$story_parts[] = trim($part->text);
							}
							
							$story_parts = implode( ' ', $story_parts );
							
							$this->send_sms( $teller->phone_number , "{$story_parts}" );					
							
						}else{
							$this->send_sms( $teller->phone_number , "couldn't find that story" );
						}
					
					}
					//$txt = implode(' ',$action_words);
					//$this->send_sms( $this->post->From , "you said - {$txt}" );
					
					break;
					
				// User wants to start a new story
				case 'start':
					
					$sms_turns = ( $sms_id ) ? $sms_id : 10 ; // set to 10 turns by default
					
					$story = $teller->add_story( $txt, $sms_turns, $this->post );
					
					$this->send_sms( $teller->phone_number  , "Success! Tell your friends to txt us with 'join {$story->pk()}' to continue your story!" ); // {$sms_turns} turns
					
					break;
				case 'latest':
					// text back the trailing end of the story.
					if( $sms_id ){
					
						$story = ORM::factory('story', $sms_id ); //->find()
						
						if($story->loaded()){
						
							$parts = $story->parts->order_by('id','ASC')->find_all();
							
							foreach( $parts as $part ){
								$story_parts[] = trim($part->text);
							}
							
							$story_parts = implode( ' ', $story_parts );
							
							$this->send_sms( $teller->phone_number , "{$story_parts}" );					
						}
					}
					
					
					break;
					
				default:
					// see if they are replying to a message and then prepend their text.
					$story = ORM::factory( 'story', array( 'cur_teller' => $teller->pk() ) ); //->find() //, 'locked' => false 
					
					if( $story->loaded() ){
					
						if( (bool) $story->locked ){
							$this->send_sms( $teller->phone_number , "Sorry this story has been finished." );
							return;
						}
						
						$teller->add_part( $story, $this->post->Body, $this->post );
						//$story->add_part( $this->post->Body , $this->post );
						$story->cur_teller = NULL;
						$story->cur_turn += 1;
						
						// lock 
						if( $story->cur_turn >= $story->turns )
							$story->locked = true;
							
						$story->save();
						
						$this->send_sms( $teller->phone_number , "you like totally added to that story dude. Now find another story and add to it!" );
					}else{
						$this->send_sms( $teller->phone_number , "You aren't assigned to a story, call this number for details." );
					}
										
					break;
			}
		
		// not post	
		}else{
		
		}
		
	}
	
	private function send_sms( $phone = false, $message = 'test', $callback = false ){
		
		if(!$phone)
			return;
			
		// trim message inteligently.
		$message = TEXT::limit_chars_left( $message, 150, '&hellip;', false );
		
		$data = array(
			'From' => $this->config->App_Number,
			'To' => $phone,
			'Body' => $message
		);
		
		// if no callback url is given use default
		if( !is_string($callback) ){
			$data['StatusCallback'] = URL::site( Route::get('default')->uri(
				array(
				'controller' => 'sms',
				'action' => 'status'
			)), true);			
		}else{
			// use another callback url
			$data['StatusCallback'] = $callback;
		}
		
		Kohana::$log->add( Kohana::DEBUG, "Sending SMS : {$message} To: {$phone}" );
		
		$sent = $this->tw_client->request("/2010-04-01/Accounts/{$this->config->AccountSid}/SMS/Messages",'POST', $data );
			
		if( (bool) $sent->IsError){
			Kohana::$log->add( Kohana::ERROR, "SMS :{$sent->ErrorMessage}" );
		}
		
	}
	
	public function action_status(){
		
		// log sms status
		Kohana::$log->add( Kohana::DEBUG, "SmsStatus for {$this->post->SmsSid}:{$this->post->SmsStatus}" );
		
	}
}