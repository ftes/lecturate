<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");

class Otpw extends Model {
	private static $name = "otpw";

	public function __construct() {
		parent::__construct(self::$name);

		$id = new Int("id", false, true, 0, false);
		$otpw = new Varchar("otpw", false, 1, 30);
		$dlId = new Int("dl_id", false, false, 0, false);
		$used = new Bool("used", false, true, Bool::F);
		$created = new Timestamp("created", true, false);
		$usedTs = new Timestamp("used_ts", false, false);
		$this->addAttribute($id);
		$this->addAttribute($otpw);
		$this->addAttribute($dlId);
		$this->addAttribute($used);
		$this->addAttribute($created);
		$this->addAttribute($usedTs);

		$this->addConstraint(new PrimaryKey(array($id)));
		$this->addConstraint(new Unique("Einmal-PW", array($otpw)));
		$docentLecture = new DocentLecture();
		$this->addConstraint(new ForeignKey(array($dlId), $docentLecture, array($docentLecture->getAttribute("id"))));
	}
	
	public function setUsed() {
		$this->setValue("used", Bool::T);
		$this->setValue("used_ts", date('Y-m-d H-i-s'));
	}

	public static function findById($id) {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "` WHERE `id`='%d'";
		$values = array($id);
		
		$result = self::findBy($query, $values, self::$name);
		return count($result) == 0 ? false : $result[0];
	}
	
	public function toString() {
		return $this->getValue("otpw");
	}

	public static function findAll() {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "`";
		$values = array();

		return self::findBy($query, $values, self::$name);
	}
}
?>