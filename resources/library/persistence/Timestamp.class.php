<?php
class Timestamp extends Attribute {
	private $onCreate;
	private $onUpdate;

	public function __construct($name, $onCreate=false, $onUpdate=false) {
		parent::__construct($name, "TIMESTAMP", false, $onCreate || $onUpdate);

		$this->onCreate = $onCreate ? " DEFAULT CURRENT_TIMESTAMP" : " DEFAULT 0";
		$this->onUpdate = $onUpdate ? " ON UPDATE CURRENT_TIMESTAMP" : "";
	}

	public function getMin() {
		return $this->min;
	}

	public function getMax() {
		return $this->max;
	}

	public function getSql() {

		return "`$this->name` $this->sqlType" . $this->onCreate . $this->onUpdate;
	}

	public function generateErrors() {
	}

	public function getFormatter() {
		return "%s";
	}
}
?>