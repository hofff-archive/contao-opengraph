<?php

class ContaoOpenGraphManager extends Controller {

	protected function __construct() {
		parent::__construct();
	}
	
	private final function __clone() {}
	
	protected $objOGP;
	
	public function setOpenGraph(OpenGraphProtocol $objOGP) {
		$this->objOGP = $objOGP;
	}
	
	public function getOpenGraph() {
		return $this->objOGP;
	}
	
	public function inject($objPage, $objLayout, $objPageGenerator) {
		$objOGP = $this->objOGP
			? $this->objOGP
			: ContaoOpenGraphFactory::create()->generateBasicDataByPageID($GLOBALS['objPage']->id);
		
		$objOGP && $GLOBALS['TL_HEAD'][] = $objOGP->getProtocol()->getMetaTags();
		
// 		$arrPrefixes = array();
// 		foreach($this->objOGP->getNamespaces() as $strPrefix => $strNS) {
// 			$arrPrefixes[] = $strPrefix . ': ' . $strNS;
// 		}
		
// 		$objPageGenerator->Template->og_prefixes = implode(' ', $arrPrefixes);
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance)) {
			self::$objInstance = new self();
		}
			
		return self::$objInstance;
	}
	
}