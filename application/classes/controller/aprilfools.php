<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Aprilfools extends Controller_Layout {
	protected $dev_mode = true;
	
	public function before() {
		parent::before();
		$this->template->title = "Ask Kyle";
	}
	
	public function action_index() {
		$content = View::factory('aprilfools_home');
		$content->errors = array();
		
		if ($_POST) {
			array_push($content->errors, "Kyle is busy taking a dump.&nbsp; Write him later, jeez!");
		}
		$this->template->content = $content;
		
	}
}
