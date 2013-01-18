<?php

class OpenGraphDCA extends Backend {
	
	protected function __construct() {
		parent::__construct();
	}
	
	private final function __clone() {}
	
	public function validateNCName($varValue) {
		if(!preg_match('@[a-z][a-z0-9]*@i', $varValue))
			throw new Exception($GLOBALS['TL_LANG']['bbit_og']['ncNameError']);
			
		return $varValue;
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance))
			self::$objInstance = new self();
			
		return self::$objInstance;
	}
	
}