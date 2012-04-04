<?php
class Int extends DataType {
	
	public function __construct($nullable) {
		parent::__construct("INT", $nullable);
	}
	
	public function getSQL() {
		return "$this->sqlType $this::getNullableSQL()";
	}
}
?>