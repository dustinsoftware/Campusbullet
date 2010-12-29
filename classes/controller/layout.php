<?php defined('SYSPATH') or die('No direct script access.');

include 'system_email.php';

class Controller_Layout extends Controller_Template {

	protected $auth_required = true;
	
	public function before() {
		parent::before();	
		
		$auth = Auth::instance();
		
		if ($this->auth_required && ! $auth->logged_in()) {
			$path = Request::instance()->uri();
			Request::instance()->redirect("login?redir=$path");
		}		
		
		$this->template->styles = array();
		$this->template->scripts = array();
		$this->template->sidebar = "";
		$this->template->url_base = URL::base();
		$this->template->title = "";
		
		array_push($this->template->styles, 'styles/global.css');
	}
	
	public function after() {
		$this->template->url_base = URL::base();
		$this->template->user = Auth::instance()->get_user();
		parent::after();
	}

} 
