<?php
if(!defined('CURRENT_VIEW'))
	define('CURRENT_VIEW', $this->params['controller'] . '/' . $this->params['action']);

$cssList = array('admin');
if (isset($this->requestCss))
	$cssList[] = $this->requestCss;

echo $this->ScriptCombiner->css($cssList);
?>