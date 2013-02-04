<?php

interface OpenGraphData extends IteratorAggregate, Countable {
	
	public function __toString();
	
	public function getProtocol();
	
}
