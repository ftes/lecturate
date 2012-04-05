<?php
class Model {
	private $name;
	private $attributes = array();
	private $primaryKey = null;
	private $constraints = array();

	public function __construct($name) {
		if (! is_string($name))
			throw new Exception("Model: \$name hast to be STRING");

		$this->name = $name;
	}

	public function addAttribute(Attribute $attribute) {
		if (array_key_exists($attribute->getName(), $this->attributes))
			throw new Exception("Model->addAttribute: attribute name already exists");

		$this->attributes[$attribute->getName()] = $attribute;
	}

	public function addConstraint(Constraint $constraint) {
		if ($constraint instanceof PrimaryKey)
			$this->primaryKey = $constraint;

		array_push($this->constraints, $constraint);
	}

	public function getSql() {
		$sql = "CREATE TABLE {$this->name} (";
		$sql .= Enum::enum($this->attributes, "getSql");
		$sql .= ",";
		$sql .= Enum::enum($this->constraints, "getSql");
		$sql .= ");";

		return $sql;
	}

	public function getName() {
		return $this->name;
	}

	public function getAttributes() {
		return $attributes;
	}

	public function setValue($attributeName, $value) {
		$attribute = $this->attributes[$attributeName];
		$attribute->setValue($value);
	}

	public function persist() {
		$errors = array();
		foreach ($this->attributes as $attribute)
			if (! $attribute->isValidValue()) array_push($errors, $attribute);
// 		foreach ($this->constraints as $constraint)
// 			if (! $constraint->isSatisfied($this->name)) array_push($errors, $constraint);

		if (count($errors) == 0) {
			//Insert or Update?
// 			$sql = Sql::execute("SELECT");

// 			foreach ($this->attributes as $attribute) $attribute->unalter();
			return true;
		}

		return $errors;
	}
}
?>