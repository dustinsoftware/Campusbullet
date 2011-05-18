<?php defined('SYSPATH') or die('No direct script access.');

include 'html_scrape.php';

class Controller_Start extends Controller_Layout {

	protected $auth_required = false;
	
	public function before() {
		parent::before();
		
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
			$this->template = View::factory('notemplate_sexy_mobile');
		else
			$this->template = View::factory('notemplate_sexy');
		
	}
	
	
	public function action_index() {
		if (IN_PRODUCTION) {		
			$cache = Cache::instance('memcache');			
			$announcements = $cache->get('announcements');
			$cafe_menu = $cache->get('cafe_menu');
		} else {
			$announcements = null;
			$cache = null;
			$cafe_menu = null;
		}
		if ( ! $announcements) {			
			//start page announcements
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
		
			
			try {
				throw(new Exception("not needed for summer"));
				//saga menu
				$menuhtml = file_get_html('http://www.cafebonappetit.com/letu/cafes/thecafe/weekly_menu.html');
				//die(Kohana::debug($menuhtml));
				
				$boxbody = $menuhtml->find('div.boxbody',0)->find('table',0);
				$weeks = array();
				$days = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
				$previousdata = "";
				$previousday = "";
				
				if ($boxbody) {
					//remove images
					foreach ($boxbody->find('img') as $img) {
						$img->outertext = "";
					}
						
					
					//parse all the items on the menu
					foreach ($boxbody->find('tr') as $row) {
						//check for a date
						foreach ($days as $day) {
							if (strpos(strtolower($row->innertext),$day)) {
								if ($previousdata) {
									$weeks += array($previousday => $previousdata);
								}
								$previousdata = "";
								$previousday = $day;						
							}
						}
						
						if ($previousday) {
							$str = (string)$row;
							$previousdata .= $str;					
						}
					}
					
					$today = strtolower(date('l'));
					
					
					if (array_key_exists($today, $weeks))
						$cafe_menu = $weeks[$today];
					else
						$cafe_menu = null;
						
				}
				
			} catch (Exception $e) { }
			
				
			
			if ($cache) {
				$cache->set('cafe_menu',$cafe_menu);
				$cache->set('announcements',$announcements);
			}
		}
		
		$this->template->announcements = $announcements;	
		$this->template->cafe_menu = $cafe_menu;
	}	
	
}
