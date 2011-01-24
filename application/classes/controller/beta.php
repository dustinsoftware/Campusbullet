<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Layout {
	protected $dev_mode = true;
	
	public function before() {
		parent::before();
		$this->template->title = "Beta Modules";
	}
	
}
