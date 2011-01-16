<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index()
	{
		$auth = Auth::instance();
		$content = View::factory('notemplate_login');
		$content->error = "";
		$post_user = @($_POST['user']);
		$post_pass = @($_POST['asdf']);
		$failures_row = DB::select('timestamp','failures')->from('login_failures')->where('ip','=',$_SERVER["REMOTE_ADDR"])->execute()->current();
		
		//dirty hack for getting the current page we're on
		//currently caused by the redirect to /index.php/ bug, which appears directly after you log out.
		//the fix is to see if index.php is present in the address
		if ( ! isset($_GET['redir']) && @($_SERVER['HTTP_REFERER'])) {
			$sitebase = URL::base(true,true);
			$sitebase = explode("index.php", $sitebase); $sitebase = $sitebase[0];
			$thispage = explode($sitebase, $_SERVER['HTTP_REFERER']); $thispage = $thispage[1];
			$thispage = explode("index.php", $thispage);
			if (count($thispage) == 2) //if index.php is present, take it out
				$thispage = $thispage[1];
			else
				$thispage = $thispage[0];
			
			$redir = urlencode($thispage);
			Request::instance()->redirect("login?redir=$redir");
		}
		
		if (@($_GET['redir'])) {
			$redir = @($_GET['redir']);
		} else
			$redir = "home";
		
		//check if the user is already logged in
		if ($auth->logged_in())
			Request::instance()->redirect($redir);
		
		//check for an automated login bot - buggy, disabled for now
		/*if ($failures_row && $_POST && $failures_row['failures'] > 10) {
			$now = time() + (9 * 60 * 60); //fix for weird time bug
			$lastfail = strtotime($failures_row['timestamp']);
			//$reconvert = date("Y-m-d H:i:s",$now);			
			if ($now - $lastfail < 5) {
				$content->error = "Sorry, you need to wait a couple seconds before you can try logging in again.";				
			}
			
		
		}*/
		
		//check credentials and redirect if successful
		if ($post_user && $post_pass && ! $content->error) {
			$result = $auth->login($post_user, $post_pass);
			if ($result == "success") {
				Request::instance()->redirect($redir);
			} else {				
				if ($result == "disabled") {
					$log_row = DB::select('key')->from('logs')->where('regarding_user','=',$post_user)
						->and_where('log_type','=','user_disabled')->order_by('timestamp','DESC')->execute()->current();
					if ($log_row)
						$content->error = "Aw, bummer!&nbsp; Your account has been disabled.<br />Please read <a href=\"" . URL::base() . "log/userdisabled/$log_row[key]\">this report</a> for more information.";
					else
						$content->error = "Aw, bummer!&nbsp; Your account has been disabled.<br />Please read <a href=\"" . URL::base() . "log/userdisabled/\">this help document</a> for more information.";
				}		
					
				else
					$content->error = "Sorry, that username and password didn't work.<br />If you forgot your password, <a href=\"" . URL::base() . "register/forgotpassword\">click here to reset it</a>.";
					
				if ($failures_row) {
					DB::update('login_failures')->set(array(
						'failures' => $failures_row['failures'] + 1))
						->where('ip','=',$_SERVER["REMOTE_ADDR"])->execute();					
				} else {
					DB::insert('login_failures')->columns(array('ip','failures'))->values(array($_SERVER["REMOTE_ADDR"],1))->execute();
				}
			}
		}
		
		$this->template = $content;
	}
	
	public function action_logout() {
		$redir = 'home';
		$auth = Auth::instance();
		
		if ($auth->logged_in())
			$auth->logout(true);
			
		Request::instance()->redirect($redir);			
	}

}
