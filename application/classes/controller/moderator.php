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
	
	public function action_beta() {
		$content = View::factory('moderator_beta');
		$content->message = "";
		
		
		if ($_POST) {
			$users = @($_POST['user']);
			
			foreach ($users as $userid) {				
				$user_row = DB::select('email')->from('beta_requests')->where('activated','=',0)->and_where('id','=',$userid)->execute()->current();
				
				//valid user, activate the account
				if ($user_row) {		
					$email = $user_row['email'];
					$secretkey = sha1(rand(0,1000) . $email);
					DB::insert('registration_keys')->columns(array('email','key'))->values(array($email,$secretkey))->execute();
					
					$body = View::factory('email_thanks');				
					$body->link_register = URL::base(true,true) . "confirm/register/$secretkey";
					
					send_email($email, "The Campus Bullet - The Beta is Ready!!!", $body);		
					
					DB::update('beta_requests')->set(array('activated'=>'-1'))->where('email','=',$email)->execute();
				}
			}
			
			$content->message = "The users were activated and sent emails successfully.&nbsp; Woot!";
		
		}
		
		$user_rows = DB::select('id','email')->from('beta_requests')->where('activated','=',0)->execute()->as_array();
		$content->users = $user_rows;
		
		$this->template->content = $content;
	}
	
}
