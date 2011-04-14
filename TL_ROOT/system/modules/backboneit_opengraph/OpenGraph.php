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
	
	public static function createFromDataset(array $arrData, array $arrFallback = null) {
		$objOG = new self();
		
		foreach(array(
			OpenGraph::TITLE		=> 'backboneit_opengraph_title',
			OpenGraph::TYPE			=> 'backboneit_opengraph_type',
			OpenGraph::IMAGE		=> 'backboneit_opengraph_image',
			OpenGraph::URL			=> 'backboneit_opengraph_url',
			OpenGraph::DESCRIPTION	=> 'backboneit_opengraph_description',
			OpenGraph::SITE			=> 'backboneit_opengraph_site',
			OpenGraph::STREET		=> 'backboneit_opengraph_street',
			OpenGraph::LOCALITY		=> 'backboneit_opengraph_locality',
			OpenGraph::REGION		=> 'backboneit_opengraph_region',
			OpenGraph::POSTAL		=> 'backboneit_opengraph_postal',
			OpenGraph::COUNTRY		=> 'backboneit_opengraph_country',
			OpenGraph::EMAIL		=> 'backboneit_opengraph_email',
			OpenGraph::PHONE		=> 'backboneit_opengraph_phone',
			OpenGraph::FAX			=> 'backboneit_opengraph_fax'
		) as $strOGKey => $strDBKey)
			if(strlen($arrData[$strDBKey]))
				$objOG->set($strOGKey, $arrData[$strDBKey]);
	
		$arrGeo = deserialize($arrData['backboneit_opengraph_geo']);
		if($arrGeo[0] && $arrGeo[1]) {
			$objOG->set(OpenGraph::LATITUDE, $arrGeo[0]);
			$objOG->set(OpenGraph::LONGITUDE, $arrGeo[1]);
		}
		
		switch($arrData['backboneit_opengraph_type']) {
			case 'book':
				if(strlen($arrData['backboneit_opengraph_isbn']))
					$objOG->set(OpenGraph::ISBN, $arrData['backboneit_opengraph_isbn']);
				break;
				
			case 'product':
				if(strlen($arrData['backboneit_opengraph_upc']))
					$objOG->set(OpenGraph::ISBN, $arrData['backboneit_opengraph_upc']);
				break;
		}
		
		$strBase = Environment::getInstance()->base;
		
		if(is_file(TL_ROOT . '/' . $arrData['backboneit_opengraph_video'])) {
			$objOG->set(OpenGraph::VIDEO, $strBase . $arrData['backboneit_opengraph_video']);
			$objFile = new File($arrData['backboneit_opengraph_video']);
			$objFile->mime != 'application/octet-stream' && $objOG->set(OpenGraph::VIDEO_TYPE, $objFile->mime);
			
			$arrDim = deserialize($arrData['backboneit_opengraph_videodim']);
			if($arrDim[0] && $arrDim[1]) {
				$objOG->set(OpenGraph::VIDEO_WIDTH, $arrDim[0]);
				$objOG->set(OpenGraph::VIDEO_HEIGHT, $arrDim[1]);
			}
		}
		
		if(is_file(TL_ROOT . '/' . $arrData['backboneit_opengraph_audio'])) {
			$objOG->set(OpenGraph::AUDIO, $strBase . $arrData['backboneit_opengraph_audio']);
			$objFile = new File($arrData['backboneit_opengraph_audio']);
			$objFile->mime != 'application/octet-stream' && $objOG->set(OpenGraph::AUDIO_TYPE, $objFile->mime);
			
			foreach(array(
				OpenGraph::AUDIO_TITLE	=> 'backboneit_opengraph_audiotitle',
				OpenGraph::AUDIO_ARTIST	=> 'backboneit_opengraph_audioartist',
				OpenGraph::AUDIO_ALBUM	=> 'backboneit_opengraph_audioalbum'
			) as $strOGKey => $strDBKey)
				if(strlen($arrData[$strDBKey]))
					$objOG->set($strOGKey, $arrData[$strDBKey]);
		}
		
		foreach($arrFallback as $strOGKey => $strContent)
			if(!isset($objOG->$strOGKey))
				$objOG->set($strOGKey, $strContent);
		
		if(!isset($objOG->{OpenGraph::TYPE})
		|| !isset($objOG->{OpenGraph::TITLE}))
			return null;
		
		if(!isset($objOG->{OpenGraph::IMAGE})) {
			return null;
		} elseif(strncmp($objOG->get(OpenGraph::IMAGE), 'http://', 7) !== 0) {
			$objOG->set(OpenGraph::IMAGE, $strBase . $objOG->get(OpenGraph::IMAGE));
		}
		
		if(!isset($objOG->{OpenGraph::URL})) {
			$objOG->set(OpenGraph::URL, $strBase . Environment::getInstance()->request);
		} elseif(strncmp($objOG->get(OpenGraph::URL), 'http://', 7) !== 0) {
			$objOG->set(OpenGraph::URL, $strBase . $objOG->get(OpenGraph::URL));
		}
		
		return $objOG;
	}
	
	protected $arrProperties;
	
	public function __construct(array $arrProperties = null) {
		if($arrProperties)
			$this->set($arrProperties);
	}
	
	public function __isset($strKey) {
		return isset($this->arrProperties[$strKey]);
	}

	public function __unset($strKey) {
		unset($this->arrProperties[$strKey]);
	}
	
	public function __set($strKey, $varValue) {
		$this->set($strKey, $varValue);
	}
	
	public function set($strProperty, $strContent = null) {
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