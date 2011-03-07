<?php defined('SYSPATH') or die('No direct script access.');

include_once 'imagemagick.php';

class Controller_Image extends Controller_Layout {
	public function before() {
		parent::before();
		$this->template->title = "Image Uploader";
	}
	

	public function action_index() {
		Request::instance()->redirect('home');
	}
	
	public function action_post($id) {
		$im = new ImageMagick();
		
		$user_id = Session::instance()->get('user_id');
		$is_moderator = Session::instance()->get('moderator');
		if ($is_moderator)
			$post_row = DB::select('id','name','image','category')->from('posts')->where('id','=',$id)->execute()->current();
		else
			$post_row = DB::select('id','name','image','category')->from('posts')->where('owner','=',$user_id)->and_where('id','=',$id)
				->and_where('disabled','!=','4')->execute()->current();
		$config = Kohana::config('masterlist');
		$masterlist_root = $config['root'];
		
		if ($post_row) {			
			$content = View::factory('image_uploader');
			$content->errors = array();
			$content->message = "";
			$content->url_base = URL::base();
			$content->post_name = $post_row['name'];
			$content->post_link = URL::base() . "home/view/$id";
			$content->post_id = $post_row['id'];
			
			
			if (@($_GET['postcreated']) && ! $_POST) {
				$content->message = "Your post was created successfully.&nbsp; If you want, you can also attach a picture to it!&nbsp; ";
			}
		
			if ($post_row['category'] == 2)
				$content->message .= "If you don't upload a picture, an image will be pulled from the internet with the ISBN you entered.";
			
			if ($post_row['image']) {				
				$content->image = URL::base() . "images/posts/$id.jpg";
			} else {			
				$content->image = "";
			}				
			
			$file = @($_FILES['picture']);
			$disable = "";
			
			if ($_POST) {
				$disable = @($_POST['disable']);
				
				if ($disable) {
					DB::update('posts')->set(array('image' => '0'))->where('id','=',$id)->execute();
					$content->message = "The image was successfully removed.";
					$content->image = "";
				}
			}
			if ($file && ! $disable) {
				$errors = array();
				if ($file['error'])
					array_push($errors, "There was an error uploading the file.&nbsp; Please try again.");
				elseif ($file['size'] > 2000000)
					array_push($errors, "The image is too big!&nbsp; Please take one that's under 2 MB.");
				else {					
					try {					
						$filepath = "$masterlist_root/images/posts";
						Upload::save($file, "$id.tmp", "$filepath");
						
						$image = $this->image_from_file($filepath . "/$id.tmp");
						if ($image) {							
							imagejpeg($image, $filepath . "/$id.jpg");						
							unlink($filepath . "/$id.tmp");
							imagedestroy($image);
							
							//resize the new image to the constrained proportions
							$im->constrain("$filepath/$id.jpg",640,480);
							
							DB::update('posts')->set(array('image' => '-1'))->where('id','=',$id)->execute();
							if (@($_GET['postcreated']))
								Request::instance()->redirect("home/view/$id?postcreated=true");
							
							$content->message = "The image was successfully uploaded!";
							$content->image = URL::base() . "images/posts/$id.jpg";
						} else {
							throw (new Exception("invalid file"));
						}
						
					} catch (Exception $e) {
						array_push($errors, "The file must be a PNG, JPG, or GIF file.&nbsp; Try uploading the picture again.");
					}
				}
				
				$content->errors = $errors;
			}
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('post/edit');
		}		
	}
	
	private function image_from_file($path) {
		//http://www.php.net/manual/en/function.imagecreate.php
		$info = @getimagesize($path);
	   
		if(!$info)
		{
			return false;
		}
	   
		$functions = array(
			IMAGETYPE_GIF => 'imagecreatefromgif',
			IMAGETYPE_JPEG => 'imagecreatefromjpeg',
			IMAGETYPE_PNG => 'imagecreatefrompng',			
			);
	   
		if(!$functions[$info[2]])
		{
			return false;
		}
	   
		if(!function_exists($functions[$info[2]]))
		{
			return false;
		}
	   
		return $functions[$info[2]]($path);
	}
	
}
