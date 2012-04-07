<?php
abstract class Model {
	private $name;
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
	
	public abstract function toString();

	public function getSql() {
		$sql = "CREATE TABLE `{$this->name}` (";
		$sql .= Util::enum($this->attributes, "getSql");
		$sql .= ",";
		$sql .= Util::enum($this->constraints, "getSql");
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
		return Util::enum($this->attributes, "getName");
	}
	
	private function inSync() {
		foreach ($this->attributes as $attribute)
			$attribute->unalter();
		$this->new = false; 
	}

	public function persist() {
		$this->errors = array();
		$attrError = false;
		
		foreach ($this->attributes as $attribute)
			if (! $attribute->isValid()) $attrError = true;			
		foreach ($this->constraints as $constraint) {
			$error = $constraint->getError($this->name);
			if ($error) $this->errors[$constraint->getName()] = $error;
		}

		if (count($this->errors) > 0 || $attrError) return false;

		//Insert
		if ($this->new) {
			$attrs = $this->getNonAutoIncrementAttributes();

			$values = Util::getArray($attrs, "getValue");
			$names = Util::enum($attrs, "getName");
			$formatters = Util::enum($attrs, "getFormatter", ",", "'", "'");

			$sql = Sql::execute("INSERT INTO `$this->name` ($names) VALUES ($formatters)", $values);

			if ($sql->getResult() == false) {
				$this->errors["Persistance"] = "Error when persisting";
				return false;
			}

			$attrs = $this->primaryKey->getAttributes();
			if ($attrs[0]->getAutoIncrement()) {
				$attrs[0]->setValue($sql->getLastId());
			}
			//Update
		} else {
			$valuesOld = Util::getArray($this->primaryKey->getAttributes(), "getOldValue");
			$compsOld = Util::enum($this->primaryKey->getAttributes(), "getComparator", " AND ");

			$valuesNew = Util::getArray($this->attributes, "getValue");
			$setsNew = Util::enum($this->attributes, "getComparator", ",");

			$values = array_merge($valuesNew, $valuesOld);
			$sql = Sql::execute("UPDATE `$this->name` SET $setsNew WHERE $compsOld",$values);

			if ($sql->getResult() == false) {
				$this->errors["Persistance"] = "Error when persisting";
				return false;
			}
		}

		$this->inSync();
		return true;
	}
	
	public function getPrimaryKey() {
		return $this->primaryKey;
	}

	public function delete() {
		if ($this->new) return false;

		$values = Util::getArray($this->primaryKey->getAttributes(), "getValue");
		$comps = Util::enum($this->primaryKey->getAttributes(), "getComparator", " AND ");

		$sql = Sql::execute("DELETE FROM `$this->name` WHERE $comps", $values);

		if ($sql->getResult() == false) return false;

		return true;
	}

	protected static function findBy($query, array $values, $type) {
		$sql = Sql::execute($query, $values);
		$result = $sql->getResult();

		if ($result == false) throw new Exception("Error in Finder");
// 		if ($result->num_rows == 0) return array();

		$arr = array();
		$type = Util::camelCase($type);
		while (($row = $result->fetch_assoc()) != null) {
			$model = new $type;
				
			foreach($row as $key => $value)
				$model->setValue($key, $value);
			
			$model->inSync();
				
			array_push($arr, $model);
		}

		return $arr;
	}
}
?>