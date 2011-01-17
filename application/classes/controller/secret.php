<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Secret extends Controller_Layout {
	
	protected $dev_mode = true;
	
	public function action_index() {
		if (Session::instance()->get('secret_found')) {
		
		} else {
			$this->template = View::factory('secret_denied');
		}
	}
	
	public function action_rabbit() {
		$this->template->content = " U R SPECIAL";
	}
}
