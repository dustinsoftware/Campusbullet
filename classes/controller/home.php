<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Layout {

	public function action_index()
	{
		$content = View::factory('home');
		
		$current_count = DB::query(Database::SELECT, "select count(id) as count from posts where disabled=0")->execute()->current();
		$current_count = $current_count['count'];
		
		$pagination = new Pagination(array(
			'total_items' => $current_count,
			'items_per_page' => 30,			
			));
		
		$current_posts = DB::select('id','name','timestamp')->from('posts')->where('disabled','=','0')->order_by('timestamp','DESC')
			->limit($pagination->items_per_page)->offset($pagination->offset)->execute()->as_array();
				
		$dategroups = array();
		
		foreach($current_posts as $post) {
			$date = date("m-d-Y", strtotime($post['timestamp']));
			
			//if we have a dategroup, add this to the current one
			if (array_key_exists($date, $dategroups)) {
				array_push($dategroups[$date], array(
					'id' => $post['id'], 
					'title' => $post['name']));
			} else {
				$dategroups = $dategroups + array(
					$date => array(
						array(
							'id' => $post['id'], 
							'title' => $post['name'])
						)
					);
			}
		}
		
		$content->dategroups = $dategroups;

		$content->postbase = URL::base() . 'home/view' . '/';
		$content->pagination = $pagination;
		
		$this->template->content = $content;
	}
	
	public function action_view($id) {
		$content = View::factory('home_post_view');
		$user_id = Session::instance()->get('user_id');
		$base = URL::base();
		
		$post = DB::select('*')->from('posts')->where('id','=',$id)->and_where('disabled','=','0')->execute()->current();
		
		if ($post) {
			$content->is_owner = ($post['owner'] == $user_id);
			$content->preview = false;
			$content->post_title = $post['name'];
			$content->post_price = $post['price'];
			$content->post_description = $post['description'];
			$content->post_image = "";
			$content->post_condition = $post['condition'];
			$content->link_want = $base . "contact/want/" . $id;
			$content->link_report = $base . "contact/message/ml_abuse?postid=" . $id;
			$content->link_prev = $base . "home";
			$content->link_edit = $base . "account/posts/" . $id;
			
			
			$this->template->content = $content; 
		} else {
			Request::instance()->redirect('home');
		}
	}

}
