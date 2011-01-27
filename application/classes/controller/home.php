<?php defined('SYSPATH') or die('No direct script access.');

include_once 'wordwrap.php';

class Controller_Home extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index()
	{
		//check if the user has seen the what's new page
		if (Auth::instance()->logged_in()) {
			$user_id = Session::instance()->get('user_id');
			$user_row = DB::select('whatsnew')->from('users')->where('id','=',$user_id)->execute()->current();
			if ($user_row['whatsnew'] && ! @($_GET['skip'])) {
				Request::instance()->redirect('whatsnew');
			}
		} 
		
		//if we got this far, render the home page
		array_push($this->template->styles, 'home_index'); //styles for the home page
		$content = View::factory('home');
		$config = Kohana::config('masterlist');
		
		$categories_rows = DB::select('name','prettyname')->from('categories')->where('disabled','=','0')->order_by('sort_order','ASC')->execute()->as_array();
		
		$content->categories = $categories_rows;
		$content->url_base = URL::base();
		
		// get the 5 most recent posts
		$recent_post_rows = DB::select('id','name')->from('posts')->where('disabled','=','0')->and_where('wanted','=','0')->order_by('timestamp','DESC')->limit(5)->execute()->as_array();
		$wanted_post_rows = DB::select('id','name')->from('posts')->where('disabled','=','0')->and_where('wanted','!=','0')->order_by('timestamp','DESC')->limit(5)->execute()->as_array();
		$content->newposts = $recent_post_rows;
		$content->wantedposts = $wanted_post_rows;
		
		$content->version = $config['version'];
		$this->template->content = $content;
	}
	
	public function action_category($category_request) {
		$viewall = ($category_request == "all");
		$content = View::factory('home_category_view');
		
		array_push($this->template->styles, "category_view");
		
		
		//since i can't remember how to do string concatenation without leaving this vulnerable to an sql injection,
		//we'll just get the string name from the categories table
		$category_row = DB::select('id','name','prettyname','description')->from('categories')->where('name','=',$category_request)->and_where('disabled','=',0)->execute()->current();
		
		if ($category_row || $viewall) {				
			if (isset($_GET['wanted']))
				$wanted = 1;
			else
				$wanted = 0;
			
			if ($wanted)
				$content->wanted = true;
			else
				$content->wanted = false;
			
			if ($viewall)
				$current_count = DB::query(Database::SELECT, "select count(id) as count from posts where disabled=0 and wanted = $wanted")->execute()->current();
			else
				$current_count = DB::query(Database::SELECT, "select count(id) as count from posts where disabled=0 and category='$category_row[id]' and wanted = $wanted")->execute()->current();
		
			$current_count = $current_count['count'];
			
			//set up pagination
			$pagination = new Pagination(array(
				'total_items' => $current_count,
				'items_per_page' => 30,			
				));
						
			if ($viewall)
				$current_posts = DB::select('id','name','timestamp','price')->from('posts')->where('disabled','=','0')->and_where('wanted','=',$wanted)->order_by('timestamp','DESC')
					->limit($pagination->items_per_page)->offset($pagination->offset)->execute()->as_array();			
			else
				$current_posts = DB::select('id','name','timestamp','price')->from('posts')->where('category','=',$category_row['id'])->and_where('disabled','=','0')->and_where('wanted','=',$wanted)->order_by('timestamp','DESC')
					->limit($pagination->items_per_page)->offset($pagination->offset)->execute()->as_array();			
				
			$dategroups = array();
			
			foreach($current_posts as $post) {
				$date = date("m-d-Y", strtotime($post['timestamp']));
				if ($post['price'] > 0)
					$post_title = "$post[name] ($$post[price])";
				else
					$post_title = "$post[name] (FREE!)";
					
				//if we have a dategroup, add this to the current one
				if (array_key_exists($date, $dategroups)) {
					array_push($dategroups[$date], array(
						'id' => $post['id'], 
						'title' => $post_title));
				} else {
					$dategroups = $dategroups + array(
						$date => array(
							array(
								'id' => $post['id'], 
								'title' => $post_title)
							)
						);
				}
			}
			
			$content->dategroups = $dategroups;
			$content->category_prettyname = $category_row['prettyname'];
			$content->category_name = $category_request;
			$content->category_description = $category_row['description'];
			$content->postbase = URL::base() . 'home/view/';			
			$content->pagination = $pagination;
			$content->url_base = URL::base();
			
			if ($viewall) {
				$content->category_prettyname = "All Posts";
				$content->category_name = "all";
				$content->category_description = "All the posts on the site can be viewed here, for the lazy.";
			}
			
			
			$this->template->content = $content;
		} else {
			//invalid category, take them home.
			Request::instance()->redirect('home');
		}
	}
	
	public function action_view($id) {
		array_push($this->template->styles, "post_view");
		$content = View::factory('home_post_view');
		
		$user_id = Session::instance()->get('user_id');
		$base = URL::base(false,true);
		
		$post = DB::select('*')->from('posts')->where('id','=',$id)->execute()->current();
			
		if ($post) {
			if ($post['disabled'] != 0 && $post['owner'] != $user_id) {
				if ( ! $user_id)
					Request::instance()->redirect("login?redir=home/view/$id");
				else
					Request::instance()->redirect('home');
			}
			$category_row = DB::select('name')->from('categories')->where('id','=',$post['category'])->execute()->current();
			if (@($_GET['postcreated'])) {
				$content->postcreated = true;
			} else
				$content->postcreated = false;
			
			//set up stuff for the facebook share button
			$this->template->fb_title = $post['name'];
			$this->template->fb_description = $post['description'];
			if ($post['image']) {				
				$this->template->fb_image = URL::base(false,true) . "images/posts/$post[id].jpg";
				$this->template->fb_postid = $post['id'];
			} elseif ($post['isbn']) {
				$this->template->fb_image = "http://covers.openlibrary.org/b/isbn/" . $post['isbn'] . "-L.jpg";
			} else {			
				$this->template->fb_image = null;
			}
			$this->template->post_wanted = $post['wanted'];
			
			if ($post['owner'] == $user_id) {			
				$content->is_owner = true;
			} else {
				$content->is_owner = false;
			}
			$content->is_moderator = Session::instance()->get('moderator');
			$content->poster_id = $post['owner'];
			$content->preview = false;
			$content->post_disabled = $post['disabled'];
			$content->post_title = $post['name'];
			$content->wanted = $post['wanted'];
			$post_price = $post['price'];
			if ($post_price == 0)
				$content->post_price = "Free!";
			else
				$content->post_price = "$$post_price";
			
			$content->post_description = dpmwordwrap($post['description']);			
			$content->post_category_name = $category_row['name'];
			$content->post_condition = $post['condition'];
			$content->post_isbn = $post['isbn'];
			$content->url_base = $base;
			$content->post_id = $id;
			$content->post_date = date("M d, Y",strtotime($post['timestamp']));
			
			if ($post['image'])
				$content->post_image = $base . "images/posts/$id.jpg";
			elseif ($post['isbn'])
				$content->post_image = "http://covers.openlibrary.org/b/isbn/" . $post['isbn'] . "-L.jpg";
			else
				$content->post_image = "";
						
			$this->template->content = $content; 
		} else {
			Request::instance()->redirect('home');
		}
	}

}
