<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Moderator extends Controller_Layout {

	public function before() {
		parent::before();
		
		$moderator = Session::instance()->get('moderator');
		
		if ( ! $moderator) {		
			Request::instance()->redirect('home');
		}
	}
	
	public function action_index() {
		array_push($this->template->styles, "moderator_home");
		$content = View::factory('moderator_home');
		$content->url_base = URL::base();
		
		$this->template->content = $content;
	}
	
	public function action_post($id = null) {
		Request::instance()->redirect("post/edit/$id");
	}
	
}
