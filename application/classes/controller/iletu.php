<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Iletu extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index() {
		$content = View::factory('iletu_home');
		$content->codes = DB::select('key')->from('iletu')->where('email','=',null)->execute()->current();
		
		$this->template->content = $content;
	}
	
	public function action_generate() {
		if (Auth::instance()->logged_in() == false) {
			Request::instance()->redirect('login?redir=iletu/generate');
		} else {
			$content = View::factory('iletu_generate');
			$user_id = Session::instance()->get('user_id');
			$user_row = DB::select('*')->from('users')->where('id','=',$user_id)->execute()->current();
			
			$foremail = @($_GET['for']);
			if ($foremail && $user_row['role'] == "admin") {
				$user_row = array('originalemail' => $foremail);
			}
			
			$code_row = DB::select('key')->from('iletu')->where('email','=',$user_row['originalemail'])->execute()->current();
			
			if ($code_row) {
				$content->code = $code_row['key'];
			} else {
				//they haven't requested a code, generate a new one or report there are none left.
				$code_row = DB::select('key')->from('iletu')->where('email','=',null)->execute()->current();
				if ($code_row) {
					//mark the code as claimed
					DB::update('iletu')->set(array('email' => $user_row['originalemail']))->where('key','=',$code_row['key'])->execute();
					$content->code = $code_row['key'];
					send_email($user_row['originalemail'], "Your iLETU Code", $content);
				}
				
				$content->code = $code_row['key'];
			}
			
			
			$this->template->content = $content;
		}
	}
}