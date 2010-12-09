<?php defined('SYSPATH') or die('No direct script access.');

class Controller_sms extends Controller_Twilio {
	
	private $teller;
	
	private $sms;
	
	public function before(){	
		return parent::before();
	}
		
	// Handle all SMS messages.
	public function action_index(){		

		// incoming post, begin processing
		if( $this->post ){
						
			Kohana::$log->add( Kohana::DEBUG, 'SMS is Incoming, number has sent txt before?' );
						
			$this->teller = ORM::factory( 'teller')->where( 'phone_number', '=', $this->post->From )->limit(1)->find();
			
			// Create new teller if none found
			if( !$this->teller->loaded() ){
				
				$this->teller = ORM::factory( 'teller' );
				$this->teller->phone_number = $this->post->From;
				$this->teller->save();
								
				Kohana::$log->add( Kohana::DEBUG, "Saving new Phone Number {$this->teller->phone_number}" );
			}else{
				Kohana::$log->add( Kohana::DEBUG, "Existing user! {$this->teller->phone_number}" );
			}
			
			// --------------------------------------------------------
			// get first word of body == action
			//
			
			$action_words = $words = explode(' ', strtolower($this->post->Body));
			$sms_action = array_shift($action_words);
			
			//
			// get next word if number use as ID or turn.
			//
			
			if(is_numeric($action_words[0]))
				$this->sms->id = (int) array_shift($action_words);
			else
				$this->sms->id = false;
			
			// implode the rest of the text
			$this->sms->txt = implode(' ',$action_words);
			$this->sms->full_txt = implode(' ',$words);	
			
			unset( $action_words, $words );
			
			$handle = 'handle_'.$sms_action;
			
			if( method_exists( $this , $handle ) ){
				Kohana::$log->add( Kohana::INFO, "Handling SMS with: {$handle}" );
				call_user_method( $handle, $this );
			}else{
				call_user_method( 'handle_default', $this );
			}
		
		// not post	
		}else{
		
		}
		
	}
	
	private function handle_start(){
	
		$sms_turns = ( $this->sms->id ) ? $this->sms->id : 10 ; // set to 10 turns by default
		
		$story = $this->teller->add_story( $txt, $sms_turns, $this->post );
		
		$this->send_sms( $this->teller->phone_number  , "Success! Tell your friends to txt us with 'join {$story->pk()}' to continue your story!" ); // {$sms_turns} turns
		
	}
	
	private function handle_join(){
	
		if( is_numeric($this->sms->id) ){
	
			Kohana::$log->add( Kohana::DEBUG, "Attemping to join {$this->sms->id} from {$this->teller->phone_number}" );
			
			$story = ORM::factory('story', $this->sms->id ); //->find()
			
			if( $story->loaded() ){
				
				// check if we already have someone set as the current teller.
				//$cur_teller = $story->current_teller->find();
				$cur_teller = $story->cur_teller;		
					
				if( empty($cur_teller) ){ //$cur_teller->loaded()
				
					Kohana::$log->add( Kohana::DEBUG, "Attemping to become teller for story {$this->sms->id} by {$this->teller->phone_number}" );
					
					// set caller as current teller
					//$story->add( 'current_teller', $this->teller );
					$story->cur_teller = $this->teller->pk(); // possible other solution
					$story->save();
					
				//If teller assigned to 
				}else if( $cur_teller == $this->teller->pk() ){
					Kohana::$log->add( Kohana::DEBUG, "Already assigned to {$this->sms->id}" );
				}else{
					Kohana::$log->add( Kohana::DEBUG, "Story already has a current teller {$cur_teller}" );
				}
				
				$parts = $story->parts->order_by('id','DESC')->find_all();
				
				foreach( $parts as $part ){
					$story_parts[] = trim($part->text);
				}
				
				$story_parts = implode( ' ', $story_parts );
				
				$this->send_sms( $this->teller->phone_number , "{$story_parts}" );					
				
			}else{
				$this->send_sms( $this->teller->phone_number , "couldn't find that story" );
			}
		
		}
		//$txt = implode(' ',$action_words);
		//$this->send_sms( $this->post->From , "you said - {$txt}" );
	}
	
	private function handle_latest(){
	
		if( $this->sms->id ){
		
			$story = ORM::factory('story', $this->sms->id ); //->find()
			
			if($story->loaded()){
			
				$parts = $story->parts->order_by('id','ASC')->find_all();
				
				foreach( $parts as $part ){
					$story_parts[] = trim($part->text);
				}
				
				$story_parts = implode( ' ', $story_parts );
				
				$this->send_sms( $this->teller->phone_number , "{$story_parts}" );					
			}
		}
	}
	
	private function handle_default(){
	
		// see if they are replying to a message and then prepend their text.
		$story = ORM::factory( 'story', array( 'cur_teller' => $this->teller->pk() ) ); //->find() //, 'locked' => false 
		
		if( $story->loaded() ){
		
			if( (bool) $story->locked ){
				$this->send_sms( $this->teller->phone_number , "Sorry this story has been finished." );
				return;
			}
			
			$this->teller->add_part( $story, $this->post->Body, $this->post );
			//$story->add_part( $this->post->Body , $this->post );
			$story->cur_teller = NULL;
			$story->cur_turn += 1;
			
			// lock 
			if( $story->cur_turn >= $story->turns )
				$story->locked = true;
				
			$story->save();
			
			$this->send_sms( $this->teller->phone_number , "you like totally added to that story dude. Now find another story and add to it!" );
		}else{
			$this->send_sms( $this->teller->phone_number , "You aren't assigned to a story, call this number for details." );
		}

	}
		
}