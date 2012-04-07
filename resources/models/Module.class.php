<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");

class Module extends Model {
	private static $name = "module";
	
	public function __construct() {
		parent::__construct(self::$name);
		
		$id = new Int("id", false, true, 0, false);
		$token = new Varchar("token", false, 2, 10);
		$inti = new Int("inti", true, false, 2, 10);
		$this->addAttribute($id);
		$this->addAttribute($token);
		$this->addAttribute($inti);
		
		$this->addConstraint(new PrimaryKey(array($id)));
 		$this->addConstraint(new Unique("Token", array($token)));
	}
	
	public static function findById($id) {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "` WHERE `id`='%d'";
		$values = array($id);
		
		$result = self::findBy($query, $values, self::$name);
		return count($result) == 0 ? false : $result[0];
	}
	
	public function toString() {
		return $this->getValue("token");
	}

	public static function findAll() {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "`";
		$values = array();

		return self::findBy($query, $values, self::$name);
	}
}
?>