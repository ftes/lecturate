<?php
class Bool extends Attribute {
	const F = 0;
	const T = 1;
	
	private $default;
	private $defaultValue;
	
	public function __construct($name, $nullable=true, $default=false, $defaultValue=false) {
		parent::__construct($name, "TINYINT", $nullable, false);
		
		$this->default = $default;
		$this->defaultValue = $defaultValue;
		
		if ($default) $this->value = $defaultValue;
	}
	
	public function getSql() {
		$default = $this->default ? " DEFAULT $this->defaultValue" : "";
		return "`$this->name` $this->sqlType" . $this->getNullableSql() . $default;
	}
	
	public function generateErrors() {
		$this->errors = array();
		if (is_null($this->value)) {
			if (! $this->nullable && ! $this->autoIncrement)
				array_push($this->errors, "Cannot be empty");
		} else {
			if ($this->value != "0" && intval($this->value) == 0) {
				array_push($this->errors, "'$this->value' is neither true nor false");
			} else {
				$value = intval($this->value);
				if ($this->value != 0 && $this->value != 1) array_push($this->errors, "Neither true nor false");
			}
		}
	}
	
	public function getFormatter() {
		return "%d";
	}
}
?>