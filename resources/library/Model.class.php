<?php
class Model {
	private $name;
	private $attributes = array();
	
	public static function createTables() {
		$dbConn = Config::getDbConn();
		
		foreach (Model::$models as $name => $model) {
			$dbConn->query($model->getDropSQL());
			$dbConn->query($model->getCreateSQL());
		}
		
		$dbConn->close();
	}
	
	public function __construct($name) {
		if (! is_string($name))
			throw new Exception("Model: \$name hast to be STRING");
		
		if (array_key_exists($name, Model::$models))
			throw new Exception("Model: model name already exists");
		
		Model::$models[$name] = $this;
		
		$this->name = $name;
	}
	
	public function addAttribute(Attribute $attribute) {
		if (array_key_exists($attribute->getName(), $this->attributes))
			throw new Exception("Model->addAttribute: attribute name already exists");
		
		if (strtolower($attribute->getName()) == "id")
			throw new Exception("Model->addAttribute: id is a reserved attribute name");
		
		$this->attributes[$attribute->getName()] = $attribute;
	}
	
	public function getCreateSQL() {
		$sql = "CREATE TABLE $this->name (".
			"id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, ";
		foreach ($this->attributes as $name => $attribute) {
			$sql .= "{$attribute->getSQL()}, ";
		}
		$sql = substr($sql, 0, strlen($sql) - 2);
		$sql .= ");";
		
		return $sql;
	}
	
	public function getDropSQL() {
		$sql = "DROP TABLE IF EXISTS {$this->name};";
		return $sql;
	}
		
	public function getName() {
		return $this->name;
	}
}
?>