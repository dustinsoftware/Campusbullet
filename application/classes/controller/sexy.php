<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sexy extends Controller_Layout {

	protected $auth_required = false;
	
	public function before() {
		parent::before();
		$this->template = View::factory('notemplate_sexy');
	}
	
	
	public function action_index() {
		$cache = Cache::instance('memcache');
		
		$announcements = $cache->get('announcements');
		
		if ( ! $announcements) {			
			$dom = new DOMDocument();
			$dom->load('http://letustartpage.blogspot.com/feeds/posts/default?alt=rss');
			
			$announcements = array();
			$count = 0;
			foreach($dom->getElementsByTagName('item') as $item) {
				$announcement = array(
					'title' => $item->getElementsByTagName('title')->item(0)->nodeValue,
					'description' => $item->getElementsByTagName('description')->item(0)->nodeValue,
					'id' => $count++,
				);
				array_push($announcements, $announcement);
			}
			
			$cache->set('announcements',$announcements);
		}
		
		$this->template->announcements = $announcements;	
		
	}	
	
}
