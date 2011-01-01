<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Help extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index($page = null) {
		try {		
			if ($page) {
				$this->template->content = View::factory("help_$page");
			} else {
				$this->template->content = View::factory('help_home');
			}
			
		} catch (Exception $e) {
			Request::instance()->redirect('help');
		}
		
	}	
	
}
