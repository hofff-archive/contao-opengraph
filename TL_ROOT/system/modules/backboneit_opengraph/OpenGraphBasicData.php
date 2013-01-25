<?php

class OpenGraphBasicData extends AbstractOpenGraphData {
	
	public function __construct($title = null, OpenGraphType $type = null, $image = null, $url = null) {
		parent::__construct();
		$this->setTitle($title);
		$this->setType($type);
		$image instanceof OpenGraphImageData ? $this->setImageData($image) : $this->setImage($image);
		$this->setURL($url);
	}
	
	protected $title;
	
	public function setTitle($title) {
		$title = strval($title);
		if(strlen($title)) {
			$this->title = $title;
		} else {
			unset($this->title);
		}
		return $this;
	}
	
	public function hasTitle() {
		return isset($this->title);
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getTitleData() {
		$protocol = new OpenGraphProtocol();
		$this->hasTitle() && $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'title', $this->getTitle()));
		return $protocol;
	}
	
	protected $type;
	
	public function setType(OpenGraphType $type = null) {
		if($type === null) {
			unset($this->type);
		} else {
			$this->type = $type;
		}
		return $this;
	}
	
	public function hasType() {
		return isset($this->type);
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getTypeData() {
		$protocol = new OpenGraphProtocol();
		$this->hasType() && $protocol->add($this->getType());
		return $protocol;
	}
	
	protected $image;
	
	public function setImage($url) {
		$url = strval($url);
		if(strlen($url)) {
			$this->image = new OpenGraphImageData($url);
		} else {
			unset($this->image);
		}
		return $this;
	}
	
	public function hasImage() {
		return isset($this->image);
	}
	
	public function getImage($image) {
		return $this->hasImage ? $this->image->getURL() : null;
	}
	
	public function setImageData(OpenGraphImageData $image) {
		$this->image = $image;
	}
	
	public function getImageData() {
		return $this->image;
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
		$this->hasURL() && $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'url', $this->getURL()));
		return $protocol;
	}
	
	protected $description;
	
	public function setDescription($description) {
		$description = strval($description);
		if(strlen($description)) {
			$this->description = $description;
		} else {
			unset($this->description);
		}
		return $this;
	}
	
	public function hasDescription() {
		return isset($this->description);
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getDescriptionData() {
		$protocol = new OpenGraphProtocol();
		$this->hasDescription() && $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'description', $this->getDescription()));
		return $protocol;
	}
	
	protected $site;
	
	public function setSiteName($site) {
		$site = strval($site);
		if(strlen($site)) {
			$this->site = $site;
		} else {
			unset($this->site);
		}
		return $this;
	}
	
	public function hasSiteName() {
		return isset($this->site);
	}
	
	public function getSiteName() {
		return $this->site;
	}
	
	public function getSiteNameData() {
		$protocol = new OpenGraphProtocol();
		$this->hasSiteName() && $protocol->add(new OpenGraphProperty(OpenGraphProtocol::NS_OG, 'site_name', $this->getSiteName()));
		return $protocol;
	}
	
	public function isValid() {
		return $this->hasTitle() && $this->hasType() && $this->hasImage() && $this->getImageData()->isValid() && $this->hasURL();
	}
	
	public function getProtocol() {
		$protocol = new OpenGraphProtocol();
		$protocol->append($this->getTitleData());
		$protocol->append($this->getTypeData());
		$protocol->append($this->getImageData());
		$protocol->append($this->getURLData());
		$protocol->append($this->getDescriptionData());
		$protocol->append($this->getSiteNameData());
		return $protocol;
	}
	
}
