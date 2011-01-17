<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Layout {

	public function before() {
		parent::before();
		
		$user_id = Session::instance()->get('user_id');
		$user_row = DB::select('role')->from('users')->where('id','=',$user_id)->and_where('role','=','admin')->execute()->current();
		if ( ! $user_row)
			Request::instance()->redirect('home');
		
	}
	
	public function action_index() {
		$content = View::factory('admin_home');
		$content->message = "";
		$content->url_base = URL::base();
		$content->user_rows = DB::select('id','username')->from('users')->order_by('create_date','DESC')->limit(5)->execute()->as_array();
		$content->activation_rows = DB::select('id','email','ipaddress')->from('registration_keys')->execute()->as_array();
		
		if ($_POST) {
			$id = @($_POST['id']);
			$reg_row = DB::select('email','key')->from('registration_keys')->where('id','=',$id)->execute()->current();
			
			if ($reg_row) {
				$secretkey = $reg_row['key'];
				$email = $reg_row['email'];
				$body = View::factory('email_thanks');				
				$body->link_register = URL::base(true,true) . "confirm/register/$secretkey";
				send_email($email, "The Campus Bullet - Thanks for signing up!", $body);		
				$content->message = "Activation email has been re-sent to $email.";
				
			} else {
				$content->message = "Couldn't find the registration row for $id.";
			}
			
		}
		
		$this->template->content = $content;
	}
	
	public function action_banip() {
		$ip = @($_GET['ip']);
		
		if ($ip) {
			$content = View::factory('admin_banip');
			$content->ip = $ip;
			$content->url_base = URL::base();
			$content->message = "";
			$content->error = "";
			
			$ip_row = DB::select('id')->from('banned_addresses')->where('ip','=',$ip)->execute()->current();
			if ($ip_row)
				$content->banned = true;
			else
				$content->banned = false;
				
			if ($_POST) {
				if ( ! $ip_row) {
					DB::insert('banned_addresses')->columns(array('ip'))->values(array($ip))->execute();
					$content->message = "The address was banned succesfully.&nbsp; However, pending registrations have been left in the system, incase some of them were legit.";			
				} else {
					DB::delete('banned_addresses')->where('ip','=',$ip)->execute();
					$content->message = "The address was unbanned successfully.";
				}
				
			}
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('admin');
		}
		
	}

}
