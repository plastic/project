<?php
App::import('Vendor', 'DOMPDF', array('file' => '/dompdf/dompdf_config.inc.php'));
$dompdf = new DOMPDF();

$css = $this->ScriptCombiner->css(array('admin'));
$href = preg_match('/(href\=\")([^\"]*)/i', $css, $matches);
$style = file_get_contents(WWW_ROOT . $matches[2]);

$layout = '<html>';
$layout .= '<head><style>' . $style . '</style></head>';
$layout .= $this->fetch('content');
$layout .= '</html>';

$dompdf->load_html(utf8_decode($layout), Configure::read('App.encoding'));
$dompdf->render();
echo $dompdf->output();
?>