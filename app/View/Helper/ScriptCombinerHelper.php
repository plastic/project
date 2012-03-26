<?php 
App::uses('AppHelper', 'View/Helper');
Configure::load('script_combiner');

App::import('Lib', 'Compressor');
App::import('Vendor', 'JsMin', array('file' => 'jsmin' . DS . 'jsmin.php'));

class ScriptCombinerHelper extends AppHelper {
	public $helpers = array('Html', 'Js');
	private $cssCachePath;
	private $jsCachePath;
	private $cacheLength;
	private $enabled = false;
	
    public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		if (!Configure::read('ScriptCombiner')) {
			trigger_error('Please define the ScriptCombiner configuration options.', E_USER_WARNING);
			return;
		}

		$this->cssCachePath = Configure::read('ScriptCombiner.cssCachePath');
		if (!is_dir($this->cssCachePath)) {
			trigger_error('Cannot locate CSS combination cache directory at ' . $this->cssCachePath . ', or path is not writable.', E_USER_WARNING);
			return;
		}

		$this->jsCachePath = Configure::read('ScriptCombiner.jsCachePath');
		if (!is_dir($this->jsCachePath) || !is_writable($this->jsCachePath)) {
			trigger_error('Cannot locate Javascript combination cache directory at ' . $this->jsCachePath . ', or path is not writable.', E_USER_WARNING);
			return;
		}

		$cacheLength = Configure::read('ScriptCombiner.cacheLength');
		if (is_string($cacheLength)) {
			$this->cacheLength = strtotime($cacheLength) - time();
		} else {
			$this->cacheLength = (int)$cacheLength;
		}

		if ( Configure::read('debug') == 0 ) {
			$this->enabled = true;
		}
	}

	public function css() {
		$cssFiles = func_get_args();
		
		if (empty($cssFiles)) {
			return '';
		}

		// if ($this->enabled) {
		// 	return $this->Html->css($cssFiles);
		// }

		if (is_array($cssFiles[0])) {
			$cssFiles = $cssFiles[0];
		}
		$cacheKey = md5(serialize($cssFiles));
		$cacheFile = "{$this->cssCachePath}combined.{$cacheKey}.css";

		if ($this->isCacheFileValid($cacheFile)) {
			return $this->Html->css($this->convertToUrl($cacheFile));
		}

		$cssData = array();
		$links = $this->Html->css($cssFiles, 'import');
		preg_match_all('#\(([^\)]+)\)#i', $links, $urlMatches);
		
		if (isset($urlMatches[1])) {
			$urlMatches = $urlMatches[1];
		} else {
			$urlMatches = array();
		}
		
		$compressor = new Compressor(array('stripComments' => false, 'debug' => !$this->enabled));
		foreach ($urlMatches as $urlMatch) {
			$cssPath = ltrim(Router::normalize($urlMatch), '/');
			$cssData = null;
			$cssData[] = $compressor->process($cssPath, null);
		}

		if (Configure::read('ScriptCombiner.compressCss') && $this->enabled) {
			$cssData = $this->compressCss($cssData);
		}

		if (file_put_contents($cacheFile, $cssData) > 0) {
			return $this->Html->css($this->convertToUrl($cacheFile));
		}
		return $this->Html->css($cssFiles);
    }

    public function js() {
        $jsFiles = func_get_args();

        if (empty($jsFiles)) {
            return '';
        }

        if (is_array($jsFiles[0])) {
            $jsFiles = $jsFiles[0];
        }

        $cacheKey = md5(serialize($jsFiles));
        $cacheFile = "{$this->jsCachePath}combined.{$cacheKey}.js";

        if ($this->isCacheFileValid($cacheFile)) {
            return $this->Html->script($this->convertToUrl($cacheFile));
        }

        $jsData = array();
        $jsLinks = $this->Html->script($jsFiles);
		
        preg_match_all('/src="([^"]+)"/i', $jsLinks, $urlMatches);
        if (isset($urlMatches[1])) {
            $urlMatches = array_unique($urlMatches[1]);
        } else {
            $urlMatches = array();
        }

		$compressor = new Compressor(array('stripComments' => false, 'debug' => !$this->enabled));
		foreach ($urlMatches as $urlMatch) {
			$jsPath = ltrim(Router::normalize($urlMatch), '/');
			$jsData = null;
			$jsData[] = $compressor->process($jsPath, null);
		}

		if (Configure::read('ScriptCombiner.compressJs') && $this->enabled) {
			$jsData = $this->compressJs($jsData);
		}

		if (file_put_contents($cacheFile, $jsData) > 0) {
			return $this->Html->script($this->convertToUrl($cacheFile));
		}
		return $this->Html->script($jsFiles);
	}

	private function isCacheFileValid($cacheFile) {
		if (is_file($cacheFile) && $this->cacheLength > 0) {
			$lastModified = filemtime($cacheFile);
			$timeNow = time();
			if (($timeNow - $lastModified) < $this->cacheLength) {
				return true;
			}
		}
		return false;
	}

	private function convertToUrl($filePath) {
		$___path = Set::filter(explode(DS, $filePath));
		$___root = Set::filter(explode(DS, WWW_ROOT));
		$webrootPaths = array_diff_assoc($___path, $___root);
		return ('/' . implode('/', $webrootPaths));
	}

	private function compressCss($cssData) {
		$cssData = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $cssData);
		$cssData = str_replace(array("\r\n", "\r", "\n", "\t"), '', $cssData);
		$cssData = preg_replace('/;\s*}/i', '}', $cssData);
		$cssData = preg_replace('/[\t\s]*{[\t\s]*/i', '{', $cssData);
		$cssData = preg_replace('/[\t\s]*:[\t\s]*/i', ':', $cssData);
		$cssData = preg_replace('/(\d)[\s\t]+(em|px|%)/i', '$1$2', $cssData);
		$cssData = preg_replace('/url[\s\t]+\(/i', 'url(', $cssData);
		return $cssData;
	}

    private function compressJs($jsData) {
		return JsMin::minify($jsData);
    }
}