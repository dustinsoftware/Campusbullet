<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Help extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index($page = null) {
		try {		
			if ($page) {
				$this->template->content = View::factory("help_$page")->set('url_base',URL::base());
			} else {
				$this->template->content = View::factory('help_home')->set('url_base',URL::base());
			}
			
		} catch (Exception $e) {
			Request::instance()->redirect('help');
		}
		
	}	
	
}
