<?php
class Image extends AppModel {
	public $actsAs = array('Media.Transfer', 'Media.Generator', 'Media.Coupler', 'Media.Meta');
	public $validate = array(
		'file' => array(
			'mimeType' => array(
				'rule' => array('checkMimeType', false, array( 'image/jpeg')),
				'message' => 'imagem inválida!'
			)
		)
	);
}