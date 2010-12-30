<?php defined('SYSPATH') or die('No direct script access.');

include 'is_email.php';

class Controller_Account extends Controller_Layout {

	
	public function action_index() {
		$content = View::factory('account_home');
		$content->url_base = URL::base();
		$this->template->content = $content;
	}
	
	public function action_newpost($starting_category_name = null) {
		
		$content = View::factory('account_newpost');
		$content->url_base = URL::base();
		$content->post_title = "";
		$content->post_price = "";
		$content->post_condition = "";
		$content->post_description = "";
		$content->post_category = "";
		$content->show_form = true;
		$content->editmode = false;
		$content->disabled = false;
		$content->message = "";
		$content->errors = array();
		$content->message_class = "info";
		
		$categories_rows = DB::select('id','name','prettyname')->from('categories')->where('disabled','=','0')->execute()->as_array();
		$content->categories = $categories_rows;
		
		
		if ($starting_category_name) {
			$category_row = DB::select('id')->from('categories')->where('name','=',$starting_category_name)->execute()->current();
			if ($category_row)
				$content->post_category = $category_row['id'];
		}
			
		
		if ($_POST) {
			$title = @(htmlspecialchars($_POST["title"]));
			$condition = @(htmlspecialchars($_POST["condition"]));
			$price = @($_POST["price"]);
			$description = @(htmlspecialchars($_POST["description"]));
			$category = @($_POST["category"]);
			$owner_id = Session::instance()->get('user_id');
			
			$confirmed = @($_POST["confirmed"]);
			$edit = @($_POST["edit"]);
			
			//fill the form with data
			$content->post_title = $title;
			$content->post_price = $price;
			$content->post_condition = $condition;
			$content->post_description = $description;
			$content->post_category = $category;
			
			$errors = $this->validatepost($title, $price, $condition, $description, null, $category);
			
			if ($edit) {
				//do nothing, just show the form.
			}
			elseif ($errors) {
				$content->message_class = "error";
				$content->message = "There was a problem creating the post.";
				$content->errors = $errors;
			} else {
				$content->show_form = false;
				if ($confirmed) {
					//create the post, and report a success						
					DB::insert('posts')
						->columns(array('owner','name','price','condition','description','category'))
						->values(array($owner_id, $title, $price, $condition, $description, $category))->execute();
						
					$content = View::factory('account_newpost_success')->set('url_base',URL::base());
					
				} else {
					$content = $this->previewpost($title,$price,$condition,$description,$category);
					
				}
			}
		}
		
		$this->template->content = $content;
	}
	
	public function action_posts($id = null) {
		$user_id = Session::instance()->get('user_id');
		
		if ($id) {
			$post_row = DB::select('name','price','condition','description','disabled','category')->from('posts')
				->where('owner','=',$user_id)->and_where('id','=',$id)->execute()->current();
			$disabled = $post_row['disabled'];
			
			if ($post_row) {
				$content = View::factory('account_newpost');
				$content->show_form = true;
				$content->message = "";
				$content->url_base = URL::base();
				$content->post_title = $post_row['name'];
				$content->post_condition = $post_row['condition'];
				$content->post_category = $post_row['category'];
				$content->post_price = $post_row['price'];
				$content->post_description = $post_row['description'];
				$content->disabled = $disabled;
				$content->editmode = true;
				$content->errors = array();
				$content->message_class = "info";
				
				$categories_rows = DB::select('id','name','prettyname')->from('categories')->where('disabled','=','0')->execute()->as_array();
				$content->categories = $categories_rows;
		
				
				if ($_POST) {					
					//get the data
					$title = @(htmlspecialchars($_POST["title"]));
					$condition = @(htmlspecialchars($_POST["condition"]));
					$price = @($_POST["price"]);
					$description = @(htmlspecialchars($_POST["description"]));
					$edit = @($_POST["edit"]);
					$confirmed = @($_POST["confirmed"]);
					$disable = @($_POST["disable"]);
					$category = @($_POST["category"]);
					
					if ($disable && ! $edit) {
						//if we're going to disable the post, do a check to see if the user confirmed
						if ($confirmed) {
							//disable the post if teh post has not been banned
							if ($disabled == 0) { //if the post is active
								DB::update('posts')->set(array('disabled' => '1'))->where('id','=',$id)->execute();							
								Request::instance()->redirect('account/posts');
							} else {
								$content->message = "That post is either already active or flagged.";
							}
						} else {
							$content = View::factory('form_confirm');
							$content->form_items = array(
								'title'=>$title,
								'condition'=>$condition,
								'price'=>$price,
								'description'=>$description,
								'disable'=>'yes');
							$content->action = "post_disable";
						}					
					} else {					
						//we're doing a real post, so
						//fill the form with data
						$content->post_title = $title;
						$content->post_price = $price;
						$content->post_condition = $condition;
						$content->post_description = $description;
						$content->post_category = $category;
						
						$errors = $this->validatepost($title,$price,$condition,$description,$id,$category);
						
						if ($edit) {	
							//do nothing, just show the form!
						} elseif ($errors) {
							$content->message_class = "error";
							$content->message = "There was a problem creating the post.";
							$content->errors = $errors;
						} else {
							//the data is good, preview the change (or submit if confirmed)
							if ($confirmed) {							
								if ($disabled == 1)
									DB::update('posts')->set(array('disabled' => 0))->where('id','=',$id)->execute(); //re-enable the post
										
								DB::update('posts')->set(array(
									'name'=>$title,
									'price'=>$price,
									'condition'=>$condition,
									'category'=>$category,
									'description'=>$description))->where('id','=',$id)->execute();
							
								$content->message = "Update submitted!";							
								$content->show_form = false;
							} else {
								$content = $this->previewpost($title,$price,$condition,$description,$category);
							}						
						}
					}
				}
			
				$this->template->content = $content;
			} else {
				Request::instance()->redirect('account/posts');
			}
		} else {
			$content = View::factory('account_posts');
			$user_id = Session::instance()->get('user_id');

			$my_posts = DB::select('id','name','timestamp','disabled')->from('posts')->where('owner','=',$user_id)->order_by('timestamp','DESC')->execute()->as_array();
			
			$content->my_posts = $my_posts;		
			$content->url_base = URL::base();
			$this->template->content = $content;
		}
	}
	
	private function validatepost($title, $price, $condition, $description, $originalpostid, $categoryid) {
		$errors = array();
		
		$category_row = DB::select('id')->from('categories')->where('disabled','=','0')->and_where('id','=',$categoryid)->execute()->current();
		
		if (strlen($title) < 5)
			array_push($errors, "Title too short!  Make it at least 5 characters long.");
			
		if (strlen($title) > 100)
			array_push($errors, "Title too long!  Don't make it longer than 100 characters.");
		
		if (strlen($condition) == 0)
			array_push($errors, "Please enter a condition.");
			
		if (strlen($condition) > 50)
			array_push($errors, "Condition too long!  Make it something short, like 'used' or 'new'.");
		
		if ( ! $category_row)
			array_push($errors, "Please select a category.");
		
		if ( ! is_numeric($price) || $price < 0)
			array_push($errors, "Invalid price.  Please enter a number, without the dollar sign.");
		
		if (strlen($description) < 20)
			array_push($errors, "Description too short.&nbsp; Must be at least 20 characters long.");
		
		if (strlen($description) > 500)
			array_push($errors, "Description too long.&nbsp; Must be under 500 characters.");
					
			
		//check for double post
		$previous_post = DB::select('id')->from('posts')
			->where('name','=',$title)
			->and_where('price','=',$price)
			->and_where('condition','=',$condition)
			->and_where('description','=',$description)
			->and_where('disabled','=','0')
			->and_where('id','!=',$originalpostid)
			->execute()->current();
		
		if ($previous_post)
			array_push($errors, "Double post detected.&nbsp; Double post detected.");
			
		return $errors;
	}
	
	private function previewpost($title,$price,$condition,$description,$category) {
		
		$content = View::factory('account_newpost_preview');
		$content->post_title = $title;
		$content->post_price = $price;
		$content->post_condition = $condition;					
		$content->post_description = $description;
		$content->post_category = $category;
		
		$post_preview = View::factory('home_post_view');
		$post_preview->post_title = $title;
		$post_preview->post_price = "$$price";
		$post_preview->post_condition = $condition;
		$post_preview->post_description = $description;		
		$post_preview->preview = true;
		
		$content->post_preview = $post_preview;
		
		return $content;
	}
	
	public function action_manage() {
		$content = View::factory('account_manage');
		$user_id = Session::instance()->get('user_id');
		$user_row = DB::select('email')->from('users')->where('id','=',$user_id)->execute()->current();
		
		$content->message = "";
		$content->email_address = $user_row['email'];
		
		
		if ($_POST) {
			$change_email = @($_POST['changemail']);
			$disable_account = @($_POST['disable']);
			$acknowledged = @($_POST['acknowledged']);
			$email_address = @($_POST['email']);
			
			if ($disable_account && ! $acknowledged)
				$content->message = "You must check the box to disable your account.";
			
			if ($disable_account && $acknowledged) {			
				//disable all posts related to that user
				DB::update('posts')->set(array(
					'disabled' => 1))->where('owner','=',$user_id)->and_where('disabled','=',0)->execute();
				
				//disable this user
				DB::update('users')->set(array(
					'disabled' => 2))->where('id','=',$user_id)->execute();
				
				//log out the user
				Auth::instance()->logout();
				
				//and redirect to the home page.
				Request::instance()->redirect('home');
			}
			
			if ($change_email) {
				$email_inuse_row = DB::select('id')->from('users')->where('email','=',$email_address)->execute()->current();
				
				
				if (is_email($email_address, false, E_WARNING) > 0)
					$content->message = "Please enter a valid email address.";			
				elseif ($email_inuse_row) {
					$content->message = "That email address is currently held by another user.";
				}
				else {
					//valid email address, send an email
					$verify_row = DB::select('id')->from('verification_keys')->where('id','=',$user_id)->execute()->current();
					
					if ($verify_row) {
						DB::delete('verification_keys')->where('id','=',$user_id)->execute();
					}
					
					$secretkey = sha1(rand(0,1000) . $email_address);
					DB::insert('verification_keys')->columns(array('id','key','email'))->values(array($user_id,$secretkey,$email_address))->execute();
				
							
					$body = View::factory('email_confirm_emailchange')
						->set('key',$secretkey)
						->set('base',URL::base(true,true))
						->set('user', Auth::instance()->get_user());
					
					send_email($email_address, "The MasterList - Email Confirmation", $body);
					
					$content->message = "A verification email has been sent to $email_address.";
				}
			}
		}
		$this->template->content = $content;	
	}
	
	
} 
