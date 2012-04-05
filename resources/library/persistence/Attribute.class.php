<?php
class Attribute {
	private $dataType;
	private $name;
	private $value = null;
	private $oldValue = null;
	private $altered = false;
	
	public function __construct($name, DataType $dataType, $value=null) {
		if (! is_string($name))
			throw new Exception("Attribute: \$name has to be STRING");
		
		$this->name = $name;
		$this->dataType = $dataType;
		$this->value = $value;
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
// 		if ($this->dataType->getAutoIncrement()) throw new Exception("Do not alter autoincrement attribute");
		
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
	
	public function getOldValue() {
		if ($this->altered) return $this->oldValue;
		return $this->value;
	}
	
	public function checkValue() {
		$this->dataType->checkValue($this->value);
	}
	
	public function getError() {
		
	}
	
	public function getComparator() {
		return $this->name . "='" . $this->getDataType()->getFormatter() . "'";
	}
	
	public function getFormatter() {
		return $this->dataType->getFormatter();
	}
}
?>