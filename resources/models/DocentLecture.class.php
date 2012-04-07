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
		$this->addConstraint(new Unique("Docent holds Lecture", array($dId, $lId)));
		$docent = new Docent();
		$lecture = new Lecture();
		$this->addConstraint(new ForeignKey(array($dId), $docent, array($docent->getAttribute("id"))));
		$this->addConstraint(new ForeignKey(array($dId), $lecture, array($lecture->getAttribute("id"))));
	}

	public static function findById($id) {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "` WHERE `id`='%d'";
		$values = array($id);
		
		$result = self::findBy($query, $values, self::$name);
		return count($result) == 0 ? false : $result[0];
	}
	
	public function toString() {
		return $this->getValue("firstname")." ".$this->getValue("lastname");
	}

	public static function findAll() {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "`";
		$values = array();

		return self::findBy($query, $values, self::$name);
	}
}
?>