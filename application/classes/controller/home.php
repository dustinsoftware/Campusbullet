<?php defined('SYSPATH') or die('No direct script access.');

include_once 'wordwrap.php';

class Controller_Home extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index()
	{		
		//if we got this far, render the home page
		array_push($this->template->styles, 'home_index'); //styles for the home page
		$content = View::factory('home');
		$config = Kohana::config('masterlist');
		
		$categories_rows = DB::select('name','prettyname')->from('categories')->where('disabled','=','0')->order_by('sort_order','ASC')->execute()->as_array();
		
		$temp_category_rows = array(array(
			'name' => 'askkyle',
			'prettyname' => 'Ask Kyle'));
		$temp_category_rows = array_merge($temp_category_rows, $categories_rows);
		$content->categories = $temp_category_rows;
		$content->url_base = URL::base();
		
		// get the 5 most recent posts
		$recent_post_rows = DB::select('id','name','price')->from('posts')->where('disabled','=','0')->and_where('wanted','=','0')->order_by('timestamp','DESC')->limit(5)->execute()->as_array();
		$wanted_post_rows = DB::select('id','name')->from('posts')->where('disabled','=','0')->and_where('wanted','!=','0')->order_by('timestamp','DESC')->limit(5)->execute()->as_array();
		$content->newposts = $recent_post_rows;
		$content->wantedposts = $wanted_post_rows;
		
		$feed_link = URL::base(false,true) . "home/category/all?feed";
			
		$this->template->feed = array(
			'title' => "The Campus Bullet - All Posts",
			'link' => $feed_link,
		);
		
		//check if the user has seen the what's new page
		$lastvisit = Cookie::get('lastvisit','');
		$announcement_row = DB::select('timestamp')->from('announcements')->order_by('timestamp','DESC')->execute()->current();
		$content->announcement = false;
		
		if ($announcement_row) { //make sure there's at least one announcement in the system			
			if ($lastvisit && strtotime($lastvisit) < strtotime($announcement_row['timestamp'])) {							
				$content->announcement = true;
			} elseif ( ! $lastvisit) {				
				Cookie::set('lastvisit',$announcement_row['timestamp'],31536000); // set the cookie to the last announcement row..
			}
		}
					
		$this->template->content = $content;
	}
	
	public function action_category($category_request) {
		if ($category_request == "askkyle")
			Request::instance()->redirect('askkyle');
			
		$viewall = ($category_request == "all");		
		$feed = isset($_GET['feed']);
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
				$current_posts = DB::select('id','name','description','timestamp','price','wanted','image')->from('posts')->where('disabled','=','0')->and_where('wanted','=',$wanted)->order_by('timestamp','DESC')
					->limit($pagination->items_per_page)->offset($pagination->offset)->execute()->as_array();			
			else
				$current_posts = DB::select('id','name','description','timestamp','price','wanted','image')->from('posts')->where('category','=',$category_row['id'])->and_where('disabled','=','0')->and_where('wanted','=',$wanted)->order_by('timestamp','DESC')
					->limit($pagination->items_per_page)->offset($pagination->offset)->execute()->as_array();			
				
			$dategroups = array();
			
			foreach($current_posts as $post) {
				$date = date("m-d-Y", strtotime($post['timestamp']));
				if ($post['wanted'])
					$post_title = "$post[name]";
				elseif ($post['price'] > 0)
					$post_title = "$post[name] ($$post[price])";
				else
					$post_title = "$post[name] (FREE!)";
					
				//if we have a dategroup, add this to the current one
				if (array_key_exists($date, $dategroups)) {
					array_push($dategroups[$date], array(
						'id' => $post['id'], 
						'title' => $post_title,
						'image' => $post['image']));
				} else {
					$dategroups = $dategroups + array(
						$date => array(
							array(
								'id' => $post['id'], 
								'title' => $post_title,
								'image' => $post['image']
							)
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
			$feed_link = URL::base(false,true) . "home/category/" . $content->category_name . "/?feed";
			if ($wanted)
				$feed_link .= "&wanted";
				
			$this->template->feed = array(
				'title' => "The Campus Bullet - " . $content->category_prettyname,
				'link' => $feed_link,
			);
			
			if ($feed) {
				$feed_title = "The Campus Bullet - " . $content->category_prettyname;
				$feed_description = $content->category_description;
				$feed_items = array();
				foreach ($current_posts as $post) {
					if ($post['wanted'])
						$post_title = $post['name'];
					elseif ($post['price'] > 0)
						$post_title = $post['name'] . " ($$post[price])";
					else
						$post_title = $post['name'] . " (FREE!)";
					array_push($feed_items, array(
						'title' => $post_title,
						'description' => $post['description'],
						'pubDate' => strtotime($post['timestamp']),
						'link' => 'home/view/' . $post['id'],
					));
				}
				
				if ($wanted)
					$feed_title .= " (wanted)";
					
				$this->auto_render = false;
				$this->request->response = Feed::create(
					array(
						'title' => $feed_title,
						'description' => "This feed provides the last 30 posts for this category.",						
						'link' => 'home/category/' . $content->category_name,
					),$feed_items);
			} else {
				$this->template->content = $content;
			}
			
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
		
		$post = DB::select('*')->from('posts')->where('id','=',$id)->and_where('disabled','!=','4')->execute()->current();
			
		if ($post) {
			if ($post['disabled'] == 1 && $post['owner'] != $user_id) {
				$content = View::factory('home_post_gone');
				$content->url_base = URL::base();
				$this->template->content = $content;
			} else {			
				if ($post['disabled'] != 0 && $post['owner'] != $user_id) {
					if ( ! $user_id)
						Request::instance()->redirect("login?redir=home/view/$id");
					else
						Request::instance()->redirect('home');
				}
				$category_row = DB::select('name','prettyname')->from('categories')->where('id','=',$post['category'])->execute()->current();
				if (isset($_GET['newpost']))
					$content->postcreated = true;
				else
					$content->postcreated = false;
				
				//set up stuff for the facebook share button
				$this->template->fb_title = $post['name'];
				$this->template->fb_description = $post['description'];
				if ($post['image']) {				
					$this->template->fb_image = URL::base(false,true) . "images/posts/$post[id]-1.jpg";
					$this->template->fb_postid = $post['id'];
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
				$content->post_category_prettyname = $category_row['prettyname'];
				$content->post_condition = $post['condition'];
				$content->post_isbn = $post['isbn'];
				$content->url_base = $base;
				$content->post_id = $id;
				$content->post_date = date("M d, Y",strtotime($post['timestamp']));
				
				$content->post_images = array();
				for ($i = 1; $i <= $post['image']; $i++) {
					array_push($content->post_images, URL::base() . "images/posts/$id-$i.jpg");
				}
				$this->template->title = $content->post_title;
				$this->template->content = $content; 
			}
		} else {
			Request::instance()->redirect('home');
		}
	}

}
