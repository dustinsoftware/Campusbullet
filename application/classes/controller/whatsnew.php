<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Whatsnew extends Controller_Layout {
	
	public function before() {
		parent::before();
		$this->template->title = "What's New";
	}

	public function action_index()
	{	
		$auth = Auth::instance();
		if ($_POST) {		
			$user_id = Session::instance()->get('user_id');
			DB::update('users')->set(array('whatsnew' => 0))->where('id','=',$user_id)->execute();
		
			Request::instance()->redirect('home');			
		} else {
			$content = View::factory('whatsnew_home');
			$content->url_base = URL::base();
			
			$announcement_row = DB::select('message','timestamp')->from('announcements')->order_by('timestamp','DESC')->execute()->current();
			
			$content->message = $announcement_row['message'];
			$content->timestamp = date("F j, Y", strtotime($announcement_row['timestamp']));
			$this->template->content = $content;
		}
		
	}
	
	public function action_announce() {
		$moderator = Session::instance()->get('moderator');
		
		if ($moderator) {
			$content = View::factory('whatsnew_announce');
			$content->message = "";
			
			if ($_POST) {
				$message = @($_POST['message']);
				
				if ($message) {
					//valid message, insert it into announcements and change everyone's read flag to 0
					DB::insert('announcements')->columns(array('message'))->values(array($message))->execute();
					DB::update('users')->set(array('whatsnew' => 1))->execute();
					
					$content->message = "Message was announced!";
				}
			}
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('whatsnew');
		}
	}

}
