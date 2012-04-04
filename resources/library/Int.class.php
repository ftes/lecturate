<?php
class Int extends DataType {
	
	public function __construct($nullable) {
		parent::__construct("INT", $nullable);
	}
	
	public function getSQL() {
		return "{$this->sqlType} {$this->getNullableSQL()}";
	}
	
	public function isValidValue($value) {
		if (! is_int($value)) return false;
		return true;
	}
}
?>