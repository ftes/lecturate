<?php
class Varchar extends Attribute {
	private $maxLength;
	private $minLength;
	
	public function __construct($name, $nullable=true, $minLength=false, $maxLength=false) {
		parent::__construct($name, "VARCHAR", $nullable);
		
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;
	}
	
	public function getMinLength() {
		return $this->minLength;
	}
	
	public function getMaxLength() {
		return $this->maxLength;
	}
	
	public function getSql() {
		return "`$this->name` $this->sqlType ($this->maxLength)" . $this->getNullableSQL();
	}
	
	public function generateErrors() {
		$this->errors = array();
		if (is_null($this->value)) {
			if (! $this->nullable)
				array_push($this->errors, "Darf nicht leer sein");
		} else {
			if (! is_string($this->value)) {
				array_push($this->errors, "Ist kein Text");
			} else {
				if ($this->maxLength && strlen($this->value) > $this->maxLength) array_push($this->errors, "Zu lang (max. {$this->maxLength})");
				if ($this->minLength && strlen($this->value) < $this->minLength) array_push($this->errors, "Zu kurz (min. {$this->minLength})");
			}
		}
	}
	
	public function getFormatter() {
		return "%s";
	}
}
?>