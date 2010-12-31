<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * DB Auth driver.
 * [!!] this Auth driver does not support roles nor autologin.
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Auth_Db extends Auth {

	/**
	 * Constructor loads the user list into the class.
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

	}

	/**
	 * Logs a user in.
	 *
	 * @param   string   username
	 * @param   string   password
	 * @param   boolean  enable autologin (not supported)
	 * @return  boolean
	 */
	protected function _login($username, $password, $remember)
	{		
		//check the user database for the user
		$user_row = DB::select('id','disabled')->from('users')->where('username','=',$username)->and_where('userhash','=',$password)->execute()->current();
		
		if ($user_row) {
			if ($user_row['disabled'] == 1) {
				//the user has been disabled by a mod. deny the login.	
				return false;
			} else {
				//the user is clear to log in
				
				if ($user_row['disabled'] == 2) {
					//the user disabled themself. re-enable them.
					DB::update('users')->set(array(
						'disabled' => 0))->where('id','=',$user_row['id'])->execute();
				}
				
				$this->_session->set("user_id", $user_row['id']);
				return $this->complete_login($username);
			}
		}
		
		return false; //login failed!
		
	}

	/**
	 * Forces a user to be logged in, without specifying a password.
	 *
	 * @param   mixed    username
	 * @return  boolean
	 */
	public function force_login($username)
	{
		// Complete the login
		return $this->complete_login($username);
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   username
	 * @return  string
	 */
	public function password($username)
	{			
		//return Arr::get($this->_users, $username, FALSE);
		return false; // not supported!
	}

	/**
	 * Compare password with original (plain text). Works for current (logged in) user
	 *
	 * @param   string  $password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		return false; // not supported!
		
		$username = $this->get_user();

		if ($username === FALSE)
		{
			return FALSE;
		}

		return ($password === $this->password($username));
	}

} // End Auth File