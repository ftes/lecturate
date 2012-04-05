<?php
abstract class Model {
	const PK = "PRIMARY KEY";
	const FK = "FOREIGN KEY";
	const UQ = "UNIQUE";
	const FKMODEL = "REFERENCES MODEL";
	const FKCOL = "REFERENCES COLUMN";
	const NULLABLE = "NULLABLE";
	const TYPE = "TYPE";
	const VARCHAR = "VARCHAR";
	const INT = "INT";
	const MAXLEN = "MAXIMUM LENGTH";
	const MINLEN = "MINIMUM LENGTH";
	const AI = "AUTO INCREMENT";
	const VALUE = "VALUE";
	
	protected $alreadyPersisted = false;
	
	public static function isValidValue($value, array $a) {
		//all default to false
// 		$pk = 		getFromArray($a, self::PK);
// 		$fk = 		getFromArray($a, self::FK);
// 		$uq = 		getFromArray($a, self::UQ);
		$nullable = self::getFromArray($a, self::NULLABLE);
// 		$value =	self::getFromArray($a, self::VALUE);
		$maxlen =	self::getFromArray($a, self::MAXLEN);
		$minlen =	self::getFromArray($a, self::MINLEN);
// 		$ai =	getFromArray($a, self::AI);
		
		if (! array_key_exists(self::TYPE, $a)) throw new Exception("No attribute type defined");
		$type = $a[self::TYPE];
		
		if (! $nullable && is_null($value)) return false;
		
		switch ($type) {
			case self::VARCHAR:
				if (is_string($value)) {
					if ($maxlen && strlen($value) > $maxlen)  return false;
					if ($minlen && strlen($value) < $minlen)  return false;
				}
				break;
				
			case self::INT:
				if (! is_int($value)) return false;
		}
		return true;
	}
	
	public static function getFromArray($array, $key) {
		if (array_key_exists($key, $array)) return $array[$key];
		return false;
	}
	
	protected abstract function isValid();
	
	public abstract function get();	
	
	public static abstract function getAll();
	
	public static abstract function delete($id);
	
	public static abstract function read($id);
	
	public abstract function persist();
}
?>