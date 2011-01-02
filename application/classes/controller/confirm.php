<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Confirm extends Controller_Layout {
	protected $auth_required = false;
	
	public function action_index()
	{
		Request::instance()->redirect('home');
	}
	
	public function action_emailchange($verifykey) {
		$verify_row = DB::select('id','email')->from('verification_keys')->where('key','=',$verifykey)->execute()->current();
		
		if ($verify_row) {
			DB::update('users')->set(array(
				'email' => $verify_row['email']))->where('id','=',$verify_row['id'])->execute();
				
			DB::delete('verification_keys')->where('id','=',$verify_row['id'])->execute();
			
			Request::instance()->redirect('account?confirmed');
		} else {
			Request::instance()->redirect('home');
		}
		
	}
	
	public function action_register($verifykey) {
		
		$verify_row = DB::select('email')->from('registration_keys')->where('key','=',$verifykey)->execute()->current();
		if ($verify_row) {
			Session::instance()->set('verifiedemail',$verify_row['email']);
			Request::instance()->redirect('register/emailconfirmed');
		}
		
		Request::instance()->redirect('home');
	}
	
	public function action_resetpassword($verifykey) {
		$verify_row = DB::select('email')->from('verification_keys')->where('key','=',$verifykey)->execute()->current();
		
		if ($verify_row) {
			Session::instance()->set('forgotpw_email',$verify_row['email']);
			Request::instance()->redirect('register/forgotpassword');
		}
		Request::instance()->redirect('home');
	}

}
