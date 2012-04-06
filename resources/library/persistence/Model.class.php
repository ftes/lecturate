<?php
abstract class Model {
	protected $name;
	protected $attributes = array();
	protected $primaryKey = null;
	protected $constraints = array();
	protected $new = true;
	private $errors = array();

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
		if (array_key_exists($constraint->getName(), $this->constraints))
			throw new Exception("Model->addConstraint: constraint name already exists");
		
		if ($constraint instanceof PrimaryKey)
			$this->primaryKey = $constraint;

		$this->constraints[$constraint->getName()] = $constraint;
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
		return $this->attributes;
	}
	
	public function getAttribute($name) {
		if (! array_key_exists($name, $this->attributes)) return false;
		return $this->attributes[$name];
	}
	
	public function getErrors() {
		return $this->errors;
	}

	public function getNonAutoIncrementAttributes() {
		$attrs = array();
		foreach ($this->attributes as $attribute)
			if (! $attribute->getAutoIncrement())
			array_push($attrs, $attribute);
		return $attrs;
	}

	public function setValue($attributeName, $value) {
		if (! array_key_exists($attributeName, $this->attributes)) return false;
		$attribute = $this->attributes[$attributeName];
		$attribute->setValue($value);
	}

	public function getValue($attributeName) {
		if (! array_key_exists($attributeName, $this->attributes)) return false;
		$attribute = $this->attributes[$attributeName];
		return $attribute->getValue();
	}

	public function getAttrList() {
		return Enum::enum($this->attributes, "getName");
	}

	public function persist() {
		$this->errors = array();
		$attrError = false;
		
		foreach ($this->attributes as $attribute)
			//Don't check constraints if there are invalid attributes
			if (! $attribute->isValid()) $attrError = true;
		foreach ($this->constraints as $constraint) {
			$error = $constraint->getError($this->name);
			if ($error) $this->errors[$constraint->getName()] = $error;
		}

		if (count($this->errors) > 0 || $attrError) return false;

		//Insert
		if ($this->new) {
			$attrs = $this->getNonAutoIncrementAttributes();

			$values = Enum::getArray($attrs, "getValue");
			$names = Enum::enum($attrs, "getName");
			$formatters = Enum::enum($attrs, "getFormatter", ",", "'", "'");

			$sql = Sql::execute("INSERT INTO $this->name ($names) VALUES ($formatters)", $values);

			if ($sql->getResult() == false) {
				$this->errors["Persistance"] = "Error when persisting";
				return false;
			}

			$this->new = false;
			$attrs = $this->primaryKey->getAttributes();
			if ($attrs[0]->getAutoIncrement()) {
				$attrs[0]->setValue($sql->getLastId());
			}
			//Update
		} else {
			$valuesOld = Enum::getArray($this->primaryKey->getAttributes(), "getOldValue");
			$compsOld = Enum::enum($this->primaryKey->getAttributes(), "getComparator", " AND ");

			$valuesNew = Enum::getArray($this->attributes, "getValue");
			$setsNew = Enum::enum($this->attributes, "getComparator", ",");

			$values = array_merge($valuesNew, $valuesOld);
			$sql = Sql::execute("UPDATE $this->name SET $setsNew WHERE $compsOld",$values);

			if ($sql->getResult() == false) {
				$this->errors["Persistance"] = "Error when persisting";
				return false;
			}
		}

		foreach ($this->attributes as $attribute) $attribute->unalter();
		return true;
	}

	public function delete() {
		if ($this->new) return array("Delete" => "Wasn't yet persisted");

		$values = Enum::getArray($this->primaryKey->getAttributes(), "getValue");
		$comps = Enum::enum($this->primaryKey->getAttributes(), "getComparator", " AND ");

		$sql = Sql::execute("DELETE FROM $this->name WHERE $comps", $values);

		if ($sql->getResult() == false) return array("Delete" => "Error when deleting");

		return true;
	}

	protected static function findBy($query, array $values, $type) {
		$sql = Sql::execute($query, $values);
		$result = $sql->getResult();

		if ($result == false) throw new Exception("Error in Finder");
		if ($result->num_rows == 0) return false;

		$arr = array();
		while (($row = $result->fetch_assoc()) != null) {
			$model = new $type;
			$model->new = false;
				
			foreach($row as $key => $value)
				$model->setValue($key, $value);
				
			array_push($arr, $model);
		}

		if (count($arr) == 1) return $arr[0];
		return $arr;
	}
}
?>