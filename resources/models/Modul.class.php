<?php
require_once(LIBRARY_PATH."/sql.php");
require_once("Model.class.php");

class Modul extends Model {
	/**
	 * FK default = false
	 * nullable default = false
	 * PK default = false
	 */
	private $id = array(
			Model::TYPE => Model::INT,
			Model::PK => true,
			Model::AI => true,
			Model::VALUE => null
			);
	
	public function getIdDef() {
		return $this->id;
	}
	
	private $name = array(
			Model::UQ => true,
			Model::TYPE => Model::VARCHAR,
			Model::MAXLEN => 30,
			Model::MINLEN => 2,
			Model::VALUE => null
			);
	
	public function getNameDef() {
		return $this->name;
	}
	
	public function __construct($id = false) {
		if ($id && $result = exists("SELECT id, name FROM modul WHERE id=?", "i", $id)) {
			$this->id[Model::VALUE] = intval($result['id']);
			$this->name[Model::VALUE] = $result['name'];
			$this->alreadyPersisted = true;
		}
	}
	
	public function getId() {
		return $this->id[Model::VALUE];
	}
	
	public function getName() {
		return $this->name[Model::VALUE];
	}
	
	public function setName($name) {
		if (! Model::isValidValue($name, $this->name)) return false;
		if (exists("SELECT name FROM modul WHERE name=?", "s", $name))
			return false;
		$this->name[Model::VALUE] = $name;
		return true;
	}
	
	protected function isValid() {
		if (! Model::isValidValue($this->name)) return false;
	}
	
	public function persist() {
		if ($this->alreadyPersisted)
			result("UPDATE modul SET name=? WHERE id=?", "si", $this->name[Model::VALUE], $this->id[MODEL::VALUE]);
		else {
			$this->id[Model::VALUE] = result("INSERT INTO modul (name) VALUES (?)", "s", $this->name[Model::VALUE]);
		}
		return true;
	}
	
	public static function delete($id) {
		return (result("DELETE FROM modul WHERE id=?", "i", $id) > 0);
	}
	
	public static function getAll() {
		return result("SELECT id, name FROM modul", "");
	}
	
	public function get() {
		return array("id" => $this->id[Model::VALUE],
				"name" => $this->name[Model::VALUE]);
	}
	
	public static function read($id) {
		$modul = new Modul($id);
		if ($modul->alreadyPersisted) return $modul;
		return false;
	}
	
}
?>