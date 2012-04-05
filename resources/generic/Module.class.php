<?php
class Module extends Model {
	private $id;
	private $name;
	
	public function __construct() {
		parent::__construct('module');
		
		$this->id = new Attribute("id", new Int($nullable=false, $autoIncrement=true));
		$this->name = new Attribute("name", new Varchar($minLength=2, $maxLength=10, $nullable=false));
		$this->addAttribute($this->id);
		$this->addAttribute($this->name);
		
		$this->addConstraint(new PrimaryKey(array($this->id)));
 		$this->addConstraint(new Unique(array($this->name)));
	}
}
?>