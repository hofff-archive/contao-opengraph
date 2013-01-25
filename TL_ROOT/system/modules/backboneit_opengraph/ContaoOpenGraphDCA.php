<?php

class ContaoOpenGraphDCA extends Backend {
	
	protected function __construct() {
		parent::__construct();
	}
	
	private final function __clone() {}
	
	public function getTypeOptions() {
		$arrOptions = array();
		foreach($GLOBALS['BBIT_OG']['TYPES'] as $objType) {
			if($objType->hasTypeNamespace()) {
				$arrOptions['other'][] = sprintf('%s %s',
					$objType->getTypeNamespace(),
					$objType->getType()
				);
			} else {
				list($strGroup, $strType) = explode('.', $objType->getContent());
				strlen($strType) || $strGroup = 'general';
				$arrOptions[$strGroup][] = $objType->getContent();
			}
		}
// 		$arrOptions['other'] = (array) $arrOptions['other'];
// 		array_unshift($arrOptions['other'], 'custom');
		return $arrOptions;
	}
	
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