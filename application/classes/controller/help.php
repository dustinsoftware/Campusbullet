<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Help extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index($page = null) {
		try {		
			if ($page == 'about') {
				$content = View::factory('help_about');
				$content->url_base = URL::base();
				$content->beta_testers = DB::select('username')->from('users')->where('role','=','user')->and_where('disabled','=','0')->execute()->as_array();
				$this->template->content = $content;
			} elseif ($page) {
				$this->template->content = View::factory("help_$page")->set('url_base',URL::base());
			} else {
				$this->template->content = View::factory('help_home')->set('url_base',URL::base());
			}
			
		} catch (Exception $e) {
			Request::instance()->redirect('help');
		}
		
	}	
	
}
