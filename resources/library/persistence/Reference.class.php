<?php
class Reference extends Attribute {
	private $referencedModel;
	private $attributes = array();
	private $foreignKey;
	
	public function __construct($name, $nullable=true, Model $referencedModel) {
		parent::__construct($name, "", $nullable, false);
		$this->referencedModel = $referencedModel;
		
		foreach ($referencedModel->getPrimaryKey()->getAttributes() as $attribute)
			$this->attributes[$attribute->getName()] = clone $attribute;
		
		$refAttrs = $referencedModel->getPrimaryKey()->getAttributes();
		$this->foreignKey = new ForeignKey($this->attributes, $docent, $refAttrs);
	}
	
	public function getForeignKey() {
		return $this->foreignKey;
	}
	
	public function getSql() {
		return Util::enum($this->attributes, "getSql");
	}
	
	public function generateErrors() {
		$this->errors = array();
		
		if (is_null($this->value)) {
			if (! $this->nullable && ! $this->autoIncrement)
				array_push($this->errors, "Cannot be empty");
		} else {
			if ($this->value != "0" && intval($this->value) == 0) {
				array_push($this->errors, "'$this->value' is not a number");
			} else {
				$value = intval($this->value);
				if ($this->max && $this->value > $this->max) array_push($this->errors, "Too large (max. {$this->max})");
				if ($this->min && $this->value < $this->min) array_push($this->errors, "Too small (min. {$this->min})");
			}
		}
	}
	
	public function getFormatter() {
		return "%d";
	}
}
?>