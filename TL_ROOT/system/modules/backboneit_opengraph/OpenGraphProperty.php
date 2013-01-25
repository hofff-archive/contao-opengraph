<?php

class OpenGraphname {
	
	protected $namespace;
	
	protected $name;
	
	protected $content;
	
	protected $prefix;
	
	public function __construct($namespace, $name, $content, $prefix = null) {
		$this->setNamespace($namespace);
		$this->setName($name);
		$this->setContent($content);
		$this->setPrefix($prefix);
	}
	
	public function __toString() {
		return $this->getMetaTag();
	}
	
	public function getMetaTag($prefix = true) {
		return $this->isValid() ? sprintf('<meta%s property="%s" content="%s" />',
			$prefix ? sprintf(' prefix="%s"', specialchars($this->getNamespaceDeclaration())) : '',
			specialchars($this->getPrefixedName()),
			specialchars($this->getContent()),
		) : '';
	}
	
	public function getNamespaceDeclaration() {
		return sprintf('%s: %s', $this->getPrefix(), $this->getNamespace());
	}
	
	public function getPrefixedName() {
		return sprintf('%s:%s', $this->getPrefix(), $this->getName());
	}
	
	public function isValid() {
		return $this->hasNamespace() && $this->hasName() && $this->hasContent();
	}
	
	public function setNamespace($namespace) {
		$namespace = strval($namespace);
		if(strlen($namespace)) {
			$this->namespace = $namespace;
		} else {
			unset($this->namespace);
		}
		return $this;
	}
	
	public function hasNamespace() {
		return isset($this->namespace);
	}
	
	public function getNamespace() {
		return $this->namespace;
	}
	
	public function setName($name) {
		$name = strval($name);
		if(strlen($name)) {
			$this->name = $name;
		} else {
			unset($this->name);
		}
		return $this;
	}
	
	public function hasName() {
		return isset($this->name);
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setContent($content) {
		$content = strval($content);
		if(strlen($content)) {
			$this->content = $content;
		} else {
			unset($this->content);
		}
		return $this;
	}
	
	public function hasContent() {
		return isset($this->content);
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function setPrefix($prefix) {
		$prefix = strval($prefix);
		$this->prefix = strlen($prefix) ? $prefix : 'p';
		return $this;
	}
	
	public function getPrefix() {
		return $this->prefix;
	}
	
}
