<?php defined('SYSPATH') or die('No direct script access.');

include_once('system_email.php');

class Controller_Ajax extends Controller {
	public function action_bugreport() {
		$page = @($_POST['page']);
		
		if ($page) {
			send_email("dustin@campusbullet.net","Automatic Bug Report", htmlspecialchars($page));
			Request::instance()->response = "OK";	
		} else {
			Request::instance()->response = "FAIL";
		}
		
	}
}