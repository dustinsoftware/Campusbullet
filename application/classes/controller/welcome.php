<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Layout {
	public function before() {
		parent::before();
		$this->template->title = "Welcome!";
	}

	public function action_index()
	{
		$this->template->content = View::factory('welcome')->set('url_base',URL::base());
	}

}
