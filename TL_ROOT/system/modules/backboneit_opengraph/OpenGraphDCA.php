<?php

class OpenGraphDCA extends Backend {
	
	protected function __construct() {
		parent::__construct();
	}
	
	private final function __clone() {}
	
	private static $arrOfficialTypes = array(
		'activities'	=> array('activity', 'sport'),
		'businesses'	=> array('bar', 'company', 'cafe', 'hotel', 'restaurant'),
		'groups'		=> array('cause', 'sports_league', 'sports_team'),
		'organizations'	=> array('band', 'government', 'non_profit', 'school', 'university'),
		'people'		=> array('actor', 'athlete', 'author', 'director', 'musician', 'politician', 'public_figure'),
		'places'		=> array('city', 'country', 'landmark', 'state_province'),
		'products_and_entertainment' => array('album', 'book', 'drink', 'food', 'game', 'product', 'song', 'movie', 'tv_show'),
		'websites'		=> array('blog', 'website', 'article')
	);
	
	public function getTypeOptions() {
		$arrOptions = self::$arrOfficialTypes;
		
		$objResult = $this->Database->execute('SELECT id, name FROM tl_opengraph_types');
		
		while($objResult->next())
			$arrOptions['custom'][$objResult->id] = $objResult->name;
		
		return $arrOptions;
	}
	
	public function validateNCName($varValue) {
		if(!preg_match('@[a-z][a-z0-9]*@i', $varValue))
			throw new Exception($GLOBALS['TL_LANG']['tl_opengraph_types']['ncNameError']);
			
		return $varValue;
	}
	
	private static $objInstance;
	
	public static function getInstance() {
		if(!isset(self::$objInstance))
			self::$objInstance = new self();
			
		return self::$objInstance;
	}
	
}