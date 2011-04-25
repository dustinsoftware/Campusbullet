<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Layout {
	public function before() {
		parent::before();
		$this->template->title = "Search";
	}

	protected $auth_required = false;
	
	public function action_index() {
		$content = View::factory('search_home');
		
		if (isset($_GET['q']) && $_GET['q']) {
			//do a search!
			$query = @(htmlspecialchars($_GET['q']));			
			$content = View::factory('search_results');
			
			$post_rows = DB::select('id','name','timestamp','wanted','price')->from('posts')				
				->where('disabled','=','0')
				->and_where_open()
				->where('name','LIKE',"%$query%")
				->or_where('description','LIKE',"%$query%")
				->or_where('isbn','=',"$query")
				->where_close()->execute()->as_array();
			$search_results = array();
			
			foreach ($post_rows as $post) {
				if ($post['wanted'])
					$post_title = $post['name'];
				elseif ($post['price'] > 0)
					$post_title = "$post[name] ($$post[price])";
				else
					$post_title = "$post[name] (FREE)";
					
				array_push($search_results,array(
					'id' => $post['id'],
					'title' => $post_title,
					'wanted' => $post['wanted'],
				));
				
			}
			
			
			$content->posts = $search_results;
			$content->query = $query;
			$this->template->searchquery = $query;
			
		}
		$content->url_base = URL::base();
		$this->template->content = $content;
	}
	
}
