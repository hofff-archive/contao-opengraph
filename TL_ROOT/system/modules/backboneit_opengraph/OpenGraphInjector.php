<?php

class OpenGraphInjector extends Controller {
	
	protected $objOpenGraph;

	protected function __construct() {
		parent::__construct();
		$this->import('Database');
	}
	
	private final function __clone() {}
	
	public function getOpenGraph() {
		return $this->objOpenGraph;
	}
	
	public function setOpenGraph(OpenGraph $objOpenGraph) {
		$this->objOpenGraph = $objOpenGraph;
	}
	
	public function generatePageOG() {
		if(isset($this->objOpenGraph)) {
			return;
		}
		
		$objCurrent = $GLOBALS['objPage'];
		
		if(!$objCurrent->bbit_og) {
			do {
				$objCurrent = $this->Database->prepare(
					'SELECT * FROM tl_page WHERE id = ?'
				)->execute($objCurrent->pid);
			} while(!$objCurrent->bbit_og_handdown && $objCurrent->pid && $objCurrent->type != 'root');
			
			if(!$objCurrent->bbit_og) {
				return;
			}
		}
		
		$arrCurrent = $objCurrent->row();
		
		$this->objOpenGraph = OpenGraph::createFromDataset($arrCurrent, array(
			'og:title'		=> $objCurrent->pageTitle ? $objCurrent->pageTitle : strip_tags($objCurrent->title),
			'og:url'		=> $this->generateFrontendUrl($arrCurrent),
			'og:description'=> $objCurrent->description,
			'og:site_name'	=> strip_tags($GLOBALS['objPage']->rootTitle)
		));
	}
	
	public function inject($objPage, $objLayout, $objPageGenerator) {
		if(!isset($this->objOpenGraph)) {
			return;
		}
			
		$GLOBALS['TL_HEAD'][] = strval($this->objOpenGraph);
		
		$arrPrefixes = array();
		foreach($this->objOpenGraph->getNamespaces() as $strPrefix => $strNS) {
			$arrPrefixes[] = $strPrefix . ': ' . $strNS;
		}
		
		$objPageGenerator->Template->og_prefixes = implode(' ', $arrPrefixes);
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance)) {
			self::$objInstance = new self();
		}
			
		return self::$objInstance;
	}
	
}