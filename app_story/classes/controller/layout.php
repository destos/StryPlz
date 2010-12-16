<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Layout extends Controller_Template
{

	public function before()
	{
		parent::before();

		if ( $this->auto_render ) {
			// Initialize empty values
			$this->template->title   = '';
			$this->template->content = '';

			$this->template->styles = array();
			$this->template->scripts = array();
		}
	}

	public function after()
	{
		if ($this->auto_render) {
			
			$scripts = array(
				'lib/jquery-1.4.4-min',
				'lib/jquery.tipsy',
				'global'
			);
			
			$styles = array(
				'global',
				'tipsy'
			);
			
			//TODO usr ARR:merge?
			$this->template->scripts = array_merge( $scripts, $this->template->scripts );
			$this->template->styles	= array_merge( $styles, $this->template->styles );

		}
		parent::after();
	}
}