<?php defined('SYSPATH') or die('No direct access allowed.');
class Model_Story extends ORM {

	protected $_table_name  = 'stories';
	
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
	
	public function add_part( $text, $post ){
				
		$part = ORM::factory( 'part' );
		$part->text = $text;
		$part->SmsSid = $post->SmsSid;
		$part->save();
		
		$this->add( 'parts', $part );
		
		return $part; // returns part for continued asignment to teller and anything else.
	}
	
}