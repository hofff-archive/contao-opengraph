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
		foreach($GLOBALS['BBIT_OG']['TYPES'] as $strType) {
			if(strpos($strType, ' ') === false) {
				list($strGroup, $strName) = explode('.', $strType);
				strlen($strName) || $strGroup = 'general';
				$arrOptions[$strGroup][] = $strType;
			} else {
				$arrCustom[] = $strType;
			}
		}
		$arrCustom && $arrOptions['custom'] = $arrCustom;
		return $arrOptions;
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance))
			self::$objInstance = new self();
			
		return self::$objInstance;
	}
	
}