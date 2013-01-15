<?php

class OpenGraph implements IteratorAggregate {
	
	const NS_OG			= 'http://ogp.me/ns#';
	const NS_PREFIX_OG	= 'og';
	
	const NS_HTML		= 'http://www.w3.org/1999/xhtml/';
	const NS_PREFIX_HTML= 'h';
	
	
	public static function createFromDataset(array $arrData, array $arrFallback = null) {
		$objOG = new self();
		
		if(is_numeric($arrData['backboneit_opengraph_type'])) {
			$objType = Database::getInstance()->prepare(
				'SELECT * FROM tl_backboneit_opengraph_types WHERE id = ?'
			)->execute($arrData['backboneit_opengraph_type']);
			
			$arrData['backboneit_opengraph_type'] = $objOG->addNamespace($objType->prefix, $objType->namespace) . ':' . $objType->name;
		}
		
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
			$strURL = $objOG->get(OpenGraph::IMAGE);
			$objOG->set(OpenGraph::IMAGE, $strBase . ($strURL[0] == '/' ? substr($strURL, 1) : $strURL));
		}
		
		if(!isset($objOG->{OpenGraph::URL})) {
			$objOG->set(OpenGraph::URL, $strBase . Environment::getInstance()->request);
		} elseif(strncmp($objOG->get(OpenGraph::URL), 'http://', 7) !== 0) {
			$strURL = $objOG->get(OpenGraph::URL);
			$objOG->set(OpenGraph::URL, $strBase . ($strURL[0] == '/' ? substr($strURL, 1) : $strURL));
		}
		
		return $objOG;
	}
	
	protected $arrProperties = array();
	protected $arrNamespaces = array('' => false, 'og' => false);
	
	public function __construct() {
	}
	
	public function __toString() {
		$strReturn = '';
		foreach($this->arrProperties as $strName => $strContent) if(strlen($strContent)) {
			$strReturn .= '<meta property="' . $strName . '" content="' . htmlspecialchars($strContent) . '" />' . "\n";
		}
		return $strReturn; 
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
	
	public function get($strProperty) {
		return $this->arrProperties[$strProperty];
	}
	
	public function addNamespace($strPrefix, $strNamespace) {
		$this->arrNamespaces[$strPrefix] = $strNamespace;
	}
	
	public function getNamespaces() {
		return $this->arrNamespaces; 
	}
	
	public function getIterator() {
		return new ArrayIterator($this->arrProperties);
	}
	
}