<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Moderator extends Controller_Layout {

	public function before() {
		parent::before();
		
		$moderator = Session::instance()->get('moderator');
		
		if ( ! $moderator) {		
			Request::instance()->redirect('home');
		}
		
		$this->template->title = "Moderator Tools";
	}
	
	public function action_index() {
		array_push($this->template->styles, "moderator_home");
		$content = View::factory('moderator_home');
		$content->url_base = URL::base();
		
		$this->template->content = $content;
	}
	
	public function action_post($id) {		
		$post_row = DB::select('id','disabled','owner')->from('posts')->where('id','=',$id)->execute()->current();
		$owner_row = null;
		if ($post_row)
			$owner_row = DB::select('id','username')->from('users')->where('id','=',$post_row['owner'])->execute()->current();
		if ($post_row && $owner_row) {
			$content = View::factory('moderator_post');
			$content->post_id = $post_row['id'];
			$content->post_disabled = $post_row['disabled'];
			$content->url_base = URL::base();
			$content->owner_id = $owner_row['id'];
			$content->owner_name = $owner_row['username'];
			
			if ($_POST) {
				if ($post_row['disabled'] == 0) {
					DB::update('posts')->set(array('disabled' => '2'))->where('id','=',$post_row['id'])->execute();
					Request::instance()->redirect("contact/message/$owner_row[username]");
				}
			}
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect("home/view/$id");
		}	
		
	}	
	
	public function action_user($id) {
		$moderator_id = Session::instance()->get('user_id');
		$user_row = DB::select('*')->from('users')->where('id','=',$id)->execute()->current();
		
		if ($user_row) {
			$user_row['userhash'] = "";
			$content = View::factory('moderator_user');
			$content->message = "";
			$content->error = "";
			$content->url_base = URL::base();
			
			if (count(DB::select('id')->from('logs')->where('log_type','=','user_disabled')->and_where('regarding_user','=',$user_row['username'])->execute()) == 1)
				$content->banned_once = true;
			else
				$content->banned_once = false;
			
			if ($_POST) {
				$begin_incident = @($_POST['startincident']);
				$enable_account = @($_POST['enable']);
				$message = @($_POST['message']);
				
				if ($user_row['role'] == 'admin') {
					$content->error = "You can't disable a site admin, duh.";
				} else {
					//not an admin, continue
					if ($begin_incident) {				
						if ($user_row['disabled'] == 1) 
							$content->error = "The user has already been disabled.";				
						 else {					 
							$content = View::factory('moderator_disableuser');
							$content->user_name = $user_row['username'];
						}				
					} elseif ($message) {
						if ($user_row['disabled'] == 1) 
							$content->error = "The user has already been disabled.";				
						else {					 					
							//disable the user
							DB::update('users')->set(array('disabled' => '1'))->where('id','=',$id)->execute();
							//disable their posts
							DB::update('posts')->set(array('disabled' => '1'))->where('owner','=',$id)->execute();
							//create an entry in the log
							DB::insert('logs')->columns(array('message','log_type','regarding_user','key','moderator_id'))
								->values(array($message, 'user_disabled', $user_row['username'], sha1(rand(0,1000) . $user_row['email']), $moderator_id))->execute();
							//send the message
							$log_rows = DB::select('id')->from('logs')->where('regarding_user','=',$user_row['username'])->and_where('log_type','=','user_disabled')->execute()->as_array();
							if (count($log_rows) == 1)
								$email = View::factory('email_account_disabled_warning');
							else
								$email = View::factory('email_account_disabled_final');
							$email->url_base = URL::base();
							$email->message = $message;
							send_email($user_row['email'], "The Campus Bullet: Account Disabled", $email);
							
							//show a confirmation
							$content->message = "The user was disabled successfully and was sent a message.";
						}
					} elseif ($enable_account && $content->banned_once) {
						if ($user_row['disabled'] != 1)
							$content->error = "That user is either already active, or disabled their account manually.";
						else {
							DB::update('users')->set(array('disabled' => 0))->where('disabled','=','1')->and_where('id','=',$id)->execute();
							$email = View::factory('email_account_enabled');
							send_email($user_row['email'], "The Campus Bullet: Your Account Has Been Re-Enabled!", $email);
							$content->message = "The account was re-enabled.";
						}
					}
				}
			}
			//get the user row again for the page in case the data changed.
			$user_row = DB::select('*')->from('users')->where('id','=',$id)->execute()->current();
			$user_row['userhash'] = "";
			if (count(DB::select('id')->from('logs')->where('log_type','=','user_disabled')->and_where('regarding_user','=',$user_row['username'])->execute()) == 1)
				$content->banned_once = true;
			else
				$content->banned_once = false;
			
			$content->user_dump = print_r($user_row,true);
			$content->user_disabled = $user_row['disabled'];
			$content->user_posts = DB::select('*')->from('posts')->where('owner','=',$id)->order_by('timestamp','DESC')->execute()->as_array();
			$content->message_history = DB::select('recipient','count')->from('message_log')->where('sender','=',$id)->execute()->as_array();
			$content->log_history  = DB::select('id','message','timestamp','log_type')->from('logs')->where('regarding_user','=',$user_row['username'])->execute()->as_array();
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('moderator');
		}
	}
	
}
