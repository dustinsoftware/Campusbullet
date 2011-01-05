<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Layout {
	public function before() {
		parent::before();
		
		array_push($this->template->styles, "account");
	}
	
	public function action_index() {
		$content = View::factory('account_home');
		$content->url_base = URL::base();
		$user_id = Session::instance()->get('user_id');
		$user_row = DB::select('email')->from('users')->where('id','=',$user_id)->execute()->current();
		
		$content->message = "";
		$content->email_address = $user_row['email'];
		$content->errors = array();
		
		if ($_POST) {
			$change_email = @($_POST['changemail']);
			$disable_account = @($_POST['disable']);
			$acknowledged = @($_POST['acknowledged']);
			$email_address = @($_POST['email']);
			$change_pw = @($_POST['changepw']);
			$errors = array();
			
			if ($disable_account && ! $acknowledged)
				array_push($errors,"You must check the box to disable your account.");
			
			elseif ($disable_account && $acknowledged) {			
				//disable all posts related to that user
				DB::update('posts')->set(array(
					'disabled' => 1))->where('owner','=',$user_id)->and_where('disabled','=',0)->execute();
				
				//disable this user
				DB::update('users')->set(array(
					'disabled' => 2))->where('id','=',$user_id)->execute();
				
				//log out the user
				Auth::instance()->logout();
				
				//and redirect to the home page.
				Request::instance()->redirect('home');
			}
			
			elseif ($change_email) {
				$validate = Validate::factory(array(
					'email' => $email_address));
				$validate->rule('email','email')
					->rule('email','not_empty');
				
				$email_inuse_row = DB::select('id')->from('users')->where('email','=',$email_address)->execute()->current();
				
				if ( ! $validate->check())
					array_push($errors,"Please enter a valid email address.");			
				elseif ($email_inuse_row) {
					if ($email_inuse_row['id'] == $user_id) {
						array_push($errors, "To change your email address, please enter a different address than the one shown below.");
					} else {
						array_push($errors, "That email address is currently held by another user.");
					}										
				}
				else {
					//valid email address, send an email
					$verify_row = DB::select('id')->from('verification_keys')->where('id','=',$user_id)->execute()->current();
					
					if ($verify_row) {
						DB::delete('verification_keys')->where('id','=',$user_id)->execute();
					}
					
					$secretkey = sha1(rand(0,1000) . $email_address);
					DB::insert('verification_keys')->columns(array('id','key','email'))->values(array($user_id,$secretkey,$email_address))->execute();
					
					$body = View::factory('email_confirm_emailchange')
						->set('key',$secretkey)
						->set('base',URL::base(true,true))
						->set('user', Auth::instance()->get_user());
					
					send_email($email_address, "masterslist - Email Confirmation", $body);
					
					$content->message = "A verification email has been sent to $email_address.&nbsp; Please click the link in the email to confirm the change.";
				}
				
				
			}
			elseif ($change_pw) {
				$current_pw = @($_POST['currentpw']);
				$new_pw = @($_POST['newpw']);
				$verify_pw = @($_POST['verifypw']);
				
				$validate = Validate::factory(array(
					'pw1' => $new_pw,
					'pw2' => $verify_pw));
				
				$validate->rule('pw1','not_empty')
					->rule('pw2','matches', array('pw1'))
					->rule('pw1','min_length', array(5))
					->rule('pw1','max_length', array(20));					
					
				
				if (! $current_pw) {
					array_push($errors, "Please enter your current password.");
				}				
				if (empty($errors) && $validate->check()) {					
					if ( ! Auth::instance()->check_password($current_pw)) {
						array_push($errors, "Your current password was incorrect.");
					} elseif (Auth::instance()->change_password($new_pw)) {
						$content->message = "Your password was changed successfully.";						
					} else {
						array_push($errors, "An unknown error occurred while changing your password.");
					}									
				} elseif ( ! $validate->check()) {
					$validate_errors = $validate->errors();
					if (array_key_exists('pw1',$validate_errors)) {
						array_push($errors, "Please enter a password that's between 5-20 characters.");						
					}
					if (array_key_exists('pw2',$validate_errors)) {
						array_push($errors, "The passwords you entered don't match!&nbsp; Please try again.");
					}				
				}
				
				
			}
			
			$content->errors = $errors;
		} elseif (isset($_GET['confirmed'])) {
			$content->message = "Your email address was confirmed.";
		}
		$this->template->content = $content;	
	}
	
	
	
	
} 
