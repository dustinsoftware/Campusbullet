<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Register extends Controller_Layout {

	protected $auth_required = false;
	public $template = 'template_register';
	
	public function before() {
		parent::before();
		
		if (Auth::instance()->logged_in()) {
			Request::instance()->redirect('home');
		}		
	}
	
	public function action_index() {		
		if (Session::instance()->get('verifiedemail')) {
			Request::instance()->redirect('register/emailconfirmed');
		}
		
		$content = View::factory('register_home');
		$content->errors = array();
		
		if ($_POST) {
			$errors = array();
			$email = @($_POST['email']);
			
			$verify_row = DB::select('id')->from('registration_keys')->where('email','=',$email)->execute()->current();
			$email_row = DB::select('id')->from('users')->where('email','=',$email)->execute()->current();
			
			$validate = Validate::factory(array('email' => $email));
			$validate->rule('email','email')
				->rule('email','not_empty');
			
			if ( ! $validate->check()) {
				array_push($errors, "Please enter a valid email address.");								
			} elseif ($email_row) {
				array_push($errors, "That email address has already been registered!");
			} elseif ($verify_row) {
				array_push($errors, "An email has already been sent to this email address.&nbsp; Please check your inbox, or send an email to ml_bugs@dustinsoftware.com to reset that address.");
			} elseif ( ! strpos(strtolower($email), "@letu.edu")) {
				array_push($errors, "Sorry, only @letu.edu address are accepted at this time.");			
			} else {
				//good email and no previous entry, put it in and give the confirmation.
				$secretkey = sha1(rand(0,1000) . $email);
				
				DB::insert('registration_keys')->columns(array('email','key'))->values(array($email,$secretkey))->execute();
				
				$body = View::factory('email_thanks');				
				$body->link_register = URL::base(true,true) . "confirm/register/$secretkey";
				
				send_email($email, "The MasterList - Thanks for signing up!", $body);		
				$content = View::factory('register_checkemail')->set('email',$email);
			}
			
			$content->errors = $errors;
		}
		
		
		$this->template->content = $content;
	}
	
	public function action_emailconfirmed() {
		$email = Session::instance()->get('verifiedemail');
			
		if ($email) {
			$content = View::factory('register_step2');
			$content->email = $email;
			$emailexploded = explode("@",$email);
			$content->user = $emailexploded[0];
			$content->errors = array();
			
			if ($_POST) {				
				$username = @($_POST['user']);
				$pw1 = @($_POST['pw1']);
				$pw2 = @($_POST['pw2']);
				$errors = array();
				
				$validate = Validate::factory(array(
					'username' => $username,
					'pw1' => $pw1,		
					'pw2' => $pw2,
					));
					
				$validate->rule('username','not_empty')
					->rule('pw1','not_empty')
					->rule('username','alpha_dash')
					->rule('username','min_length', array(5))
					->rule('username','max_length', array(20))
					->rule('pw2','matches', array('pw1'))
					->rule('pw1','min_length', array(5))
					->rule('pw1','max_length', array(12));
								
				$dupe_user_row = DB::select('id')->from('users')->where('username','=',$username)->execute()->current();
				if ($dupe_user_row) {
					array_push($errors, "That username is already taken.");
				}
				
				if (strtolower(substr($username,0,3)) == "ml_") {
					array_push($errors, "Usernames starting with ml_ are reserved for staff members.");
				}
					
				if ($validate->check() && empty($errors)) {					
					
					$hashpw = Auth::instance()->hash_password($pw1);
					//create the user
					DB::insert('users')->columns(array('username','userhash','email'))->values(array($username,$hashpw,$email))->execute();
					//delete the verification key
					DB::delete('registration_keys')->where('email','=',$email)->execute();
					//log in the user
					Auth::instance()->login($username,$pw1);
					//and finally, show the welcome page
					Request::instance()->redirect('welcome');
				} else {				
					$formerrors = $validate->errors();					
					if (array_key_exists("username",$formerrors))
						array_push($errors,"Please enter a username with only letters, numbers, dashes, and underscores and between 5-20 characters.");
					if (array_key_exists("pw1",$formerrors))
						array_push($errors,"Please enter a password between 5-12 characters.");
					if (array_key_exists("pw2",$formerrors))
						array_push($errors,"The password you entered didn't match!&nbsp; Please try again.");
					$content->errors = $errors;
				}
			}
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('home');
		}
	}
	
	public function action_forgotpassword() {
		$content = View::factory('register_forgotpassword');
		$content->errors = array();
		$verified_email = Session::instance()->get('forgotpw_email');
		$auth = Auth::instance();
		
		if ($verified_email) {
			$content = View::factory('register_resetpassword');
			
			$content->errors = array();
			
			if ($_POST) {			
				$errors = array();
				$pw1 = @($_POST['pw1']);
				$pw2 = @($_POST['pw2']);
				
				$validate = Validate::factory(array(
					'pw1' => $pw1,
					'pw2' => $pw2));
					
				$validate->rule('pw1','not_empty')
					->rule('pw2','matches', array('pw1'))
					->rule('pw1','min_length', array(5))
					->rule('pw1','max_length', array(12));
					
				if ($validate->check()) {
					DB::delete('verification_keys')->where('email','=',$verified_email)->execute();
					DB::update('users')->set(array('userhash' => $auth->hash_password($pw1)))->where('email','=',$verified_email)->execute();
					
					$user_row = DB::select('username')->from('users')->where('email','=',$verified_email)->execute()->current();
					
					if ($auth->login($user_row['username'],$pw1)) {
						Request::instance()->redirect('home');
					} else {
						Request::instance()->redirect('login');
					}
				} else {
					$validate_errors = $validate->errors();
					if (array_key_exists('pw1',$validate_errors)) {
						array_push($errors, "Please enter a password between 5-12 characters.");						
					}
					if (array_key_exists('pw2',$validate_errors)) {
						array_push($errors, "The passwords you entered don't match!&nbsp; Please try again.");
					}
				}
				
				$content->errors = $errors;
			}
		} elseif ($_POST) {
			$errors = array();
			$email = @($_POST['email']);
			$user_row = DB::select('id')->from('users')->where('email','=',$email)->execute()->current();
			
			if ($user_row) {
				$verify_row = DB::select('key')->from('verification_keys')->where('id','=',$user_row['id'])->execute()->current();
				$secretkey;
				
				if ($verify_row) {
					$secretkey = $verify_row['key'];
				} else {
					$secretkey = sha1(rand(0,1000) . $email);
					DB::insert('verification_keys')->columns(array('id','key','email'))->values(array($user_row['id'],$secretkey,$email))->execute();					
				}
				
				$body = View::factory('email_forgotpassword')
					->set('url_base',URL::base(true,true))
					->set('key',$secretkey);
					
				send_email($email, "The MasterList - Password reset", $body);
				$content = View::factory('register_forgotpassword_checkemail');
			} else {
				array_push($errors,"Sorry, that email address hasn't been registered in the system.");
			}
			
			$content->errors = $errors;
		}
		
		$this->template->content = $content;
	}
	
}
