<?php
abstract class Constraint {
	protected $attributes;
	
	public function __construct(array $attributes) {
		$this->attributes = $attributes;
	}
	
	public abstract function getSQL();
	
	public abstract function check($modelName);
	
	public function getAlteredAttributes() {
		$array = array();
		
		foreach ($this->attributes as $attribute)
			if ($attribute->getAltered()) array_push($array, $attribute);
		
		return $array;
	}
}
?>