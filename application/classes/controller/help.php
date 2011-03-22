<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Help extends Controller_Layout {

	protected $auth_required = false;
	
	public function before() {
		parent::before();
		$this->template->title = "Help";
	}
	
	
	public function action_index($page = null) {
		$config = Kohana::config('masterlist');
		try {		
			if ($page == 'about') {
				$content = View::factory('help_about');
				$content->url_base = URL::base();
				$content->version = $config['version'];
				$content->beta_testers = DB::select('username')->from('betatesters')->execute()->as_array();
				$content->user_count = count(DB::select('id')->from('users')->where('role','=','user')->execute()->as_array());
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
