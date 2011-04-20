<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sexy extends Controller_Layout {

	protected $auth_required = false;
	
	public function before() {
		Request::instance()->redirect('start');
	}
	

	
}
