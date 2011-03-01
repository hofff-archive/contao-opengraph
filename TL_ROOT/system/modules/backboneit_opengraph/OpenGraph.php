<?php

class OpenGraph {
	
	const TITLE			= 'og:title';
	const TYPE			= 'og:type';
	const IMAGE			= 'og:image';
	const URL			= 'og:url';
	
	const DESCRIPTION	= 'og:description';
	const SITE			= 'og:site_name';
	
	const LATITUDE		= 'og:latitude';
	const LONGITUDE		= 'og:longitude';

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
	
	const ISBN			= 'og:isbn'; // international standard book number
	const UPC			= 'og:upc'; // universal product code
	
	const NS_OG			= 'http://ogp.me/ns#';
	const NS_PREFIX_OG	= 'og';
	
	const NS_HTML		= 'http://www.w3.org/1999/xhtml/';
	const NS_PREFIX_HTML= 'h';
	
	public static function createFromDocument(DOMDocument $objDoc) {
		$objOG = new self();
		
		$objXPath = new DOMXPath($objDoc);
		$objXPath->registerNamespace(
			self::NS_PREFIX_HTML,
			$objDoc->lookupPrefix(self::NS_HTML) ? self::NS_HTML : $objDoc->lookupNamespaceUri(null)
		);
		$strNSPrefixOG = $objDoc->lookupPrefix(self::NS_OG);
		$strNSPrefixOG or $strNSPrefixOG = self::NS_PREFIX_OG;
		
		$objResult = $objXPath->query('//h:meta[starts-with(@property, "' . $strNSPrefixOG . ':")]');
		for($i = 0, $n = $objResult->length; $i < $n; $i++) {
			$objItem = $objResult->item($i);
			$objOG->set($objItem->getAttribute('property'), $objItem->getAttribute('content'));
		}
		
		return $objOG;
	}
	
	protected $arrProperties;
	
	public function __construct(array $arrProperties = null) {
		if($arrProperties)
			$this->set($arrProperties);
	}
	
	public function __unset($strKey) {
		unset($this->arrProperties[$strKey]);
	}
	
	public function __set($strKey, $varValue) {
		$this->set($strKey, $varValue);
	}
	
	public function set($strProperty, $strContent) {
		if(is_array($strProperty)) {
			foreach($strProperty as $strName => $strContent)
				$this->arrProperties[$strName] = $strContent;
		} elseif($strContent === null) {
			unset($this->arrProperties[$strProperty]);
		} else {
			$this->arrProperties[$strProperty] = $strContent;
		}
	}
	
	public function __get($strKey) {
		return $this->get($strKey);
	}
	
	public function get($strProperty) {
		return $strProperty ? $this->arrProperties[$strProperty] : $this->arrProperties;
	}
	
	public function __toString() {
		$strReturn = '';
		
		foreach($this->arrProperties as $strName => $strContent)
			if(strlen($strContent))
				$strReturn .= '<meta property="' . $strName . '" content="' . specialchars($strContent) . '" />' . "\n";
			
		return $strReturn; 
	}
	
	public static function getNamespaceDecl($strPrefix = self::NS_PREFIX_OG) {
		return sprintf('xmlns%s="%s"', $strPrefix ? ':' . $strPrefix : '', self::NS_OG); 
	}
	
}