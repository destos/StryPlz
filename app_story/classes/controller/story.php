<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Story extends Controller_Layout {

	public function before(){
	
		return parent::before();
		
	}
	
	// retreive single story
	public function action_single(){
		
		$story = ( is_numeric( $this->request->param('id') ) )
		?	ORM::factory( 'story', $this->request->param('id') )
		: ORM::factory( 'story', array( 'slug' => $this->request->param('slug') ) ) ;
		
		// load error view on not found
		if( !$story->loaded() ){
			$this->template->content = View::factory('story/notfound');
			return;
		}
		
		$this->template->content = $story;
		
	}
	
	public function action_browse(){
		
		// load view and bind vars.
		$this->template->content = View::factory('story/list')
			->bind('stories', $stories)
			->bind('pagination', $pagination);
		
		// load story orm
		$stories = ORM::factory('story');
		
		// get count of stories
		$count = $stories->count_all();
		
		//setup pagination.
		$pagination_obj = Pagination::factory(array(
  		'total_items'    => $count,
  		'items_per_page' => 10,
  	));
  	
  	// load our story set
		$stories = $stories->order_by('id','DESC')
  			->limit($pagination_obj->items_per_page)
  			->offset($pagination_obj->offset)->find_all();
		
		$pagination = $pagination_obj->render();
				
		$this->template->title = __('Stories : page :page', array(':page'=> $pagination_obj->current_page));
		
	}
		
	public function after(){	
		
		return parent::after();
		
	}
	
}