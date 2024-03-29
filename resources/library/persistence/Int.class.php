<?php
class Int extends Attribute {
	private $min;
	private $max;

	public function __construct($name, $nullable=true, $autoIncrement=false,
			$min=false, $max=false) {
		parent::__construct($name, "INT", $nullable, $autoIncrement);

		$this->min = $min;
		$this->max = $max;
	}

	public function getMin() {
		return $this->min;
	}

	public function getMax() {
		return $this->max;
	}

	public function getSql() {
		return "`$this->name` $this->sqlType" . $this->getNullableSql() . $this->getAutoIncrementSql();
	}

	public function generateErrors() {
		$this->errors = array();
		if (is_null($this->value)) {
			if (! $this->nullable && ! $this->autoIncrement)
				array_push($this->errors, "Darf nicht leer sein");
		} else {
			if ($this->value != "0" && intval($this->value) == 0) {
				array_push($this->errors, "Keine Zahl");
			} else {
				$value = intval($this->value);
				if ($this->max && $this->value > $this->max)
					array_push($this->errors, "Zu groß (max. {$this->max})");
				if ($this->min && $this->value < $this->min)
					array_push($this->errors, "Zu klein (min. {$this->min})");
			}
		}
	}

	public function getFormatter() {
		return "%d";
	}
}
?>