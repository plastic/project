<?php
class AppModel extends Model {
	public $recursive = -1;
	public $actsAs = array('Containable');
}