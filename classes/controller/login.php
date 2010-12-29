<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index()
	{
		$auth = Auth::instance();
		$redir = @($_GET['redir']);
		$content = View::factory('notemplate_login');
		$content->error = "";
		$post_user = @($_POST['user']);
		$post_pass = @($_POST['asdf']);
		
		//check if the user is already logged in
		if ( ! $redir)
			$redir = 'home';
		
		if ($auth->logged_in())
			Request::instance()->redirect($redir);
		
		
		//check credentials and redirect if successful
		if ($post_user && $post_pass) {
			if ($auth->login($post_user, $post_pass)) {
				Request::instance()->redirect($redir);
			} else {
				$hash = $auth->hash($post_pass);
				$content->error = "Sorry, that username and password didn't work.";
			}
		}
		
		$this->template = $content;
	}
	
	public function action_logout() {
		$redir = 'home';
		$auth = Auth::instance();
		
		if ($auth->logged_in())
			$auth->logout(true);
			
		Request::instance()->redirect($redir);			
	}

}
