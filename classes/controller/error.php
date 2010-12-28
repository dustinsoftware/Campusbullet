<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index($err = null)
	{
		$this->template->content = "Sorry, an error occurred.&nbsp; Please try again or report the error!";
	}	

}
