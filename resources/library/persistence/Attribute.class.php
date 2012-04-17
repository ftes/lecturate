<?php

/**
 * Abstract class for attributes
 * Handles data validation, data storage, SQL generation etc.
 * @author lecturate
 *
 */
abstract class Attribute {
	/**
	 * name of the attribute (column name)
	 * @var string
	 */
	protected $name;
	
	/**
	 * current value
	 * @var unknown_type
	 */
	protected $value = null;
	
	/**
	 * old value: used for resetting, if check fails
	 * @var unknown_type
	 */
	protected $oldValue = null;
	
	/**
	 * has value been altered since reading from DB?
	 * @var boolean
	 */
	protected $altered = false;
	
	/**
	 * error messages
	 * @var array
	 */
	protected $errors = array();
	
	/**
	 * what is the corresponding data type in MYSQL
	 * @var string
	 */
	protected $sqlType;
	
	/**
	 * is this attribute nullable?
	 * @var boolean
	 */
	protected $nullable;
	
	/**
	 * should the attribute get auto incremented
	 * @var boolean
	 */
	protected $autoIncrement;

	public function __construct($name, $sqlType, $nullable=true,
			$autoIncrement=false) {
		if (! is_string($name))
			throw new Exception("Attribute: \$name has to be STRING");

		$this->name = $name;

		if (! is_string($sqlType))
			throw new Exception("Attribute: \$sqlType has to be STRING");
		$this->sqlType = $sqlType;
		$this->setNullable($nullable);

		if (! is_bool($autoIncrement))
			throw new Exception("Attribute: \$autoIncrement has to be BOOL");
		$this->autoIncrement = $autoIncrement;
	}

	public function getName() {
		return $this->name;
	}

	public function getValue() {
		return $this->value;
	}

	public function setValue($value) {
		if ($this->value == $value) return false;

		if (! $this->altered) {
			$this->altered = true;
			$this->oldValue = $this->value;
		}

		$this->value = $value;
	}

	public function unalter() {
		$this->altered = false;
	}

	public function getAltered() {
		return $this->altered;
	}

	public function getOldValue() {
		if ($this->altered) return $this->oldValue;
		return $this->value;
	}

	public function isValid() {
		$this->generateErrors();
		return (count($this->errors) == 0);
	}

	public function getErrors() {
		return $this->errors;
	}

	
	/**
	 * used in SELECT, UPDATE, DELETE and INSERT statements
	 */
	public function getComparator() {
		return "`$this->name`='" . $this->getFormatter() . "'";
	}

	
	/**
	 * get printf-Formatter (%s, %d etc)
	 */

	public abstract function getFormatter();


	protected function getNullableSql() {
		if ($this->nullable)
			return "";
		return " NOT NULL";
	}

	protected function getAutoIncrementSql() {
		$string = "";
		if ($this->autoIncrement) $string = " AUTO_INCREMENT";
		return $string;
	}

	public function getNullable() {
		return $this->nullable;
	}

	public function getAutoIncrement() {
		return $this->autoIncrement;
	}

	public function setNullable($nullable) {
		if (! is_bool($nullable))
			throw new Exception("Attribute: \$nullable has to be BOOL");
		$this->nullable = $nullable;
	}

	public abstract function getSql();

	public abstract function generateErrors();
}
?>
