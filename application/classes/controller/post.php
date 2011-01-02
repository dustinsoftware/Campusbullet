<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Layout {

	public function action_index() {
		Request::instance()->redirect('home');
	}
		
	public function action_new($starting_category_name = null) {
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
		$content->post_isbn = "";
		$content->show_form = true;
		$content->editmode = false;
		$content->disabled = false;
		$content->message = "";
		$content->errors = array();
		$content->message_class = "info";
		$content->file_uploaded = false;
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
			
			$errors = $this->validatepost(array(
				'title' => $title, 
				'price' => $price,
				'condition' => $condition,
				'description' => $description, 
				'category' => $category, 
				'isbn' => $isbn,));
			
			
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
						->columns(array('owner','name','price','condition','description','category','isbn'))
						->values(array($owner_id, $title, $price, $condition, $description, $category,$isbn))->execute();
						
					//now that we've crated the post, get the new id and redirect to the image upload page
					$post_row = DB::select('id')->from('posts')->where('owner','=',$owner_id)->order_by('timestamp','DESC')->execute()->current();
					
					Request::instance()->redirect("image/post/$post_row[id]?postcreated=true");
					
				} else {
					$content = $this->previewpost(array(
						'title' => $title, 
						'price' => $price,
						'condition' => $condition,
						'category' => $category,
						'description' => $description, 
						'isbn' => $isbn));
					
				}
			}
		}
		
		$this->template->content = $content;
	}
	
	public function action_edit($id = null) {
		$user_id = Session::instance()->get('user_id');
		
		if ($id) {
			$post_row = DB::select('name','price','condition','description','disabled','category','isbn')->from('posts')
				->where('owner','=',$user_id)->and_where('id','=',$id)->execute()->current();
			$disabled = $post_row['disabled'];
			
			if ($post_row) {
				$content = View::factory('post_new');
				$content->show_form = true;
				$content->message = "";
				$content->url_base = URL::base();
				$content->post_title = $post_row['name'];
				$content->post_condition = $post_row['condition'];
				$content->post_category = $post_row['category'];
				$content->post_price = $post_row['price'];
				$content->post_description = $post_row['description'];
				$content->post_isbn = $post_row['isbn'];
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
					if ($category == 2) {
						$isbn = @(htmlspecialchars($_POST["isbn"]));
					} else {
						$isbn = null;
					}
					
					
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
							$content->form_items = array('disable' => 'yes');								
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
							'category' => $category));
						
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
									'isbn'=>$isbn,
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
									'isbn' => $isbn));
							}						
						}
					}
				}
			
				$this->template->content = $content;
			} else {
				Request::instance()->redirect('account/posts');
			}
		} else {
			$content = View::factory('post_list');
			$user_id = Session::instance()->get('user_id');

			$my_posts = DB::select('id','name','timestamp','disabled')->from('posts')->where('owner','=',$user_id)->order_by('timestamp','DESC')->execute()->as_array();
			
			$content->my_posts = $my_posts;		
			$content->url_base = URL::base();
			$this->template->content = $content;
		}
	}
	
	private function validatepost($fields) {	
		$errors = array();
		
		$category_row = DB::select('id')->from('categories')->where('disabled','=','0')->and_where('id','=',$fields['category'])->execute()->current();
		
		if (strlen($fields['title']) < 5)
			$errors += array("title" => "Title too short!  Make it at least 5 characters long.");
			
		if (strlen($fields['title']) > 100)
			$errors += array("title" => "Title too long!  Don't make it longer than 100 characters.");
		
		if (strlen($fields['condition']) == 0)
			$errors += array("condition" => "Please enter a condition.");
			
		if (strlen($fields['condition']) > 50)
			$errors += array("condition" => "Condition too long!  Make it something short, like 'used' or 'new'.");
		
		if ( ! $category_row)
			$errors += array("category" => "Please select a category.");
		
		if ( ! is_numeric($fields['price']) || $fields['price'] < 0)
			$errors += array("price" => "Invalid price.  Please enter a number, without the dollar sign.");
		
		if (strlen($fields['description']) < 20)
			$errors += array("description" => "Description too short.&nbsp; Must be at least 20 characters long.");
		
		if (strlen($fields['description']) > 500)
			$errors += array("description" => "Description too long.&nbsp; Must be under 500 characters.");
					
		//check extra fields		
		try {
			if ($fields['category'] == 2) {
				//if this is a book
				if ((strlen($fields['isbn']) != 10 && strlen($fields['isbn']) != 13) || ! is_numeric($fields['isbn'])) {
					$errors += array("isbn" => "Invalid 10 or 13-digit ISBN.  Please make sure you enter the ISBN without the dashes.");
				}				
			}
			
		} catch (Exception $e) {
			$errors += array("fields" => "Extra information missing.  " . $e->getMessage());
		}	
			
		//check for double post
		$originalpostid = @($fields['originalpostid']);
		$previous_post = DB::select('id')->from('posts')
			->where('name','=',$fields['title'])
			->and_where('price','=',$fields['price'])
			->and_where('condition','=',$fields['condition'])
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
		
		$category_row = DB::select('name')->from('categories')->where('id','=',$fields['category'])->execute()->current();
		
		$content = View::factory('post_preview');
		$content->post_title = $fields['title'];
		$content->post_price = $fields['price'];
		$content->post_condition = $fields['condition'];					
		$content->post_description = $fields['description'];
		$content->post_category = $fields['category'];
		$content->post_isbn = $fields['isbn'];
				
		$post_preview = View::factory('home_post_view');
		$post_preview->post_title = $fields['title'];
		$post_preview->post_price = "$$fields[price]";
		$post_preview->post_condition = $fields['condition'];
		$post_preview->post_isbn = $fields['isbn'];
		$post_preview->post_description = $fields['description'];		
		$post_preview->preview = true;
		$post_preview->url_base = URL::base();
		$post_preview->post_category_name = $category_row['name'];
		$post_preview->post_image = "";
		
		$content->post_preview = $post_preview;
		
		return $content;
	}
	
}
