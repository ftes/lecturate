<?php
require_once(LIBRARY_PATH . "/persistence/Model.class.php");
class Module extends Model {
	private $id;
	private $token;
	private $inti;
	
	public function __construct() {
		parent::__construct('module');
		
		$this->id = new Int("id", false, true, 0, false);
		$this->token = new Varchar("token", false, 2, 10);
		$this->inti = new Int("inti", true, false, 2, 10);
		$this->addAttribute($this->id);
		$this->addAttribute($this->token);
		$this->addAttribute($this->inti);
		
		$this->addConstraint(new PrimaryKey(array($this->id)));
 		$this->addConstraint(new Unique("Token", array($this->token)));
	}
	
	public static function findById($id) {
		$query = "SELECT id, token, inti FROM module WHERE id='%d'";
		$values = array($id);
		return self::findBy($query, $values, "Module");
	}
	
	public static function findAll() {
		$query = "SELECT id, token, inti FROM module";
		$values = array();
		return self::findBy($query, $values, "Module");
	}
}
?>