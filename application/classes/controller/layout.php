<?php defined('SYSPATH') or die('No direct script access.');

include_once 'system_email.php';

class Controller_Layout extends Controller_Template {

	protected $auth_required = true;
	protected $dev_mode = false;
	
	public function before() {
		parent::before();	
		
		$auth = Auth::instance();
		$user_id = Session::instance()->get('user_id');
		
		if ($auth->logged_in()) {
			//double check that the user hasn't been disabled in this session
			$user_id = Session::instance()->get('user_id');
			$user_row = DB::select('disabled')->from('users')->where('id','=',$user_id)->execute()->current();
			if ($user_row['disabled'] != 0)
				$auth->logout(true);
		}
		
		if ($this->auth_required && ! $auth->logged_in()) {
			$sourcepage = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$sitepath = URL::base(false,true);
			$split = explode($sitepath,$sourcepage);
			$redir = $split[1];
			
			Request::instance()->redirect("login?redir=" . $redir);
			die("Login required");
		}		
		
		if ($this->dev_mode) {
			if ( ! $this->is_developer())
				Request::instance()->redirect('home');
		}
		
		$this->template->styles = array();
		$this->template->scripts = array();
		$this->template->sidebar = "";
		$this->template->url_base = URL::base(false,true);
		$this->template->title = "";
		
		$moderator = Session::instance()->get('moderator');
		if ($moderator)
			$this->template->moderator = true;
		else
			$this->template->moderator = false;
		
		array_push($this->template->styles, 'global');
	}
	
	public function after() {		
		$this->template->user = Auth::instance()->get_user();
		parent::after();
	}
	
	private function is_developer() {
		$user_id = Session::instance()->get('user_id');
		$user_row = DB::select('role')->from('users')->where('role','=','admin')->or_where('role','=','mod')->execute()->current();
		if ($user_row)
			return true;
			
		return false;
	}

} 
