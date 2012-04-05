<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");
class Module extends Model {
	private $id;
	private $token;
	
	public function __construct() {
		parent::__construct('module');
		
		$this->id = new Attribute("id", new Int($nullable=false, $autoIncrement=true));
		$this->token = new Attribute("token", new Varchar($minLength=2, $maxLength=10, $nullable=false));
		$this->addAttribute($this->id);
		$this->addAttribute($this->token);
		
		$this->addConstraint(new PrimaryKey(array($this->id)));
 		$this->addConstraint(new Unique(array($this->token)));
	}
	
	public static function findById($id) {
		$query = "SELECT id, token FROM module WHERE id='%d'";
		$values = array($id);
		return self::findBy($query, $values, "Module");
	}
	
	public static function findAll() {
		$query = "SELECT id, token FROM module";
		$values = array();
		return self::findBy($query, $values, "Module");
	}
}
?>