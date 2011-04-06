<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contact extends Controller_Layout {

	public function before() {
		parent::before();
		$this->template->title = "Contact";
	}
	public function action_index() {
		Request::instance()->redirect('help');
	}
	
	public function action_message($recipient_name = null) {
		$is_moderator = Session::instance()->get('moderator');
		
		$content = View::factory('contact_message');
		$content->form_to = $recipient_name;
		$content->form_message = "";
		$content->show_form = true;
		$content->message = "";
		$content->errors = array();
		
		
		if ($recipient_name)
			$content->fixed_recipient = true;
		else
			$content->fixed_recipient = false;
		$content->base = URL::base();
		
		if (isset($_GET['postid'])) {
			$content->form_message = "Regarding post id: " . $_GET['postid'] . "\r\n\r\n";
		} 
		
		
		
		if ($_POST) {
			$message = @(htmlspecialchars($_POST["message"]));
			$recipient = @(htmlspecialchars($_POST["to"]));
			
			//fill form data
			$content->form_to = $recipient;
			$content->form_message = $message;
			
			//validate the data before we submit it
			$validation_errors = array();
			
			//check the recipient
			$recipient_row = DB::select('id','role','email','username')->from('users')->where('username','=',$recipient)->execute()->current();
			if ( ! $recipient_row) 
				array_push($validation_errors, "Invalid recipient.");
			if (strtolower(substr($recipient,0,3)) != "ml_" && ! $is_moderator) {
				array_push($validation_errors, "Only Campus Bullet staff can be messaged.");
			}
			//get our id
			$session = Session::instance();
			$user_id = $session->get("user_id");
			
			//strip the message
			if (empty($message))
				array_push($validation_errors, "No message was entered!");
			
			
			//check for self sender
			if ($user_id == $recipient_row['id'])
				array_push($validation_errors, "You can't send a message to yourself.");
			
			if ($validation_errors) {
				$content->errors = $validation_errors;
			} else {
				//we're good, send the message!
				$content->show_form = false;
				
				//check if the user has an inbox. if they do, make a copy and log it. only needed for admins, mods, and system accounts.
				if ($recipient_row['role'] == "admin" || $recipient_row['role'] == "mod" || $recipient_row['role'] == "system" ) {
					DB::insert('messages')->columns(array('sender','recipient','message'))->values(array($user_id, $recipient_row['id'], $message))->execute();				
				} 
				
				//send a message
				$email = $recipient_row['email'];
				$subject = "The Campus Bullet: Message from " . Auth::instance()->get_user();
				$body = View::factory('email_template');
				$body->message = $message;
				$body->username = Auth::instance()->get_user();
				$body->base = URL::base(false,true);
								
				send_email($email, $subject, $body);
				
				$content = View::factory('contact_message_success')->set('url_base', URL::base());
			}
		
		}
		$this->template->content = $content;
	}
	
	public function action_want($id = null) { 
		$post_row = DB::select('name','owner','wanted')->from('posts')->where('id','=',$id)->and_where('disabled','=','0')->execute()->current();
		$post_owner_row = @(DB::select('email','id')->from('users')->where('id','=',$post_row['owner'])->and_where('disabled','=','0')->execute()->current());	
		$user_id = Session::instance()->get('user_id');
		$user_row = DB::select('email')->from('users')->where('id','=',$user_id)->execute()->current();
		
		if ($post_row && $post_owner_row) {						
			$wanted = $post_row['wanted'];
			$content = View::factory('contact_want');
			$content->show_form = true;
			$content->message = "";
			$content->wanted = $wanted;
			$content->post_name = $post_row['name'];
			$content->id = $id;
			$content->base = URL::base();
			$content->form_message = "";
			
			if ($post_row['owner'] == $user_id) {
				$content = View::factory('contact_error_self');
			}			
			elseif ($_POST) {
				$errors = array();
				$message = @(htmlspecialchars($_POST["message"])) or array_push($errors, "No message was entered.");
				
				//fill form data
				$content->form_message = $message;
				
				if ($errors) {
					$content->message = "Sorry, there was a problem.&nbsp; " . implode(",",$errors);
				} else {
					$content->show_form = false;
					
					//log the send, but don't log the message!
					$log_row = DB::select('count')->from('message_log')->where('sender','=',$user_id)->and_where('recipient','=',$post_owner_row['id'])->execute()->current();
					if ($log_row)
						DB::update('message_log')->set(array('count' => $log_row['count'] + 1))->where('sender','=',$user_id)->and_where('recipient','=',$post_owner_row['id'])->execute();
					else
						DB::insert('message_log')->columns(array('count','sender','recipient'))->values(array('1',$user_id,$post_owner_row['id']))->execute();
						
					//send a message
					$email = $post_owner_row['email'];
					$body = View::factory('email_want');
					
					if ($wanted) {
						$body->wanted = true;
						$subject = "The Campus Bullet: " . Auth::instance()->get_user() .  " has your item!";
					} else {
						$body->wanted = false;
						$subject = "The Campus Bullet: " . Auth::instance()->get_user() .  " wants your item!";
					}
					$body->message = $message;
					$body->username = Auth::instance()->get_user();
					$body->post_name = $post_row['name'];
					$body->id = $id;
					$body->sender_email = $user_row['email'];
					$body->base = URL::base(false,true);
									
					send_email($email, $subject, $body, $body->sender_email);
					
					$content = View::factory('contact_want_success')->set('url_base', URL::base());
				}
				
			}
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('home');
		}
	}
	
	
}
