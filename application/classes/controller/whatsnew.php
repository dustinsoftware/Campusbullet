<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Whatsnew extends Controller_Layout {
	public $auth_required = false;
	
	public function before() {
		parent::before();
		$this->template->title = "What's New";
	}

	public function action_index()
	{	
		if ($_POST) {		
			Request::instance()->redirect('home');			
		} else {
			$content = View::factory('whatsnew_home');
			$content->url_base = URL::base();
			
			$announcement_row = DB::select('message','timestamp')->from('announcements')->order_by('timestamp','DESC')->execute()->current();
			Cookie::set('lastvisit',$announcement_row['timestamp'],31536000); // set the cookie to the last announcement row..
		
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
					$content->message = "Message was announced!";
				}
			}
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('whatsnew');
		}
	}
	
	public function action_dontcare() {
		$announcement_row = DB::select('message','timestamp')->from('announcements')->order_by('timestamp','DESC')->execute()->current();
		Cookie::set('lastvisit',$announcement_row['timestamp'],31536000); // set the cookie to the last announcement row..
		Request::instance()->redirect('home');
	}

}
