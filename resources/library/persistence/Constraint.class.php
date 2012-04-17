<?php

/**
 * Model constraint, based on MYSQL constraints
 * @author lecturate
 *
 */
abstract class Constraint {
	protected $name;
	protected $attributes;
	
	public function __construct($name, array $attributes) {
		$this->name = $name;
		$this->attributes = $attributes;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public abstract function getSql();
	
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