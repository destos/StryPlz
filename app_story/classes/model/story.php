<?php defined('SYSPATH') or die('No direct access allowed.');
class Model_Story extends ORM {

	protected $_table_name  = 'stories';
	
	protected $_story_parts = array();
	
	protected $_has_many = array(
		'parts' => array(
			'model' => 'part',
			'through' => 'stories_parts'
		)
	);
	
	protected $_has_one = array(
		//'current_teller' => array( 'model' => 'teller', 'foreign_key' => 'id', 'far_key' => 'cur_teller' ),
		'owner' => array( 'model' => 'teller', 'foreign_key' => 'id' )
	);
	
	protected $_belongs_to = array(
		'current_teller' => array( 'model' => 'teller', 'foreign_key' => 'id', 'far_key' => 'cur_teller' ),
	);
	
	
	public function save(){
		
		// add registered time if we are creating a new entry.
		if( $this->empty_pk() ){
			$this->__set( 'started', time() );
			$this->__set( 'slug', Text::random( 'alpha', 5 ) );
		}
		
		return parent::save();
	}
	
	public function add_part( $text, $post ){
				
		$part = ORM::factory( 'part' );
		$part->text = $text;
		$part->SmsSid = $post->SmsSid;
		$part->save();
		
		$this->add( 'parts', $part );
		
		return $part; // returns part for continued asignment to teller and anything else.
	}

	
	// --------------------------------------------------------
	// Retreiving parts/story
	//
		
	public function get_parts(){
	
		if( $this->empty_pk() )
			return array();
					
		if( empty($this->_story_parts) ){
		
			$parts = $this->parts->order_by('id','ASC')->find_all();
			
			foreach( $parts as $part ){
				$this->_story_parts[] = $part;
			}
			
		}
		
		return $this->_story_parts;
		
	}
		
	public function full_story(){
		return (string) implode( ' ', $this->get_parts() );
	}
	
	// Concatinate entire story when typed as string.
	public function __toString(){
		return (string) $this->full_story();
	}
	
	// --------------------------------------------------------
	// 
	//
	
	public function get_link(){
	
		if( $this->empty_pk() )
			return false;
		
		// get short route.			
		return URL::site( Route::get('story')->uri( array( 'access' => 's', 'slug' => $this->__get('slug') ) ), true );
	}
	
}