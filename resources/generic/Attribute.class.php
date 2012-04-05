<?php
class Attribute {
	private $dataType;
	private $name;
	private $value = null;
	private $oldValue = null;
	private $altered = false;
	
	public function __construct($name, DataType $dataType) {
		if (! is_string($name))
			throw new Exception("Attribute: \$name has to be STRING");
		
		$this->name = $name;
		$this->dataType = $dataType;
	}
	
	public function getSql() {
		return "{$this->name} {$this->dataType->getSql()}";
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
		if ($this->value == $value) return false;
		if ($this->dataType->getAutoIncrement()) throw new Exception("Do not alter autoincrement attribute");
		
		if (! $this->altered) {
			$this->altered = true;
			$this->oldValue = $this->value;
		}
		
		$this->value = $value;
	}
	
	public function unalter() {
		$this->altered = false;
	}
	
	public function getAltered() {
		return $this->altered;
	}
	
	public function checkValue() {
		$this->dataType->checkValue($this->value);
	}
	
	public function getError() {
		
	}
}
?>