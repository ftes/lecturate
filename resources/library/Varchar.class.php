<?php
class Varchar extends DataType {
	private $maxLength;
	
	public function __construct($maxLength, $nullable) {
		parent::__construct("VARCHAR", $nullable);
		
		if (! is_int($maxLength))
			throw new Exception("Varchar: \$maxLength has to be INT");
		
		$this->maxLength = $maxLength;
	}
	
	public function getSQL() {
		return "$this->sqlType ($maxLength) $this::getNullableSQL()";
	}
}
?>