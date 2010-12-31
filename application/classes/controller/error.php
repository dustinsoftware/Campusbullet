<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_404() {	
		$this->template->content = View::factory('error_404');		
	}

	public function action_500() {	
		$this->template->content = View::factory('error_500');		
	}

	
}
