<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Register extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index() {
		$content = View::factory('notemplate_register');
		
		$this->template = $content;
	}
	
}
