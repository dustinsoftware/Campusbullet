<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Layout {

	protected $auth_required = false;
	
	public function action_index() {
		$content = View::factory('search_home');
		
		if (isset($_GET['q']) && $_GET['q']) {
			//do a search!
			$query = @(htmlspecialchars($_GET['q']));			
			$content = View::factory('search_results');
			
			$post_rows = DB::select('id','name','timestamp')->from('posts')				
				->where('disabled','=','0')
				->and_where_open()
				->where('name','LIKE',"%$query%")
				->or_where('description','LIKE',"%$query%")
				->or_where('isbn','=',"$query")
				->where_close()->execute()->as_array();
				
			
				
				
			$content->posts = $post_rows;
			$content->query = $query;
			
		}
		$content->url_base = URL::base();
		$this->template->content = $content;
	}
	
}
