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
				if (is_isbn_valid($isbn) && ! array_key_exists($isbn, $booklist)) {
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
			}
			
			$content->enginelist = array(
				'allbookstores' => array(
					'title' => "All Bookstores",
					'base' => "http://www.allbookstores.com/book/compare/",
				),
				'chegg' => array(
					'title' => "Chegg",
					'base' => "http://www.chegg.com/search/",
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

function is_isbn_valid($isbn) {
	if (strlen($isbn) == 13) {
		$check = 0;
		for ($i = 0; $i < 13; $i+=2) $check += substr($isbn, $i, 1);
		for ($i = 1; $i < 12; $i+=2) $check += 3 * substr($isbn, $i, 1);
		return $check % 10 == 0;
	} elseif (strlen($isbn) == 10) {
		$check = 0;
		for ($i = 0; $i < 9; $i++) $check += (10 - $i) * substr($isbn, $i, 1);
		$t = substr($isbn, 9, 1); // tenth digit (aka checksum or check digit)
		$check += ($t == 'x' || $t == 'X') ? 10 : $t;
		return $check % 11 == 0;
	}
	return false;
}
