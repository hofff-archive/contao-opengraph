<?php

class OpenGraphType extends OpenGraphProperty {
	
	private $type;
	
	private $typeNamespace;
	
	private $typePrefix;
	
	public function __construct($type = null, $typeNamespace = null, $typePrefix = null) {
		parent::__construct();
		parent::setNamespace(OpenGraphProtocol::NS_OG);
		parent::setName('type');
		$this->setType($type);
		$this->setTypeNamespace($typeNamespace);
		$this->setTypePrefix($typePrefix);
	}
	
	public function getMetaTag($prefix = true) {
		if($prefix) {
			$prefix = $this->getTypeNamespaceDeclaration();
			$prefix && $prefix = ' ' . $prefix;
			$prefix = sprintf(' prefix="%s%s"',
				specialchars($this->getNamespaceDeclaration()),
				specialchars($prefix)
			);
		} else {
			$prefix = '';
		}
		return sprintf('<meta%s property="%s" content="%s" />',
			$prefix,
			specialchars($this->getPrefixedName()),
			specialchars($this->getContent())
		);
	}
	
	public function setType($type) {
		$type = strval($type);
		if(strlen($type)) {
			$this->type = $type;
		} else {
			unset($this->type);
		}
		return $this;
	}
	
	public function hasType() {
		return isset($this->type);
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getTypeNamespaceDeclaration() {
		return $this->hasTypeNamespace() ? sprintf('%s: %s',
			$this->getTypePrefix(),
			$this->getTypeNamespace()
		) : '';
	}
	
	public function setTypeNamespace($typeNamespace) {
		$typeNamespace = strval($typeNamespace);
		if(strlen($typeNamespace)) {
			$this->typeNamespace = $typeNamespace;
		} else {
			unset($this->typeNamespace);
		}
		return $this;
	}
	
	public function hasTypeNamespace() {
		return isset($this->typeNamespace);
	}
	
	public function getTypeNamespace() {
		return $this->typeNamespace;
	}
	
	public function setTypePrefix($typePrefix) {
		$typePrefix = strval($typePrefix);
		$this->typePrefix = strlen($typePrefix) ? $typePrefix : 't';
		return $this;
	}
	
	public function getTypePrefix() {
		return $this->typePrefix;
	}
	
	public function setNamespace($namespace) {
		return $this;
	}
	
	public function setName($name) {
		return $this;
	}
	
	public function setContent($content) {
		$this->setType($content);
		return $this;
	}
	
	public function hasContent() {
		return $this->hasType();
	}
	
	public function getContent() {
		return $this->hasTypeNamespace()
			? sprintf('%s:%s', $this->getTypePrefix(), $this->getType())
			: $this->getType();
	}
	
}
