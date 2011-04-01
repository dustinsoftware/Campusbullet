<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Askkyle extends Controller_Layout {
	protected $auth_required = false;
	
	public function before() {
		parent::before();
		$this->template->title = "Ask Kyle";
	}
	
	public function action_index() {
		$content = View::factory('askkyle_home');
		$content->errors = array();
		
		$message = @($_POST['message']);
		$email = @($_POST['email']);
		$content->message = $message;
		$content->email = $email;
		
		$errors = array();
		
		if ($_POST) {
			if (strlen($message) == 0)
				array_push($errors, "Type something to ask Kyle!");
			if (strlen($message) > 1000)
				array_push($errors, "Your question was too long.");
			
			if ($email) {
				$validate = Validate::factory(array('email' => $email));
				$validate->rule('email','email')
					->rule('email','not_empty');
				if ( ! $validate->check()) 
					array_push($errors, "Hmmm..that wasn't a valid email address.  Type in a valid one or leave it blank.");
				
			}
			
			
			if (empty($errors)) {
				if ($email)
					send_email("kylebroda@letu.edu", "The Campus Bullet: Someone asked you a question!", $message, $email);
				else
					send_email("kylebroda@letu.edu", "The Campus Bullet: Someone asked you a question!", $message);
				
				send_email("dustin@campusbullet.net", "Kyle Question", $message);
				
				Request::instance()->redirect('askkyle/success');
			}
			
			$content->errors = $errors;
		
		}
		$this->template->content = $content;
		
	}
	
	public function action_success() {
		$this->template->content = View::factory('askkyle_success');
	}
}
