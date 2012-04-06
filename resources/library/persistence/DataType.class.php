<?php
abstract class DataTypeOLD {
	protected $sqlType;
	protected $nullable;
	protected $autoIncrement;
	
	public function __construct($sqlType, $nullable=true, $autoIncrement=false) {
		if (! is_string($sqlType))
			throw new Exception("DataType: \$sqlType has to be STRING");
		$this->sqlType = $sqlType;
		$this->setNullable($nullable);
		
		if (! is_bool($autoIncrement))
			throw new Exception("DataType: \$autoIncrement has to be BOOL");
		$this->autoIncrement = $autoIncrement;
	}
	
	protected function getNullableSql() {
		if ($this->nullable)
			return "";
		return " NOT NULL";
	}
	
	protected function getAutoIncrementSql() {
		$string = "";
		if ($this->autoIncrement) $string = " AUTO_INCREMENT";
		return $string;
	}
	
	public function getNullable() {
		return $this->nullable;
	}
	
	public function getAutoIncrement() {
		return $this->autoIncrement;
	}
	
	public function setNullable($nullable) {
		if (! is_bool($nullable))
			throw new Exception("DataType: \$nullable has to be BOOL");
		$this->nullable = $nullable;
	}
	
	public abstract function getSql();
	
	public abstract function getErrors($value);
	
	public static abstract function getFormatter();
}
?>