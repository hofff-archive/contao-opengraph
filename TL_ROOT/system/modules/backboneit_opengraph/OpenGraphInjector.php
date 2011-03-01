<?php

class OpenGraphInjector {
	
	protected $objOpenGraph;

	private function __construct() {}
	
	private final function __clone() {}
	
	public function generatePageOG() {
		if(isset($this->objOpenGraph))
			return;
		
		global $objPage;
		$objCurrent = $objPage;
		
		while(!$objCurrent->backboneit_opengraph && $objCurrent->pid) {
			$objCurrent = $this->Database->prepare(
				'SELECT * FROM tl_page WHERE id=?'
			)->execute($objCurrent->pid);
		}
		
		if(!$objCurrent->backboneit_opengraph)
			return;
		
		$objOG = new OpenGraph(array(
			OpenGraph::TITLE => $objCurrent->backboneit_opengraph_title,
			OpenGraph::TYPE => $objCurrent->backboneit_opengraph_type,
			OpenGraph::DESCRIPTION => $objCurrent->backboneit_opengraph_description,
			OpenGraph::IMAGE => $objCurrent->backboneit_opengraph_image,
			OpenGraph::URL => '', 
			OpenGraph::SITE => $objPage->rootTitle
		));
	
		$arrGeo = deserialize($objCurrent->backboneit_opengraph_geo);
		if($arrGeo[0] && $arrGeo[1]) {
			$objOG->set(OpenGraph::LATITUDE, $arrGeo[0]);
			$objOG->set(OpenGraph::LONGITUDE, $arrGeo[1]);
		}
		
		switch($objCurrent->backboneit_opengraph_type) {
			case 'book':
				if($objCurrent->backboneit_opengraph_isbn)
					$objOG->set(OpenGraph::ISBN, $objCurrent->backboneit_opengraph_isbn);
				break;
				
			case 'product':
				if($objCurrent->backboneit_opengraph_upc)
					$objOG->set(OpenGraph::ISBN, $objCurrent->backboneit_opengraph_upc);
				break;
		}
		
		
		$objOG->set();
		$objOG->set();
  `backboneit_opengraph_street` varchar(255) NOT NULL default '',
  `backboneit_opengraph_postal` varchar(255) NOT NULL default '',
  `backboneit_opengraph_locality` varchar(255) NOT NULL default '',
  `backboneit_opengraph_region` varchar(255) NOT NULL default '',
  `backboneit_opengraph_country` varchar(255) NOT NULL default '',
  `backboneit_opengraph_email` varchar(255) NOT NULL default '',
  `backboneit_opengraph_phone` varchar(255) NOT NULL default '',
  `backboneit_opengraph_fax` varchar(255) NOT NULL default '',
  `backboneit_opengraph_video` varchar(255) NOT NULL default '',
  `backboneit_opengraph_videodim` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audio` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audiotitle` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audioartist` varchar(255) NOT NULL default '',
  `backboneit_opengraph_audioalbum` varchar(255) NOT NULL default '',
		
	

	const STREET		= 'og:street-address';
	const LOCALITY		= 'og:locality';
	const REGION		= 'og:region';
	const POSTAL		= 'og:postal-code';
	const COUNTRY		= 'og:country-name';
	
	const EMAIL			= 'og:email';
	const PHONE			= 'og:phone_number';
	const FAX			= 'og:fax_number';
	
	const VIDEO			= 'og:video';
	const VIDEO_WIDTH	= 'og:video:width';
	const VIDEO_HEIGHT	= 'og:video:height';
	const VIDEO_TYPE	= 'og:video:type';
	
	const AUDIO			= 'og:audio';
	const AUDIO_TITLE	= 'og:audio:title';
	const AUDIO_ARTIST	= 'og:audio:artist';
	const AUDIO_ALBUM	= 'og:audio:album';
	const AUDIO_TYPE	= 'og:audio:type';
	
	}
	
	public function inject() {
		if(!isset($this->objOpenGraph))
			return;
			
		$GLOBALS['TL_HEAD'][] = strval($this->objOpenGraph);
	}
	
	public function injectNS($strBuffer) {
		$strHTMLNSDecl = 'xmlns="http://www.w3.org/1999/xhtml"';
		$strStart = strpos($strBuffer, $strHTMLNSDecl) + strlen($strHTMLNSDecl);
		return substr_replace($strBuffer, ' ' . OpenGraph::getNamespaceDecl(), $strStart, 0);
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance))
			self::$objInstance = new self();
			
		return self::$objInstance;
	}
	
}