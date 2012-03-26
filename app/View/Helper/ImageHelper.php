<?php 
App::uses('AppHelper', 'View/Helper');

class ImageHelper extends AppHelper {

	public $helpers = array('Html');
	public $cacheDir = 'imagecache';
	public $expires  = '+1 year';
	
	function resize($path, $width, $height, $aspect = true, $cut = false, $returnPath = false) {
		$types = array(1 => "gif", "jpeg", "png", "wbmp");
		$url = $path;
		
		if(!file_exists($path) || !($size = getimagesize($url))) {
			return;
		}
		
		list($iwidth, $iheight) = $size;
		
		$hash = md5(serialize(compact('path', 'width', 'height', 'aspect', 'cut')));
		$cachefile = $this->cacheFile($path, $hash);
		
		if (file_exists($cachefile) && (@filemtime($cachefile) > @filemtime($path))) {
			return $this->relFile($path, $hash);
		}
		
		list($iwidth, $iheight, $width, $height) = $this->_resize($iwidth, $iheight, $width, $height, $aspect, $cut);
		
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$relfile = $this->relFile($path, $hash);
		$tempfile = $this->fullPath() . $this->cacheDir . DS . $hash . '.' . $extension;
		
		$resize = ($size[0] != $width) || ($size[1] != $height);
		
		if ($resize) {
			
			$image = call_user_func('imagecreatefrom' . $types[$size[2]], $url);
			
			if (function_exists("imagecreatetruecolor")) {
				$funcCreate = 'imagecreatetruecolor';
				$funcResize = 'imagecopyresampled';
			} else {
				$funcCreate = 'imagecreate';
				$funcResize = 'imagecopyresized';
			}
			
			$temp = $funcCreate($width, $height);
			
			if ($types[$size[2]] == 'png') {
				imagealphablending($temp, false);
				imagesavealpha($temp, true);
				$quality = 9;
			} else {
				$quality = 100;
			}
			
			$funcResize($temp, $image, 0, 0, 0, 0, $width, $height, $iwidth, $iheight);
			
			call_user_func("image" . $types[$size[2]], $temp, $tempfile, $quality);
			imagedestroy ($image);
			imagedestroy ($temp);
			
		} else {
			copy($url, $cachefile);
		}
		
		if (!file_exists(dirname($cachefile))) {
			mkdir(dirname($cachefile), 0777, true);
		}
		
		if (file_exists($tempfile) && !file_exists($cachefile)) {
			rename($tempfile, $cachefile);
		}
		
		if (file_exists($tempfile)) {
			@unlink($tempfile);
		}
		
		if ($returnPath) {
			return $cachefile;
		} else {
			return $relfile;
		}
	}
	
	function clearCache($force = null) {
		$now = time();
		if (!empty($force)) {
			$expires = '-1 day';
		} else {
			$expires = $this->expires;
		}
		
		if (!is_numeric($expires)) {
			$expires = strtotime($expires, $now);
		}
		
		$timediff = $expires - $now;
		
		foreach (glob($this->fullPath() . $this->cacheDir . DS . '*') as $filename) {
			$filetime = @filemtime($filename);
			if ($filetime !== false && $filetime + $timediff < $now) {
				$this->delTree($filename);
			}
		}
		return true;
	}
	
	function delTree($dir) {
		$files = glob( $dir . '*', GLOB_MARK );
		foreach( $files as $file ) :
			if( substr( $file, -1 ) == '/' ){
				$this->delTree( $file );
			} else {
				unlink( $file );
			}
		endforeach;
		
		if (is_dir($dir)) {
			rmdir( $dir );
		}
	}

	function fullPath() {
		return WWW_ROOT . $this->themeWeb . IMAGES_URL;
	}
	
	function relFile($path, $hash) {
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$hash = implode('/', str_split($hash, 2));
		return $this->cacheDir . '/' . $hash . '.' . $extension;
	}
	
	function cacheFile($path, $hash) {
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$hash = implode('/', str_split($hash, 2));
		return str_replace(array('\\', '/', DS), DS, $this->fullPath() . $this->cacheDir . DS . $hash . '.' . $extension);
	}
	
	function _resize($width, $height, $toWidth, $toHeight, $aspect = true, $cut = false) {
		if ($cut) {
			if ($aspect) {
				if (($width / $toWidth) > ($height / $toHeight)) {
					$delta = ($height / $toHeight);
				} else {
					$delta = ($width / $toWidth);
				}
				$width = $toWidth * $delta;
				$height = $toHeight * $delta;
			} else {
				$width = $toWidth;
				$height = $toHeight;
			}
		} else {
			if ($aspect) {
				if (($width / $toWidth) > ($height / $toHeight)) {
					$delta = ($width / $toWidth);
				} else {
					$delta = ($height / $toHeight);
				}
				$toWidth = $width / $delta;
				$toHeight = $height / $delta;
			}
		}
		$toWidth = min($width, $toWidth);
		$toHeight = min($height, $toHeight);
		return array(ceil($width), ceil($height), ceil($toWidth), ceil($toHeight));
	}
}