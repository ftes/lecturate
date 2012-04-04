<?php
class Model {
	private $name;
	private $attributes = array();
	
	public function __construct($name) {
		if (! is_string($name))
			throw new Exception("Model: \$name hast to be STRING");
		
		$this->name = $name;
	}
	
	public function addAttribute(Attribute $attribute) {
		if (array_key_exists($attribute::getName(), $search))
			throw new Exception("Model::addAttribute: attribute name already exists");
		
		if (strtolower($attribute::getName()) == "id")
			throw new Exception("Model::addAttribute: id is a reserved attribute name");
		
		$attributes[$attribute::getName()] = $attribute;
	}
	
	public function getSQL() {
		$sql = "CREATE TABLE $name (".
			"id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,\n";
		foreach ($attributes as $name => $attribute) {
			$sql += $attribute::getSQL() . ",\n";
		}
		$sql = substr($sql, 0, strlen($sql) - 1);
		$sql += "\n);";
	}
		
	public function getName() {
		return $name;
	}
}
?>