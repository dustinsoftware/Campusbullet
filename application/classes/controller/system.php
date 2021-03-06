<?php defined('SYSPATH') or die('No direct script access.');

include_once 'system_email.php';
class Controller_System extends Controller {

	public function before() {
		parent::before();
		if ($_SERVER["REMOTE_ADDR"] != "127.0.0.1") {
			die("Access denied." . $_SERVER["REMOTE_ADDR"]);
		}		
	}	
	
	public function action_cron() {
		try {				
			//check for rows that need to be expired
			$warning_rows = DB::query(Database::SELECT, "select posts.wanted,posts.id,posts.name,users.email,users.username from posts join users on posts.owner = users.id where posts.timestamp < date_sub(current_date, interval 27 day) and posts.disabled=0 and posts.warningsent = 0")
				->execute()->as_array();
			
			//send the warning emails
			foreach ($warning_rows as $row) {
				$expired_email = View::factory('email_expire_warning');
				DB::update('posts')->set(array('warningsent' => 1))->where('id','=',$row['id'])->execute();
				$expired_email->post_title = $row['name'];
				$expired_email->post_username = $row['username'];
				$expired_email->wanted = $row['wanted'];
				$expired_email->link_post = URL::base(false,true) . "home/view/$row[id]";
				$expired_email->link_repost = URL::base(false,true) . "post/edit/$row[id]";
				$expired_email->link_disable = URL::base(false,true) . "post/disable/$row[id]";
				try {				
					//$to_email, $subject, $body, $reply_to = null
					send_email($row['email'],"The Campus Bullet - Your Post Will Expire in 3 Days!", $expired_email);
				} catch (Exception $e) { }
			}
			
			//and...expire the posts that have past their expiration date. users will have to re-activate them.  
			$expired_rows = DB::query(Database::SELECT, "select posts.id,posts.name,users.email,users.username from posts join users on posts.owner = users.id where posts.timestamp < date_sub(current_date, interval 30 day) and posts.disabled=0")
				->execute()->as_array();
			
			//send the expired emails
			foreach ($expired_rows as $row) {
				$expired_email = View::factory('email_expire_wetoldyou');
				DB::update('posts')->set(array('warningsent' => 0, 'disabled' => 3))->where('id','=',$row['id'])->execute();				
				$expired_email->post_title = $row['name'];
				$expired_email->link_post = URL::base(false,true) . "home/view/$row[id]";
				$expired_email->link_repost = URL::base(false,true) . "post/edit/$row[id]";				
				try {				
					//$to_email, $subject, $body, $reply_to = null
					send_email($row['email'],"The Campus Bullet - Your Post Has Expired.", $expired_email);
				} catch (Exception $e) { }
			}
			
			//also, expire disabled posts older than a month
			DB::query(Database::UPDATE, "update posts set disabled=3, warningsent=0 where timestamp < date_sub(current_date, interval 30 day) and disabled = 1")
					->execute();			
			
			$this->request->response = "OK";
		} catch (Exception $e) {
			$this->request->response = "<pre>FAIL: \r\n" . print_r($e,true);
		}
		
		
	}	
	
	
}
