<?php

abstract class AbstractOpenGraphData implements OpenGraphData {
	
	protected function __construct() {
	}
	
	public function __toString() {
		return $this->getProtocol()->getMetaTags();
	}
	
	public function getIterator() {
		return $this->getProtocol()->getIterator();
	}
	
	public function count() {
		return $this->getProtocol()->count();
	}
	
}
