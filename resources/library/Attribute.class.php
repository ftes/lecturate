<?php
class Attribute {
	private $dataType;
	private $name;
	
	public function __construct($name, DataType $dataType) {
		if (! is_string($name))
			throw new Exception("Attribute: \$name has to be STRING");
		
		$this->name = $name;
		$this->dataType = $dataType;
	}
	
	public function getSQL() {
		return "$name $dataType::getSQL()";
	}
	
	public function getName() {
		return $name;
	}
}
?>