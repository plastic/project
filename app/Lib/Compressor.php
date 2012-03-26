<?php
class Compressor {

	public $settings = array(
		'debug' => false,
		'stripComments' => false
	);

	public $requirePattern = '/^\s?\/\/\=\s+require\s+([\"\<])([^\"\>]+)[\"\>]/';
	public $requireImportPattern = '/^\s?\@import\s+url\(\"([^"]*)\"\)\;\n?/m';
	public $extension = null;
	protected $_inCommentBlock = false;
	protected $_loaded = array();
	protected $_processedOutput = '';
	protected $_processedFiles = array();

	function __construct($settings) {
		$this->settings = array_merge($this->settings, $settings);
	}

	public function process($object, $url) {
		$this->extension = end(explode('.', $object));
		$fileName = $this->_findFile($object);
		$this->_preprocess($fileName, $url);
		$out = trim($this->_processedOutput);
		return $out;
	}

	protected function _record($line) {
		if ($this->settings['stripComments']) {
			$this->_processedOutput .= $this->_stripComments($line);
			return;
		}
		$this->_processedOutput .= $line;
	}

	protected function _findFile($object, $path = null) {
		if (file_exists($object)) {
			return $object;
		}
		
		$filename = trim($object, '/');
		
		if (!strpos($filename, '.' . $this->extension)) {
			$filename .= '.' . $this->extension;
		}
		
		if (substr($filename, 0, 2) == $this->extension) {
			$filename = substr($filename, 2);
		}
		
		if (!is_null($path) && file_exists(realpath($path . $filename))) {
			return realpath($path . $filename);
		}
		
		$filePath = realpath(Configure::read('App.www_root') . $this->extension . DS  . $filename);
		
		if (file_exists($filePath)) {
			return $filePath;
		}
		
		$parts = explode('/', $filename);
		
		if (in_array('theme', $parts)) {
			$themeName = preg_match('/theme\/([^\/]+)/i', $filename, $theme);
			$themeName = $theme[1];
			unset($theme[0], $theme[1], $parts[0], $parts[1]);
			
			$fileFragment = urldecode(implode(DS, $parts));
			$viewPaths = App::path('views');
			
			foreach ($viewPaths as $viewPath) {
				$path = App::themePath($themeName) . 'webroot' . DS;
				if (file_exists($path . $fileFragment)) {
					return $path . $fileFragment;
				}
			}
			
		} else {
			$plugin = $parts[0];
			unset($parts[0]);
			$fileFragment = implode('/', $parts);
			$pluginWebroot = CakePlugin::path($plugin) . 'webroot' . DS;
			if (file_exists($pluginWebroot . $fileFragment)) {
				return $pluginWebroot . $fileFragment;
			}
		}
		throw new Exception('Could not locate file for ' . $object);
	}

	protected function _preprocess($filename, $url = null) {
		if (in_array($filename, $this->_processedFiles)) {
			return '';
		}
		
		$this->_processedFiles[] = $filename;
		if (isset($this->_loaded[$filename])) {
			return '';
		}
		
		$this->_loaded[$filename] = true;
		$fileHandle = fopen($filename, 'r');
		while (!feof($fileHandle)) {
			$line = fgets($fileHandle);
			
			if ($this->extension == 'js') {
				$pattern = $this->requirePattern;
			} else {
				$pattern = $this->requireImportPattern;
			}
			
			if (preg_match($pattern, $line, $requiredObject)) {
				if ($requiredObject[1] == '"') {
					$requireFilename = $this->_findFile($requiredObject[2], dirname($filename) . DS);
				} else {
					if (!empty($requiredObject[1])) {
						$requireFilename = $this->_findFile($requiredObject[1], dirname($filename) . DS);
					} else {
						$requireFilename = $this->_findFile($requiredObject[2]);
					}
				}
				$line = $this->_preprocess($requireFilename);
			}
			$this->_record($line);
		}
		
		if ($this->settings['debug']) {
			$this->_record("\n\n\n /** {$filename} **/ \n\n\n");
		} else {
			$this->_record("\n");
		}
		return '';
	}

	protected function _stripComments($line) {
		$inlineComment = '#^\s*//.*$#s';
		$blockCommentLine = '#^\s*/\*+.*\*+/#s';
		$blockCommentStart = '#^\s*/\*+(?!!).*#s';
		$blockCommentEnd = '#^.*\*+/.*#s';
		if ($this->_inCommentBlock) {
			if (preg_match($blockCommentEnd, $line)) {
				$this->_inCommentBlock = false;
			}
			return '';
		}
		if (preg_match($inlineComment, $line)) {
			return '';
		}
		if (preg_match($blockCommentLine, $line)) {
			return '';
		}
		if (preg_match($blockCommentStart, $line)) {
			$this->_inCommentBlock = true;
			return '';
		}
		return $line;
	}
}