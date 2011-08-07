<?php defined('SYSPATH') or die('No direct script access.');

include_once 'imagemagick.php';

class Controller_Image extends Controller_Layout {
	
	public function before() {
		parent::before();
		$this->template->title = "Image Uploader";
		array_push($this->template->styles, 'image_uploader');
		
	}
	

	public function action_index() {
		Request::instance()->redirect('home');
	}
	
	public function action_bookcover($id) {
		if (isset($_GET['newpost']))
			$newpost = "?newpost";
		else
			$newpost = "";
		
		$user_id = Session::instance()->get('user_id');
		$post_row = DB::select('id','name','isbn','category','image')->from('posts')
			->where('owner','=',$user_id)
			->and_where('id','=',$id)
			->and_where('image','<','4')
			->and_where('disabled','!=','4')->execute()->current();
		
		if ($post_row) {
			if ($post_row['category'] != 2 || strcmp($post_row['isbn'],"") == 0) { //if this isn't a book
				Request::instance()->redirect("image/post/$id{$newpost}");
			}
			$content = View::factory('image_bookcover');
			$content->post_id = $id;
			
			$content->message = "";
			$coverlink = "http://covers.openlibrary.org/b/isbn/" . $post_row['isbn'] . "-L.jpg";
			$content->coverlink = $coverlink;
			$yes = @($_POST['yes']);
			$no = @($_POST['no']);
			
			if ($yes) {
				try {
					$image_index = $post_row['image'] + 1;
					$config = Kohana::config('masterlist');
					$savepath = $config['image_filepath'];
					$image = imagecreatefromjpeg($coverlink);
					imagejpeg($image, "$savepath/$id-$image_index.jpg");
					DB::update('posts')->set(array('image' => $image_index))->where('id','=',$id)->execute();
					if ($newpost) {
						Request::instance()->redirect("home/view/$id?newpost");
					} else {
						Request::instance()->redirect("image/post/$id");
					}
				} catch (Exception $e) {
					$content->message = "Sorry, there was a problem grabbing the image.&nbsp; You can try again, or download the cover manually and upload it." ;
				}
			}
			if ($no) {
				Request::instance()->redirect("image/post/$id{$newpost}");
			}
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect("image/post/$id");
		}
		
	}
	
	public function action_post($id) {
		if (isset($_GET['newpost']))
			$newpost = "?newpost";
		else
			$newpost = "";
		
		$im = new ImageMagick();
		
		$user_id = Session::instance()->get('user_id');
		$post_row = DB::select('id','name','image','category','isbn')->from('posts')->where('owner','=',$user_id)->and_where('id','=',$id)
			->and_where('disabled','!=','4')->execute()->current();
			
		$config = Kohana::config('masterlist');
		$image_limit = $config['image_limit'];
		$filepath = $config['image_filepath'];
						
		
		if ($post_row) {			
			$content = View::factory('image_uploader');
			$content->errors = array();
			$content->message = "";
			$content->url_base = URL::base();
			$content->post_name = $post_row['name'];
			$content->post_link = URL::base() . "home/view/$id";
			$content->post_id = $post_row['id'];
			$content->image_limit = $image_limit;
			$content->newpost = $newpost;
			$post_images_count = count($this->get_post_images($image_limit, $filepath, $id));
			
			$file = @($_FILES['picture']);
			
			if ($file && $post_images_count < $image_limit) {
				$errors = array();
				if ($file['error'])
					array_push($errors, "There was an error uploading the file.&nbsp; Please try again.");
				elseif ($file['size'] > 2000000)
					array_push($errors, "The image is too big!&nbsp; Please use one that's under 2 MB.");
				else {
					try {
						Upload::save($file, "$id.tmp", "$filepath");
						
						$image = $this->image_from_file($filepath . "/$id.tmp");
						if ($image) {
							$index = 1;
							while (file_exists("$filepath/$id-$index.jpg"))
								$index++;
								
							
							$filename = $filepath . "/$id-$index.jpg";
							imagejpeg($image, $filename);	//write the image		
							unlink($filepath . "/$id.tmp"); //delete the temporary file
							imagedestroy($image);
							
							//resize the new image to the constrained proportions
							$im->constrain($filename,640,480);
							
							$content->post_images = $this->get_post_images($image_limit, $filepath, $id);							
							DB::update('posts')->set(array('image' => count($content->post_images)))->where('id','=',$id)->execute();
							
							$content->message = "The image was successfully uploaded!&nbsp; <a href=\"" . URL::base() . "home/view/$id$newpost\">Click here to view your post once you're done uploading images.</a>";
							
						} else {
							throw (new Exception("invalid file"));
						}
						
						
					} catch (Exception $e) {
						if (IN_PRODUCTION)
							array_push($errors, "The file must be a PNG, JPG, or GIF file.&nbsp; Try uploading the picture again.");
						else
							array_push($errors, "$e");
					}
					
					
				}
				
				$content->errors = $errors;
			}
			$content->post_images = $this->get_post_images($image_limit, $filepath, $id);
			
			if (count($content->post_images) < $image_limit) {
				$content->allow_image_upload = true;
			} else {
				$content->allow_image_upload = false;
				$content->message = "You've uploaded the maximum number of photos allowed for a post.&nbsp; Delete one to upload another.";
			}
			
			if ($post_row['category'] == 2 && count($content->post_images) == 0) {
				try {			
					$coverlink = "http://covers.openlibrary.org/b/isbn/" . $post_row['isbn'] . "-L.jpg";
					$image = imagecreatefromjpeg($coverlink);
					
					$content->message .= "Hey, we think we know what cover belongs to this book!&nbsp; <a href=\"" . URL::base() . "image/bookcover/$id\">Click here to automatically pull an image from the internet matching the ISBN of your book.</a>";
				} catch (Exception $e) { }
			}

			
			
			
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('post/edit');
		}		
	}
	
	public function action_remove($id) {
		$config = Kohana::config('masterlist');
		$filepath = $config['image_filepath'];
		$image_limit = $config['image_limit'];
		$user_id = Session::instance()->get('user_id');
		$post_row = DB::select('id','name','image','category')->from('posts')->where('owner','=',$user_id)->and_where('id','=',$id)
			->and_where('disabled','!=','4')->execute()->current();
		$post_image_index = @($_GET['image']);
		
		if ($post_row && $post_image_index) {
			$confirmed = @($_POST['confirmed']);
			
			if ($confirmed) {
				$filename = "$filepath/$id-$post_image_index.jpg";
				if (file_exists($filename)) {
					unlink($filename); //delete the file
					
					//check the rest of the post images and shift them down if they exist.
					$next_file_index = $post_image_index;
					for ($current_index = $post_image_index + 1; $current_index <= $image_limit; $current_index++) {
						$oldfile = "$filepath/$id-$current_index.jpg";
						if (file_exists($oldfile)) {							
							$image = $this->image_from_file($oldfile);
							$newfile = "$filepath/$id-$next_file_index.jpg";
							if (file_exists($newfile)) {
								die("bug: about to pave over an existing file!");
							}
							imagejpeg($image, $newfile);
							unlink($oldfile);
							$next_file_index++;
						}
					}
					
					$post_images = $this->get_post_images($image_limit, $filepath, $id);
					DB::update('posts')->set(array('image' => count($post_images)))->where('id','=',$id)->execute();					
				}
				
				Request::instance()->redirect("image/post/$id?imageremoved");
			} else {
				$content = View::factory('form_confirm');
				$content->form_items = array(
					'confirmed' => 'yes',
					'image_index' => $post_image_index,
				);	
				$content->goback = URL::base() . "image/post/$id";
				$content->action = "image_delete";
				$this->template->content = $content;
			}
		} else {	
			Request::instance()->redirect("image/post/$id");
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
	
	private function get_post_images($image_limit, $filepath, $id) {
		$thumb_width = 300;
		$post_images = array();
		for ($i = 1; $i <= $image_limit; $i++) {
			$image_filename = "$filepath/$id-$i.jpg";
			if (file_exists($image_filename)) {
				list($width, $height, $type, $attr) = getimagesize($image_filename);
				
				if ($width > $thumb_width) {
					$percentage = ($thumb_width / $width); // 300 pixels wide
					
					$width = round($width * $percentage); 
					$height = round($height * $percentage); 						
				}
				
				array_push($post_images, array(
					'link' => URL::base() . "images/posts/?q=$id-$i",
					'width' => $width,
					'height' => $height,
					'index' => $i,
				));
			}
		}
		
		return $post_images;
	}
	
	
	
}

