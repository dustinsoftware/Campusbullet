<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Register extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index() {
		$content = View::factory('notemplate_register');
		$content->error = "Registrations are disabled at this time.&nbsp; Please sign up for a beta account <a href=\"http://beta.dustinsoftware.com/masterlist-beta\">here</a>.";

		$this->template = $content;
	}
	
}
