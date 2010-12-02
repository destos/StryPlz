<?php defined('SYSPATH') or die('No direct access allowed.');
class Model_Teller extends ORM {
	
	protected $_table_name  = 'tellers';
	
	protected $_has_many = array(
		'stories' => array(
			'model' => 'story',
			'through' => 'tellers_stories'
		),
		'parts' => array(
			'model' => 'part',
			'through' => 'tellers_parts'
		)
	);
	
	// date_created is the column used for storing the creation date.  Use TRUE to store a timestamp
	protected $_created_column = array( 'column' => 'joined', 'format' => TRUE );
	
	// add new story and start it off with a new part.
	public function add_story( $text, $turns, $post ){
		
		$story = ORM::factory( 'story' );
		$story->turns = $turns;
		$story->save();
		
		// add part to teller
		$part = $story->add_part( $text , $post );
		
		// add story owner to teller as well as first part.
		$this->add( 'stories', $story )->add( 'parts', $part );
		
		// return story obj
		return $story;
				
	}
	
	// add part to story and user but don't create new story. accepts story id or OBJ
	
	public function add_part( $story, $text, $post ){
		
		// passing story obj TODO check that it is the correct obj
		if( ! is_object($story) ){
			$story = ORM::factory( 'story', $story );
		}
		
		$part = $story->add_part( $text, $post );
		
		return $this->add( 'parts', $part );
	}
	
}