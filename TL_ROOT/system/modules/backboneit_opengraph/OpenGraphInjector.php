<?php

class OpenGraphInjector extends Controller {
	
	protected $objOpenGraph;

	protected function __construct() {
		parent::__construct();
		$this->import('Database');
	}
	
	private final function __clone() {}
	
	public function generatePageOG() {
		if(isset($this->objOpenGraph))
			return;
		
		global $objPage;
		$objCurrent = $objPage;
		
		if(!$objCurrent->backboneit_opengraph) {
			do {
				$objCurrent = $this->Database->prepare(
					'SELECT * FROM tl_page WHERE id=?'
				)->execute($objCurrent->pid);
			} while(!$objCurrent->backboneit_opengraph_handdown && $objCurrent->pid);
			
			if(!$objCurrent->backboneit_opengraph)
				return;
		}
		
		$arrCurrent = $objCurrent->row();
		
		$this->objOpenGraph = OpenGraph::createFromDataset($arrCurrent, array(
			OpenGraph::TITLE		=> $objCurrent->pageTitle ? $objCurrent->pageTitle : $objCurrent->title,
			OpenGraph::URL			=> $this->generateFrontendUrl($arrCurrent),
			OpenGraph::DESCRIPTION	=> $objCurrent->description,
			OpenGraph::SITE			=> $objPage->rootTitle
		));
	}
	
	public function inject() {
		if(!isset($this->objOpenGraph))
			return;
			
		$GLOBALS['TL_HEAD'][] = strval($this->objOpenGraph);
	}
	
	public function injectNS($strBuffer, $strTemplate) {
		if(!isset($this->objOpenGraph) || strncmp($strTemplate, 'fe_', 3) !== 0)
			return $strBuffer;
			
		$strHTMLNSDecl = 'xmlns="http://www.w3.org/1999/xhtml"';
		$strStart = strpos($strBuffer, $strHTMLNSDecl) + strlen($strHTMLNSDecl);
		return substr_replace($strBuffer, ' ' . $this->objOpenGraph->getNamespaceDecl(), $strStart, 0);
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance))
			self::$objInstance = new self();
			
		return self::$objInstance;
	}
	
}