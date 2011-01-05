<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Image extends Controller_Layout {

	public function action_index() {
		Request::instance()->redirect('home');
	}
	
	public function action_post($id) {
		$user_id = Session::instance()->get('user_id');
		$is_moderator = Session::instance()->get('moderator');
		if ($is_moderator)
			$post_row = DB::select('id','name','image')->from('posts')->where('id','=',$id)->execute()->current();
		else
			$post_row = DB::select('id','name','image')->from('posts')->where('owner','=',$user_id)->and_where('id','=',$id)->execute()->current();
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
				$content->message = "Your post was created successfully.&nbsp; If you want, you can also attach a picture to it!";
			}
		
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
				elseif ($file['type'] != "image/jpeg")
					array_push($errors, "The file must be a JPEG file.");
				else {
					Upload::save($file, "$id.jpg", "$masterlist_root/images/posts");
					DB::update('posts')->set(array('image' => '-1'))->where('id','=',$id)->execute();
					$content->message = "The image was successfully uploaded!";
					$content->image = URL::base() . "images/posts/$id.jpg";
				}
				
				$content->errors = $errors;
			}
			$this->template->content = $content;
		} else {
			Request::instance()->redirect('post/edit');
		}		
	}
	
}
