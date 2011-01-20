<?/** http://www.seanodonnell.com/code/?id=29
 * @file ImageMagick.php
 * 
 * The ImageMagick class is intended to provide a 
 * front-end PHP Object Oriented Interface to using 
 * the ImageMagick photo manipulation tools.
 *
 * I personally prefer using the ImageMagick Library 
 * over the PHP/GD Library, as the quality of the GD Library
 * is (proven to be) slightly less than that of ImageMagick.
 *
 * @requires PHP >= 4 (w/ safe_mode=off), ImageMagick
 *
 * @copyleft 2004 Sean O'Donnell <sean@seanodonnell.com>
 *
 * $Id: $
 *
 */
class ImageMagick 
{
    /**
     * define the path to the ImageMagick convert utility
     * (using a constant instead of a variable)
     */
    
    var $convert = 'C:\imagemagick\convert.exe';
    
    function ImageMagick()
    {
		if ( ! file_exists($this->convert))
			die ("ImageMagick not found at $this->convert");
        return;
    }

    function constrain($file_path,$int_max_width,$int_max_height) 
    {
        if (file_exists($file_path))
        {
            $int_imgsize = getimagesize($file_path);
    
            if ($int_imgsize[0] > $int_max_width || $int_imgsize[1] > $int_max_height) 
            {
                /**
                 * resize photo to fit interface restrictions, 
                 * constrained by width and/or height
                 */
                exec($this->convert ." -geometry ". $int_max_width ."x". $int_max_height ." ". $file_path ." ". $file_path);
            } 
        }
        else
        {
            die($file_path ." does not exist");
        }
        return;
    }

    function constrain_by_width($file_path,$int_max_width) 
    {
        if (file_exists($file_path))
        {
            $int_imgsize = getimagesize($file_path);
    
            if ($int_imgsize[0] > $int_max_width) 
            {
                /**
                 * resize photo to fit interface restrictions, 
                 * constrained by width
                 */
				exec($this->convert ." -geometry ". $int_max_width ." ". $file_path ." ". $file_path);
            } 
        }
        else
        {
            die($file_path ." does not exist");
        }
        return;
    }

    function constrain_by_height($file_path,$int_max_height) 
    {
        if (file_exists($file_path))
        {
            $int_imgsize = getimagesize($file_path);
    
            if ($int_imgsize[0] > $int_max_width) 
            {
                /**
                 * resize photo to fit interface restrictions, 
                 * constrained by height
                 */
                exec($this->convert ." -geometry x". $int_max_height ." ". $file_path ." ". $file_path);
            } 
        }
        else
        {
            die($file_path ." does not exist");
        }
        return;
    }
}
?>