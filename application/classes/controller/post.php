<?php defined('SYSPATH') or die('No direct script access.');

include_once 'wordwrap.php';

class Controller_Post extends Controller_Layout {
	public function before() {
		parent::before();
		$this->template->title = "Post Editor";
	}

	public function action_index() {
		Request::instance()->redirect('home');
	}
		
	public function action_new($starting_category_name = null) {
		array_push($this->template->styles, 'post_new');
		$this->template->title = "New Post";
		
		if (isset($_GET['wanted'])) {
			$wanted = true;			
		} else {
			$wanted = false;
		}
		$user_id = Session::instance()->get('user_id');		
		$config = Kohana::config('masterlist');
		$masterlist_root = $config['root'];
		
		$content = View::factory('post_new');
		$content->url_base = URL::base();
		$content->post_title = "";
		$content->post_price = "";
		$content->post_condition = "";
		$content->post_description = "";
		$content->post_category = "";
		$content->post_category_name = "";
		$content->post_isbn = "";
		$content->wanted = $wanted;
		$content->allow_repost = false;
		$content->editmode = false;
		$content->disabled = false;
		$content->message = "";
		$content->errors = array();
		$content->file_uploaded = false;
		$categories_rows = DB::select('id','name','prettyname')->from('categories')->where('disabled','=','0')->execute()->as_array();
		$content->categories = $categories_rows;
		
		
		if ($starting_category_name) {
			$category_row = DB::select('id','name')->from('categories')->where('name','=',$starting_category_name)->execute()->current();
			if ($category_row) {			
				$content->post_category = $category_row['id'];
				$content->post_category_name = $category_row['name'];
			}
		}
		
		if ($_POST) {
			$title = @(htmlspecialchars($_POST["title"]));
			$description = @(htmlspecialchars($_POST["description"]));
			$category = @($_POST["category"]);
			if($wanted) {
				$condition = "";
				$price = 0;				
			} else {
				$condition = @(htmlspecialchars($_POST["condition"]));
				$price = @($_POST["price"]);							
			}
			$owner_id = Session::instance()->get('user_id');
			if ($category == 2) //only fill in the isbn if we need it
				$isbn = @(htmlspecialchars($_POST["isbn"]));
			else
				$isbn = null;
				
			$confirmed = @($_POST["confirmed"]);
			$edit = @($_POST["edit"]);
			
			//fill the form with data
			$content->post_title = $title;
			$content->post_price = $price;
			$content->post_condition = $condition;
			$content->post_description = $description;
			$content->post_category = $category;
			$content->post_isbn = $isbn;
			$content->wanted = $wanted;
			
			$errors = $this->validatepost(array(
				'title' => $title, 
				'price' => $price,
				'condition' => $condition,
				'description' => $description, 
				'category' => $category, 
				'isbn' => $isbn,				
				'wanted' => $wanted,
			));
		
			if ($edit) {
				//do nothing, just show the form.
			}
			elseif ($errors) {
				$content->errors = $errors;
			} else {				
				$content->show_form = false;
				if ($confirmed) {
					//create the post, and report a success				
					DB::insert('posts')
						->columns(array('owner','name','price','condition','description','category','isbn','wanted'))
						->values(array($owner_id, $title, $price, $condition, $description, $category,$isbn,$wanted))->execute();						
					
					//now that we've crated the post, get the new id and redirect to the image upload page
					$post_row = DB::select('id')->from('posts')->where('owner','=',$owner_id)->order_by('timestamp','DESC')->execute()->current();
					
					Request::instance()->redirect("image/bookcover/$post_row[id]?newpost");
					
				} else {
					$content = $this->previewpost(array(
						'title' => $title, 
						'price' => $price,
						'condition' => $condition,
						'category' => $category,
						'description' => $description, 
						'isbn' => $isbn,
						'wanted' => $wanted,
						'image' => 0));
					
				}
			}
		}
		
		$this->template->content = $content;
	}
	
	public function action_edit($id = null) {
		$user_id = Session::instance()->get('user_id');
		$moderator = Session::instance()->get('moderator');
		
		if ($id) {
			array_push($this->template->styles, 'post_new');
			
			$post_row = DB::select('id','owner','name','price','condition','description','disabled','category','isbn','timestamp','image','wanted','image')->from('posts')
					->where('id','=',$id)->and_where('disabled','!=','4')->execute()->current();
			
			if ($moderator) {
				$permission_to_edit = true;
			} else {			
				$permission_to_edit = $post_row['owner'] == $user_id;
			}
			
			if ($post_row && $permission_to_edit) {
				$disabled = $post_row['disabled'];
				$wanted = $post_row['wanted'];
				$content = View::factory('post_new');
				$content->message = "";
				$content->url_base = URL::base();
				$content->post_title = $post_row['name'];
				$content->post_condition = $post_row['condition'];
				$content->post_category = $post_row['category'];
				$content->post_id = $post_row['id'];
				$content->wanted = $wanted;
				$content->post_price = $post_row['price'];
				$content->post_description = $post_row['description'];
				$content->post_isbn = $post_row['isbn'];
				$content->disabled = $disabled;
				$content->editmode = true;
				$content->errors = array();				
				
				//check if there is an attached image
				if ($post_row['image'])
					$content->image_attached = true;
				else
					$content->image_attached = false;
					
				//check if the post can be bumped
				if (Date::span(strtotime($post_row['timestamp']),null,'days') >= 7 && $disabled == 0) {
					$content->allow_repost = true;
					$content->message = "Your post can be reposted to the top!&nbsp; Use the fancy button below the description to do so.";
				} else
					$content->allow_repost = false;

				if ($disabled == 2) {
					Request::instance()->redirect("home/view/$id");
				} 
				
				
				$categories_rows = DB::select('id','name','prettyname')->from('categories')->where('disabled','=','0')->execute()->as_array();
				$content->categories = $categories_rows;
				
				
				if ($_POST) {					
					//get the data
					$title = @(htmlspecialchars($_POST["title"]));
					if ($wanted) {
						$condition = "";
						$price = 0;						
					} else {
						$condition = @(htmlspecialchars($_POST["condition"]));
						$price = @($_POST["price"]);						
					}
					$description = @(htmlspecialchars($_POST["description"]));
					$edit = @($_POST["edit"]);
					$confirmed = @($_POST["confirmed"]);
					$disable = @($_POST["disable"]);
					$repost = @($_POST["repost"]);
					
					$category = @($_POST["category"]);
					if ($category == 2) {
						$isbn = @(htmlspecialchars($_POST["isbn"]));
					} else {
						$isbn = null;
					}
					
					if ($repost) {
						if ($content->allow_repost) {
							DB::update('posts')->set(array(
								'timestamp' => Date::formatted_time(), 
								'warningsent' => 0))->where('id','=',$id)->execute(); //re-set the warning stamp
							
							$content->message = "Your post has been bumped to the top!";
							$content->allow_repost = false;
						} else {
							$content->message = "You can't repost to the top for that post again.&nbsp; Try again later.";
						}
						
					} elseif ($disable) {						
						//if we're going to disable the post, do a check to see if the user confirmed
						if ($confirmed) {
							//disable the post if teh post has not been banned
							if ($disabled == 0) { //if the post is active
								DB::update('posts')->set(array('disabled' => '1'))->where('id','=',$id)->execute();							
								Request::instance()->redirect('post/edit');
							} else {
								$content->message = "That post is either already active or flagged.";
							}
						} else {
							$content = View::factory('form_confirm');
							$content->form_items = array(
								'disable' => 'yes');								
							$content->goback = URL::base() . "post/edit/$id";
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
						$content->post_isbn = $isbn;
						
						$errors = $this->validatepost(array(
							'title' => $title,
							'price' => $price,
							'condition' => $condition,
							'description' => $description,
							'originalpostid' => $id,	
							'isbn' => $isbn,
							'category' => $category,
							'wanted' => $wanted,
						));
						
						if ($edit) {	
							//do nothing, just show the form!
						} elseif ($errors) {
							$content->errors = $errors;
						} else {
							//the data is good, preview the change (or submit if confirmed)
							if ($confirmed) {		
								//change the post status to active
								DB::update('posts')->set(array('disabled' => 0))->where('id','=',$id)->execute(); //re-enable the post									
								
								//update the timestamp to the current day if the post is old enough
								if (Date::span(strtotime($post_row['timestamp']),null,'days') >= 7) {
									DB::update('posts')->set(array(
										'timestamp' => Date::formatted_time(), 
										'warningsent' => 0))->where('id','=',$id)->execute(); //re-set the warning stamp
								}
								
								DB::update('posts')->set(array(
									'name'=>$title,
									'price'=>$price,
									'condition'=>$condition,
									'category'=>$category,
									'isbn'=>$isbn,
									'wanted'=>$wanted,
									'description'=>$description))->where('id','=',$id)->execute();
							
								Request::instance()->redirect("home/view/$id");
								$content->show_form = false;
							} else {
								$content = $this->previewpost(array(
									'title' => $title,
									'price' =>$price,
									'condition' => $condition,
									'description' => $description,
									'category' => $category,
									'isbn' => $isbn,
									'wanted' => $wanted,
									'image' => $post_row['image'],
									'id' => $post_row['id']));
							}						
						}
					}
				}
			
				$this->template->content = $content;
			} else {
				Request::instance()->redirect('post/edit');
			}
		} else {
			array_push($this->template->styles, "post_list");
			$content = View::factory('post_list');
			$content->post_status_codes = $this->post_status_codes;
			$user_id = Session::instance()->get('user_id');

			$my_posts = DB::select('id','name','timestamp','disabled')->from('posts')->where('owner','=',$user_id)->and_where('disabled','!=','4')
				->order_by('timestamp','DESC')->order_by('id','DESC')->execute()->as_array();
			
			$content->my_posts = $my_posts;		
			$content->url_base = URL::base();
			$this->template->content = $content;
		}
	}
	
	public function action_disable($id) {
		$user_id = Session::instance()->get('user_id');
		$post_row = DB::select('id')->from('posts')
			->where('id','=',$id)
			->and_where('owner','=',$user_id)
			->and_where('disabled','=','0')
			->execute()->current();
		
		if ($post_row) {
			$confirmed = @($_POST['confirmed']);
			if ($confirmed) {
				//disable the post if teh post has not been banned			
				DB::update('posts')->set(array('disabled' => '1'))
					->where('id','=',$id)
					->and_where('disabled','=','0')
					->and_where('owner','=',$user_id)->execute();							
				Request::instance()->redirect('post/edit');				
			} else {
				$content = View::factory('form_confirm');
				$content->form_items = array(
					'disable' => 'yes');								
				$content->goback = URL::base() . "home/view/$id";
				$content->action = "post_disable";
				$this->template->content = $content;
			}					
		} else {
			Request::instance()->redirect('post/edit');
		}		
	}
	
	public function action_delete($id) {
		$user_id = Session::instance()->get('user_id');
		$post_row = DB::select('id')->from('posts')
			->where('id','=',$id)
			->and_where('owner','=',$user_id)
			->and_where('disabled','!=','4')
			->execute()->current();
		
		if ($post_row) {
			$confirmed = @($_POST['confirmed']);
			
			if ($confirmed) {
				DB::update('posts')->set(array('disabled' => '4'))
					->where('id','=',$id)
					->and_where('owner','=',$user_id)->execute();		
				Request::instance()->redirect('post/edit?postdeleted');				
			} else {
				$content = View::factory('form_confirm');
				$content->form_items = array(
					'disable' => 'yes');	
				$content->goback = URL::base() . "home/view/$id";
				$content->action = "post_delete";
				$this->template->content = $content;
			}
		} else {
			Request::instance()->redirect('post/edit');	
		}
		
		
	}
	
	private function validatepost($fields) {	
		$errors = array();
		$wanted = @($fields['wanted']);
		
		$category_row = DB::select('id')->from('categories')->where('disabled','=','0')->and_where('id','=',$fields['category'])->execute()->current();
		
		if (strlen($fields['title']) < 5)
			$errors += array("title" => "Title too short!  Make it at least 5 characters long.");
			
		if (strlen($fields['title']) > 100)
			$errors += array("title" => "Title too long!  Don't make it longer than 100 characters.");

		if ( ! $category_row)
			$errors += array("category" => "Please select a category.");
		
		//wanted posts only contain the title, category, and description
		if ( ! $wanted) {
		
			if (strlen($fields['condition']) == 0)
				$errors += array("condition" => "Please enter a condition.");
				
			if (strlen($fields['condition']) > 50)
				$errors += array("condition" => "Condition too long!  Make it something short, like 'used' or 'new'.");
		
			if ( ! is_numeric($fields['price']) || $fields['price'] < 0)
				$errors += array("price" => "Invalid price.  Please enter a number, without the dollar sign.");
		
		}
		
		
		
		if (strlen($fields['description']) == 0)
			$errors += array("description" => "Type something in the description box.");
		
		if (strlen($fields['description']) > 1000)
			$errors += array("description" => "Description too long.&nbsp; Must be under 1000 characters.");
					
		//check extra fields		
		try {
			if (strcmp($fields['isbn'],"") != 0 && ((strlen($fields['isbn']) != 10 && strlen($fields['isbn']) != 13) || ! is_numeric($fields['isbn']))) {
				$errors += array("isbn" => "Invalid 10 or 13-digit ISBN.  Please make sure you enter the ISBN without the dashes.");
			}				
			
		} catch (Exception $e) {
			$errors += array("fields" => "Extra information missing.  " . $e->getMessage());
		}	
			
		//check for double post
		$originalpostid = @($fields['originalpostid']);
		$previous_post = DB::select('id')->from('posts')
			->where('name','=',$fields['title'])			
			->and_where('description','=',$fields['description'])
			->and_where('disabled','=','0')
			->and_where('id','!=',$originalpostid)
			->execute()->current();
		
		if ($previous_post) {		
			$errors += array("doublepost" => "Double post detected.&nbsp; Double post detected.");
		}	
		
		return $errors;
	}
	
	private function previewpost($fields) {
		
		$category_row = DB::select('name','prettyname')->from('categories')->where('id','=',$fields['category'])->execute()->current();
		
		$content = View::factory('post_preview');
		$content->post_title = $fields['title'];
		$content->post_price = $fields['price'];
		$content->post_condition = $fields['condition'];					
		$content->post_description = $fields['description'];
		$content->post_category = $fields['category'];
		$content->post_isbn = $fields['isbn'];
		$content->post_wanted = $fields['wanted'];
			
		$post_preview = View::factory('home_post_view');
		$post_preview->post_title = $fields['title'];
		$post_preview->post_price = "$$fields[price]";
		$post_preview->post_condition = $fields['condition'];
		$post_preview->post_isbn = $fields['isbn'];
		$post_preview->post_wanted = $fields['wanted'];
		$post_preview->post_description = dpmwordwrap($fields['description']);
		$post_preview->preview = true;
		$post_preview->wanted = $fields['wanted'];
		$post_preview->url_base = URL::base();
		$post_preview->post_category_name = $category_row['name'];
		$post_preview->post_category_prettyname = $category_row['prettyname'];
		
		$post_preview->post_images = array();
			for ($i = 1; $i <= $fields['image']; $i++) {
				array_push($post_preview->post_images, URL::base() . "images/posts/" . $fields['id'] . "-$i.jpg");
			}
		$post_preview->post_disabled = 0;
		$post_preview->post_date = "";
		$post_preview->postcreated = "";
		
		$content->post_preview = $post_preview;
		
		return $content;
	}
	
	
	
}
