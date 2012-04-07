<?php
abstract class Attribute {
	protected $name;
	protected $value = null;
	protected $oldValue = null;
	protected $altered = false;
	protected $errors = array();
	protected $sqlType;
	protected $nullable;
	protected $autoIncrement;
	
	public function __construct($name, $sqlType, $nullable=true, $autoIncrement=false) {
		if (! is_string($name))
			throw new Exception("Attribute: \$name has to be STRING");
		
		$this->name = $name;
		
		if (! is_string($sqlType))
			throw new Exception("Attribute: \$sqlType has to be STRING");
		$this->sqlType = $sqlType;
		$this->setNullable($nullable);
		
		if (! is_bool($autoIncrement))
			throw new Exception("Attribute: \$autoIncrement has to be BOOL");
		$this->autoIncrement = $autoIncrement;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getValue() {
		return $this->value;
	}
	
	public function setValue($value) {
		if ($this->value == $value) return false;
		
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
	
	public function isValid() {
		$this->generateErrors();
		return (count($this->errors) == 0);
	}
	
	public function getErrors() {
		return $this->errors;
	}
	
	public function getComparator() {
		return "`$this->name`='" . $this->getFormatter() . "'";
	}
	
	public abstract function getFormatter();
	
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
			throw new Exception("Attribute: \$nullable has to be BOOL");
		$this->nullable = $nullable;
	}
	
	public abstract function getSql();
	
	public abstract function generateErrors();
}
?>