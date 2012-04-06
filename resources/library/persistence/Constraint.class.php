<?php
abstract class Constraint {
	private $name;
	protected $attributes;
	
	public function __construct($name, array $attributes) {
		$this->name = $name;
		$this->attributes = $attributes;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public abstract function getSQL();
	
	public abstract function getError($modelName);
	
	public function getAlteredAttributes() {
		$array = array();
		
		foreach ($this->attributes as $attribute)
			if ($attribute->getAltered()) array_push($array, $attribute);
		
		return $array;
	}
	
	public function getAttributes() {
		return $this->attributes;
	}
}
?>