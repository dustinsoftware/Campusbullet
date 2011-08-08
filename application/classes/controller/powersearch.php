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
				$dom = new DOMDocument();
				$dom->load('http://www.google.com/books/feeds/volumes?q=ISBN' . $isbn);
				
				$result = $dom->getElementsByTagName('entry')->item(0);
				
				if ($result) {
					$title = $result->getElementsByTagName('title')->item(0)->nodeValue;
					//$author = $result->getElementsByTagName('dc:creator')->item(0)->nodeValue;
					$author = "";
					$booklist += array($isbn => array(
						'title' => $title,
						'author' => $author,
					));					
				}
				
			}
			
			$content->enginelist = array(
				'chegg' => array(
					'title' => "Chegg",
					'base' => "http://www.chegg.com/search/",
				),
				'allbookstores' => array(
					'title' => "All Bookstores",
					'base' => "http://www.allbookstores.com/book/compare/",
				),
				'bigwords' => array(
					'title' => "Bigwords",
					'base' => "http://www5.bigwords.com/search/?z=easysearch&searchtype=all&searchstring=",
				),
				'amazon' => array(
					'title' => "Amazon.com",
					'base' => "http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Dstripbooks&field-keywords=",
				),
				'ebay' => array(
					'title' => "Ebay",
					'base' => "http://shop.ebay.com/i.html?_sacat=See-All-Categories&_nkw=",
				),
				'half' => array(
					'title' => "Half.com",
					'base' => "powersearch/halfredirect?isbn=",
				),
				
				
				
				
			);
			$content->booklist = $booklist;
		}
	
		$this->template->content = $content;
	}
	
	public function action_halfredirect() {
		$this->template = View::factory('powersearch_halfredirect');
	}
	
	
}
