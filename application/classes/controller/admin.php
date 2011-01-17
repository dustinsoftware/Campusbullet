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
		$content->user_rows = DB::select('id','username')->from('users')->order_by('timestamp','DESC')->limit(5)->execute()->as_array();
		$content->activation_rows = DB::select('id','email','ipaddress')->from('registration_keys')->execute()->as_array();
		
		$this->template->content = $content;
	}

}
