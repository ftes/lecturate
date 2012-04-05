<?php
class Varchar extends DataType {
	private $maxLength;
	private $minLength;
	
	public function __construct($minLength=-1, $maxLength=-1, $nullable=type) {
		parent::__construct("VARCHAR", $nullable);
		
		if (! is_int($minLength))
			throw new Exception("Varchar: \$minLength has to be INT");
		
		if (! is_int($maxLength))
			throw new Exception("Varchar: \$maxLength has to be INT");
		
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
	}
	
	public function getSQL() {
		return "{$this->sqlType} ($this->maxLength)" . $this->getNullableSQL();
	}
	
	public function checkValue($value) {
		if (is_null($value) && $this->nullable) return true;
		if (! is_string($value)) throw new Exception("Not a string");
		
		if (strlen($value) > $this->maxLength) throw new Exception("Maximum Length ($this->maxLength) exceeded");
		if (strlen($value) < $this->minLength) throw new Exception("Minimum Length ($this->minLength) undercut");
		return true;
	}
	
	public static function getFormatter() {
		return "%s";
	}
}
?>