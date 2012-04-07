<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");

class Rating extends Model {
	private static $name = "rating";

	public function __construct() {
		parent::__construct(self::$name);

		$id = new Int("id", false, true, 0, false);
		$mark = new Int("mark", false, false, 0, 10);
		$created = new Timestamp("created", true, false);
		$oId = new Int("o_id", false, false, 0, false);
		$dlId = new Int("dl_id", false, false, 0, false);
		$comment = new Varchar("comment", true, false, 500);
		$this->addAttribute($id);
		$this->addAttribute($mark);
		$this->addAttribute($created);
		$this->addAttribute($oId);
		$this->addAttribute($dlId);
		$this->addAttribute($comment);

		$this->addConstraint(new PrimaryKey(array($id)));
		$this->addConstraint(new Unique("OTPW", array($oId)));
		$otpw = new Otpw();
		$docentLecture = new DocentLecture();
		$this->addConstraint(new ForeignKey(array($oId), $otpw, array($otpw->getAttribute("id"))));
		$this->addConstraint(new ForeignKey(array($dlId), $docentLecture, array($docentLecture->getAttribute("id"))));
	}

	public static function findById($id) {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "` WHERE `id`='%d'";
		$values = array($id);
		
		$result = self::findBy($query, $values, self::$name);
		return count($result) == 0 ? false : $result[0];
	}
	
	public function toString() {
		$otpw = Otpw::findById($this->getValue("o_id"))->toString();
		$docentLecture = DocentLecture::findById($this->getValue("dl_id"))->toString();
		return "$docentLecture ($otpw)";
	}

	public static function findAll() {
		$model = new self::$name;

		$query = "SELECT {$model->getAttrList()} FROM `" . self::$name . "`";
		$values = array();

		return self::findBy($query, $values, self::$name);
	}
}
?>