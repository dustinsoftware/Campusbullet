<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Log extends Controller_Layout {
	protected $auth_required = false;

	public function before() {
		parent::before();
		$this->template->title = "Log Viewer";
	}
	
	public function action_index() {
		Request::instance()->redirect('home');
	}
	
	public function action_userdisabled($key = null) {
		$log_row = DB::select('message','moderator_id')->from('logs')->where('key','=',$key)->execute()->current();
		if ($log_row)
			$moderator_row = DB::select('username')->from('users')->where('id','=',$log_row['moderator_id'])->execute()->current();
			
		if ($log_row && $moderator_row) {
			$content = View::factory('log_userdisabled');
			$content->message = $log_row['message'];
			$content->moderator_name = $moderator_row['username'];
			$this->template->content = $content;
		} else {
			$content = View::factory('log_userdisabled');
			$content->message = "";
			$this->template->content = $content;
		}
	}
}
