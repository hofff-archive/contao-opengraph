<?php

class OpenGraphImageData extends AbstractOpenGraphData {
	
	public function __construct($url = null) {
		parent::__construct();
		$this->setURL($url);
	}
	
	protected $url;
	
	public function setURL($url) {
		$url = strval($url);
		if(strlen($url)) {
			$this->url = $url;
		} else {
			unset($this->url);
		}
		return $this;
	}
	
	public function hasURL() {
		return isset($this->url);
	}
	
	public function getURL() {
		return $this->url;
	}
	
	public function getURLData() {
		$protocol = new OpenGraphProtocol();
		$this->hasURL() ? $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'image', $this->getURL()));
		return $protocol;
	}
	
	protected $secure;
	
	public function setSecureURL($secure) {
		$secure = strval($secure);
		if(strlen($secure)) {
			$this->secure = $secure;
		} else {
			unset($this->secure);
		}
		return $this;
	}
	
	public function hasSecureURL() {
		return isset($this->secure);
	}
	
	public function getSecureURL() {
		return $this->secure;
	}
	
	public function getSecureURLData() {
		$protocol = new OpenGraphProtocol();
		$this->hasSecureURL() ? $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'image:secure_url', $this->getSecureURL()));
		return $protocol;
	}
	
	protected $mime;
	
	public function setMIMEType($mime) {
		$mime = strval($mime);
		list($base) = explode('/', $mime, 2);
		if($base == 'image') {
			$this->mime = $mime;
		} else {
			unset($this->mime);
		}
		return $this;
	}
	
	public function hasMIMEType() {
		return isset($this->mime);
	}
	
	public function getMIMEType() {
		return $this->mime;
	}
	
	public function getMIMETypeData() {
		$protocol = new OpenGraphProtocol();
		$this->hasMIMEType() ? $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'image:type', $this->getMIMEType()));
		return $protocol;
	}
	
	protected $width;
	
	public function setWidth($width) {
		if(is_numeric($width) && $width >= 1) {
			$this->width = intval($width);
		} else {
			unset($this->width);
		}
		return $this;
	}
	
	public function hasWidth() {
		return isset($this->width);
	}
	
	public function getWidth() {
		return $this->width;
	}
	
	public function getWidthData() {
		$protocol = new OpenGraphProtocol();
		$this->hasWidth() ? $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'image:width', $this->getWidth()));
		return $protocol;
	}
	
	protected $height;
	
	public function setHeight($height) {
		if(is_numeric($height) && $height >= 1) {
			$this->height = intval($height);
		} else {
			unset($this->height);
		}
		return $this;
	}
	
	public function hasHeight() {
		return isset($this->height);
	}
	
	public function getHeight() {
		return $this->height;
	}
	
	public function getHeightData() {
		$protocol = new OpenGraphProtocol();
		$this->hasHeight() ? $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'image:height', $this->getHeight()));
		return $protocol;
	}
	
	public function isValid() {
		return $this->hasURL();
	}
	
	public function getProtocol() {
		$protocol = new OpenGraphProtocol();
		$protocol->append($this->getURLData());
		$protocol->append($this->getSecureURLData());
		$protocol->append($this->getMIMETypeData());
		$protocol->append($this->getWidthData());
		$protocol->append($this->getHeightData());
		return $protocol;
	}
	
}
