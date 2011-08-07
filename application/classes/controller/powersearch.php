<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Powersearch extends Controller_Layout {
	public function before() {
		parent::before();
		$this->template->title = "Textbook Powersearch";
	}

	protected $auth_required = false;
	
	public function action_index() {
	
		$isbns = @($_GET['isbn']);
		$content = View::factory('powersearch');
		$content->booklist = null;
		
		if ($isbns) {
			$booklist = array();
			$isbns = explode(",", $isbns);
			foreach ($isbns as $isbn) {
				//$content .= "<a href=\"http://www.google.com/search?q=$isbn\">$isbn</a> <br />";
				$dom = new DOMDocument();
				$dom->load('http://www.google.com/books/feeds/volumes?q=ISBN' . $isbn);
				
				$result = $dom->getElementsByTagName('entry')->item(0);
				
				if ($result) {
					$title = $result->getElementsByTagName('title')->item(0)->nodeValue;
					//$author = $result->getElementsByTagName('dc:creator')->item(0)->nodeValue;
					$author = "";
					$booklist += array($isbn => array(
						'title' => $title,
					));					
				}
				
			}
			
			$content->booklist = $booklist;
		}
	
		$this->template->content = $content;
	}
	
}
