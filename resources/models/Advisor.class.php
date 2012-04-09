<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");

class Advisor extends Model {
	private static $name = "advisor";

	public function __construct() {
		parent::__construct(self::$name);

		$id = new Int("id", false, true, 0, false);
		$username = new Varchar("username", false, 2, 30);
		$password = new Varchar("password", false, 5, 30);
		$firstname = new Varchar("firstname", false, 2, 30);
		$lastname = new Varchar("lastname", false, 2, 30);
		$this->addAttribute($id);
		$this->addAttribute($username);
		$this->addAttribute($password);
		$this->addAttribute($firstname);
		$this->addAttribute($lastname);

		$this->addConstraint(new PrimaryKey(array($id)));
		$this->addConstraint(new Unique("Benutzername", array($username)));
		$this->addConstraint(new Unique("Name", array($firstname, $lastname)));
	}

	public static function findById($id) {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "` WHERE `id`='%d'";
		$values = array($id);
		
		$result = self::findBy($query, $values, self::$name);
		return count($result) == 0 ? false : $result[0];
	}
	
	public function toString() {
		return $this->getValue("firstname") . " " . $this->getValue("lastname");
	}

	public static function findAll() {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "`";
		$values = array();

		return self::findBy($query, $values, self::$name);
	}
}
?>