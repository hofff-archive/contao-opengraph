<?php

class ContaoOpenGraphFrontend extends Controller {

	protected function __construct() {
		parent::__construct();
	}
	
	private final function __clone() {}
	
	protected $objOGD;
	
	public function setOpenGraphData(OpenGraphData $objOGD) {
		$this->objOGD = $objOGD;
	}
	
	public function getOpenGraphData() {
		return $this->objOGD;
	}
	
	public function inject($objPage, $objLayout, $objPageGenerator) {
		$objOGP = $this->getOpenGraphData()
			? $this->getOpenGraphData()
			: ContaoOpenGraphFactory::create()->generateBasicDataByPageID($GLOBALS['objPage']->id);
		
		$objOGP && $GLOBALS['TL_HEAD'][] = $objOGP->getProtocol()->getMetaTags();
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance)) {
			self::$objInstance = new self();
		}
			
		return self::$objInstance;
	}
	
}