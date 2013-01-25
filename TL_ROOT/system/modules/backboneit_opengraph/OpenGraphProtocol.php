<?php

class OpenGraphProtocol extends AbstractOpenGraphData {
	
	const NS_OG			= 'http://ogp.me/ns#';
	const NS_MUSIC		= 'http://ogp.me/ns/music#';
	const NS_VIDEO		= 'http://ogp.me/ns/video#';
	const NS_ARTICLE	= 'http://ogp.me/ns/article#';
	const NS_BOOK		= 'http://ogp.me/ns/book#';
	const NS_PROFILE	= 'http://ogp.me/ns/profile#';
	const NS_WEBSITE	= 'http://ogp.me/ns/website#';
	
	protected $properties;
	
	public function __construct() {
		parent::__construct();
		$this->clear();
	}
	
	public function getMetaTags() {
		$return = '';
		foreach($this as $property) {
			$return .= $property->getMetaTag() . "\n";
		}
		return $return;
	}
	
	public function add(OpenGraphProperty $property) {
		$this->properties[] = $property;
	}
	
	public function append(OpenGraphData $data) {
		foreach($data as $property) {
			$this->add(clone $property);
		}
	}
	
	public function get($i) {
		return $this->properties[$i];
	}
	
	public function remove($i) {
		array_splice($this->properties, $i, 1);
	}
	
	public function clear() {
		$this->properties = array();
	}
	
	public function getProtocol() {
		return $this;
	}
	
	public function getIterator() {
		return new ArrayIterator($this->properties);
	}
	
	public function count() {
		return count($this->properties);
	}
	
}