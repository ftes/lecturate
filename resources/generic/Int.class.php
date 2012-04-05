<?php
class Int extends DataType {
	
	public function __construct($nullable=true, $autoIncrement=false) {
		parent::__construct("INT", $nullable, $autoIncrement);
	}
	
	public function getSql() {
		return $this->sqlType . $this->getNullableSql() . $this->getAutoIncrementSql();
	}
	
	public function checkValue($value) {
		if (is_null($value) && ($this->nullable || $this->autoIncrement)) return true;
		if (! is_int($value)) throw new Exception("Not an Int");
		return true;
	}
	
	public static function getFormatter() {
		return "%d";
	}
}
?>