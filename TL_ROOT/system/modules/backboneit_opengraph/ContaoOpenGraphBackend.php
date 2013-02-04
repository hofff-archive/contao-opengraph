<?php

class ContaoOpenGraphBackend extends Backend {
	
	protected function __construct() {
		parent::__construct();
	}
	
	private final function __clone() {}
	
	
	public function keyFacebookLint() {
		$strTarget = 'https://developers.facebook.com/tools/debug/og/object?q=';
		$objPage = $this->getPageDetails($this->Input->get('id'));
		if($objPage) {
			if(strlen($objPage->domain)) {
				$strTarget .= urlencode('http://' . $objPage->domain . '/' . TL_PATH);
			} else {
				$strTarget .= urlencode($this->Environment->base);
			}
			$strTarget .= urlencode($this->generateFrontendURL($objPage->row()));
		} 
		$this->redirect($strTarget);
	}
	
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
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance))
			self::$objInstance = new self();
			
		return self::$objInstance;
	}
	
}