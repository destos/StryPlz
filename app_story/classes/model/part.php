<?php defined('SYSPATH') or die('No direct access allowed.');
class Model_Part extends ORM {

	protected $_table_name  = 'parts';
	
	public function save(){
		
		// add registered time if we are creating a new entry.
		if( $this->empty_pk() ){
			$this->__set( 'added', time() );
		}
		
		return parent::save();
	}
	
	// When typed as string return text
	public function __toString(){
	
		if( $this->empty_pk() and empty($this->text) )
			return '';
			
		return trim($this->text);
	}
	
}