<?php
class Attribute {
	private $dataType;
	private $name;
	private $value = null;
	
	public function __construct($name, DataType $dataType) {
		if (! is_string($name))
			throw new Exception("Attribute: \$name has to be STRING");
		
		$this->name = $name;
		$this->dataType = $dataType;
	}
	
	public function getSQL() {
		return "{$this->name} {$this->dataType->getSQL()}";
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getDataType() {
		return $this->dataType;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($value) {
		if (! $this->dataType->checkValue($value))
			throw new Exception("Attribute->setValue: \$value not conform to DataType");
		$this->value = $value;
	}
}
?>