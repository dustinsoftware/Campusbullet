<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Layout {

	public function action_index() {
		Request::instance()->redirect('home');
	}
	
}
