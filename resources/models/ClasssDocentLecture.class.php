<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");

class ClasssDocentLecture extends Model {
	private static $name = "classs_docent_lecture";

	public function __construct() {
		parent::__construct(self::$name);

		$id = new Int("id", false, true, 0, false);
		$cId = new Int("c_id", false, false, 0, false);
		$dlId = new Int("dl_id", false, false, 0, false);
		$this->addAttribute($id);
		$this->addAttribute($cId);
		$this->addAttribute($dlId);

		$this->addConstraint(new PrimaryKey(array($id)));
		$this->addConstraint(new Unique("Kurs hört gehaltene Vorlesung", array($cId, $dlId)));
		$classs = new Classs();
		$docentLecture = new DocentLecture();
		$this->addConstraint(new ForeignKey(array($cId), $classs, array($classs->getAttribute("id"))));
		$this->addConstraint(new ForeignKey(array($dlId), $docentLecture, array($docentLecture->getAttribute("id"))));
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
		$classs = Classs::findById($this->getValue("c_id"))->toString();
		$docentLecture = DocentLecture::findById($this->getValue("dl_id"))->toString();
		return "$classs - $docentLecture";
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