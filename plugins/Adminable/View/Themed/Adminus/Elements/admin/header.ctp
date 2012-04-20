<?php
if(!defined('CURRENT_VIEW'))
	define('CURRENT_VIEW', $this->params['controller'] . '/' . $this->params['action']);

$cssList = array('admin');

if (isset($this->viewVars['requestCss']))
	$cssList[] = $this->viewVars['requestCss'];

echo $this->ScriptCombiner->css($cssList);
?>