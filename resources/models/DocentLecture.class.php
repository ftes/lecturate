<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");

class DocentLecture extends Model {
	private static $name = "docent_lecture";

	public function __construct() {
		parent::__construct(self::$name);

		$id = new Int("id", false, true, 0, false);
		$dId = new Int("d_id", false, false, 0, false);
		$lId = new Int("l_id", false, false, 0, false);
		$this->addAttribute($id);
		$this->addAttribute($dId);
		$this->addAttribute($lId);

		$this->addConstraint(new PrimaryKey(array($id)));
		$this->addConstraint(new Unique("Dozent hält Vorlesung", array($dId, $lId)));
		$docent = new Docent();
		$lecture = new Lecture();
		$this->addConstraint(new ForeignKey(array($dId), $docent, array($docent->getAttribute("id"))));
		$this->addConstraint(new ForeignKey(array($lId), $lecture, array($lecture->getAttribute("id"))));
	}
	
	public static function findByOtpw($otpw) {
		$class = Util::camelCase(self::$name);
		$model = new $class;
	
		$query = "SELECT {$model->getAttrList("dl")} FROM `" . self::$name . "` dl INNER JOIN `otpw` o ON dl.`id`=o.`dl_id`  WHERE o.`otpw`='%s'";
		$values = array($otpw);
	
		$result = self::findBy($query, $values, self::$name);

		return count($result) == 0 ? false : $result[0];
	}

	public static function findById($id) {
		$class = Util::camelCase(self::$name);
		$model = new $class;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "` WHERE `id`='%d'";
		$values = array($id);
		
		$result = self::findBy($query, $values, self::$name);
		return count($result) == 0 ? false : $result[0];
	}
	
	public function toString() {
		$docent = Docent::findById($this->getValue("d_id"))->toString();
		$lecture = Lecture::findById($this->getValue("l_id"))->toString();
		return "$docent - $lecture";
	}

	public static function findAll() {
		$class = Util::camelCase(self::$name);
		$model = new $class;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "`";
		$values = array();

		return self::findBy($query, $values, self::$name);
	}
}
?>