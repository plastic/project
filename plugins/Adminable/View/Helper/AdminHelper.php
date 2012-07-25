<?php 
App::uses('AppHelper', 'View/Helper');

class AdminHelper extends AppHelper {
	public $helpers = array('Html', 'Form');
	
	public function tableCreate() {
		return '<table border="1" cellpadding="3" cellspacing="3" class="table table-bordered table-striped">';
	}
	
	public function formCreate($model, $method = 'post', $type = 'file') {
		return $this->Form->create($model, array('method' => $method, 'class' => 'form-horizontal', 'type' => $type, 'id' => 'fileupload'));
	}
	
	public function buttonIcon($title, $url, $icon, $class, $confirm = false) {
		if ($confirm) {
			return $this->Html->link('<i class="icon-' . $icon . ' icon-white"></i>', $url, array('title' => $title, 'escape' => false, 'class' => 'btn btn-small btn-' . $class), $confirm);
		}
		return $this->Html->link('<i class="icon-' . $icon . ' icon-white"></i>', $url, array('title' => $title, 'escape' => false, 'class' => 'btn btn-small btn-' . $class));
	}
	
	public function warning($msg) {
		return '<div class="alert alert-block">
			<a class="close" data-dismiss="alert">×</a>
			<h4 class="alert-heading">Atenção!</h4>
			' . $msg . '
		</div>';
	}
	
	public function input($field, $options) {
		$options = array_merge(array('label' => '', 'help' => '', 'type' => 'text', 'class' => '', 'options' => ''), $options);
		$out = '<div class="control-group">';
			$out .= '<label class="control-label" for="input01">' . $options['label'] . '</label>';
			$out .= '<div class="controls">';
				if ( (isset($options['options']) && !empty($options['options'])) || $options['type'] == 'select') {
					$out .= $this->Form->input($field, array('options' => $options['options'], 'type' => $options['type'], 'class' => 'input-xlarge ' . $options['class'], 'label' => false, 'div' => false, 'empty' => '...', 'showParents' => true));
				} else {
					$out .= $this->Form->input($field, array('type' => $options['type'], 'class' => 'input-xlarge ' . $options['class'], 'label' => false, 'div' => false));
				}
				$out .= '<p class="help-block">' . $options['help'] . '</p>';
			$out .= '</div>';
		$out .= '</div>';
		return $out;
	}
	
	public function checklistStart() {
		return '<div class="control-group"><div class="controls">';
	}
	
	public function checklistEnd() {
		return '</div></div>';
	}
	
	public function checklist($field, $label) {
		$out = '<label class="checkbox">';
			$out .= $this->Form->input($field, array('label' => false, 'div' => false));
			$out .= $label;
		$out .= '</label>';
		return $out;
	}
	
	public function convertToFloat($value) {
		$value = str_replace('.', '', $value);
		return str_replace(',', '.', $value);
	}
	
	public function month($month) {
		$date = mktime(0, 0, 0, $month+1, 0, 0);
		return strftime('%B', $date);
	}
}