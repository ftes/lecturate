<?php
abstract class DataType {
	protected $sqlType;
	protected $nullable;
	
	public function __construct($sqlType, $nullable) {
		if (! is_string($sqlType))
			throw new Exception("DataType: \$sqlType has to be STRING");
		if (! is_bool($nullable))
			throw new Exception("DataType: \$nullable has to be BOOL");
		$this->sqlType = $sqlType;
		$this->nullable = $nullable;
	}
	
	protected function getNullableSQL() {
		if ($this->nullable)
			return "";
		else
			return "NOT NULL";
	}
	
	public abstract function getSQL();
	
	public abstract function isValidValue($value);
}
?>